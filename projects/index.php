<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

session_start();
if (isset($_SESSION['team'])) { $team_id = $_SESSION['team']; }
if (isset($_SESSION['project'])) { $project_id = $_SESSION['project']; }

// Get team information

connect();
$sql = "SELECT `id`, `name`, `description` FROM `teams` WHERE `teams`.`id` = '$team_id'";
$teams = mysqli_query($connection, $sql);
$team = mysqli_fetch_assoc($teams);

// Get projects

$sql = "SELECT * FROM `projects` WHERE `projects`.`team` = '$team_id'";
$projects = mysqli_query($connection, $sql);


?>

<?php require_once '../template-parts/header.php'; ?>

<?php if (mysqli_num_rows($projects)==0) : ?>
  <div uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <h3>It's quiet in here.</h3>
    <p>There doesn't seem to be anything here. Try adding a team. Or, after you&apos;ve selected a team, add a project.</p>
  </div>
<?php endif; ?>
<div uk-grid>
  <div>
    <?php if (mysqli_num_rows($teams)!=0) : ?>
      <p class="uk-text-bold"><?php echo mysqli_num_rows($projects); ?> Projects for</p>
      <h1><?php echo $team['name']; ?></h1>
      <p><?php echo $team['description']; ?></p>
    <?php endif; ?>
  </div>
  <div class="uk-width-expand uk-text-right">
    <?php if (mysqli_num_rows($teams)!=0) : ?>
      <a href="<?php echo ABSPATH; ?>/projects/add.php?teamid=<?php echo $team['id']; ?>" class="uk-button uk-button-primary">Add Project</a>
    <?php endif; ?>
    <a href="<?php echo ABSPATH; ?>/teams/add.php" class="uk-button uk-button-default">Add Team</a>
  </div>
</div>
<div class="uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
  <?php while ($project = mysqli_fetch_assoc($projects)) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-hover">
        <div class="uk-card-header">
          <p class="uk-text-right">
            <a href="<?php echo ABSPATH; ?>/projects/edit.php?projectid=<?php echo $project['id']; ?>&teamid=<?php echo $team['id']; ?>"><i class="far fa-wrench"></i></a>
            <a href="<?php echo ABSPATH; ?>/projects/delete.php?projectid=<?php echo $project['id']; ?>&teamid=<?php echo $team['id']; ?>"><i class="far fa-trash-alt"></i></a>
          </p>
          <h3 class="uk-card-title"><a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/comments/index.php"><?php echo $project['name']; ?></a></h3>
        </div>
        <div class="uk-card-body">
          <p><?php echo $project['description']; ?></p>
        </div>
        <div class="uk-card-footer">
          <p>
            <?php
              // Get number of comments

              $project_id = $project['id'];
              $sql = "SELECT * FROM `comments` WHERE `comments`.`project` = '$project_id'";
              $comments = mysqli_query ($connection, $sql);

            ?>
            <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/comments/index.php"><?php echo mysqli_num_rows($comments); ?> <i class="far fa-comment"></i></a>
          </p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php require_once '../template-parts/footer.php'; ?>
