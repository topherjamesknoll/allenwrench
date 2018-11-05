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

<div uk-grid>
  <div>
    <?php if (mysqli_num_rows($teams)!=0) : ?>
      <p class="uk-text-bold"><?php echo mysqli_num_rows($projects); ?> Projects for</p>
      <h1><?php if ($team['name']!='') : echo $team['name']; else : ?>Untitled<?php endif; ?></h1>
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
      <div class="uk-card uk-card-default uk-card-body uk-card-hover uk-card-small">
        <p class="uk-text-right">
          <a href="<?php echo ABSPATH; ?>/projects/edit.php?projectid=<?php echo $project['id']; ?>&teamid=<?php echo $team['id']; ?>"><i class="far fa-wrench"></i></a>
          <a href="<?php echo ABSPATH; ?>/projects/delete.php?projectid=<?php echo $project['id']; ?>&teamid=<?php echo $team['id']; ?>"><i class="far fa-trash-alt"></i></a>
        </p>
        <h2 class="uk-card-title">
          <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/tasks/index.php">
            <?php if ($project['name']!='') : echo $project['name']; else : ?>Untitled<?php endif; ?>
          </a>
        </h2>

        <p><?php echo $project['description']; ?></p>

        <p>
          <?php
            // Get number of tasks

            $project_id = $project['id'];
            $sql = "SELECT * FROM `tasks` WHERE `tasks`.`project` = '$project_id'";
            $tasks = mysqli_query ($connection, $sql);

          ?>
          <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/tasks/index.php"><?php echo mysqli_num_rows($tasks); ?> <i class="far fa-check-double"></i></a>
          <?php
            // Get number of comments

            $sql = "SELECT * FROM `comments` WHERE `comments`.`project` = '$project_id'";
            $comments = mysqli_query ($connection, $sql);

          ?>
          <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/comments/index.php"><?php echo mysqli_num_rows($comments); ?> <i class="far fa-comment"></i></a>
        </p>
        <?php
          // Get total budget

          $sql = "SELECT SUM(`budget`) AS `value_sum` FROM `tasks` WHERE `tasks`.`project` = '$project_id'";
          $budgets = mysqli_query($connection, $sql);
          $budget = mysqli_fetch_assoc($budgets);
          echo 'Budgets $' . number_format($budget['value_sum']);

        ?>
        <br>
        <?php
          // Get total budget

          $sql = "SELECT SUM(`goal`) AS `value_sum` FROM `tasks` WHERE `tasks`.`project` = '$project_id'";
          $goals = mysqli_query($connection, $sql);
          $goal = mysqli_fetch_assoc($goals);
          echo 'Goals $' . number_format($goal['value_sum']);

        ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php require_once '../template-parts/footer.php'; ?>
