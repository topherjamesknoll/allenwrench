<?php

// Check to see if AW is installed

if (!file_exists('config.php')) {
  header('Location: install.php');
}

?>

<?php require_once 'config.php'; ?>
<?php user_redirect(); ?>

<?php

// Get teams

connect();
$sql = "SELECT * FROM `teams`";
$teams = mysqli_query($connection, $sql);

?>

<?php require_once 'template-parts/header.php'; ?>

<div uk-grid>
  <div class="uk-width-expand">
    <h1>Teams</h1>
  </div>
  <div>
    <a href="<?php echo ABSPATH; ?>/teams/add.php" class="uk-button uk-button-primary">Add Teams</a>
  </div>
</div>
<div class="uk-grid-match uk-child-width-1-2@s uk-child-width-1-4@l" uk-grid>
  <?php while ($team = mysqli_fetch_assoc($teams)) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
          <p class="uk-text-right">
            <span uk-tooltip="title: Edit Team">
              <a href="<?php echo ABSPATH; ?>/teams/edit.php?teamid=<?php echo $team['id']; ?>"><i class="far fa-wrench"></i></a>
            </span>
            <span uk-tooltip="title: Delete Team">
              <a href="<?php echo ABSPATH; ?>/teams/delete.php?teamid=<?php echo $team['id']; ?>"><i class="far fa-trash-alt"></i></a>
            </span>
          </p>
          <h2 class="uk-card-title"><a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team['id']; ?>&project=&directory=/projects/index.php"><?php echo $team['name']; ?></a></h2>
          <p><?php echo $team['description']; ?></p>
          <p>
            <?php
              // Get number of projects

              $team_id = $team['id'];

              $sql = "SELECT * FROM `projects` WHERE `projects`.`team` = '$team_id'";
              $projects = mysqli_query($connection, $sql);
              $rows = mysqli_num_rows($projects);
            ?>
            <span uk-tooltip="title: Projects">
              <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&directory=/projects/index.php"><?php echo $rows; ?> <i class="far fa-project-diagram"></i></a>
            </span>
            <?php
              // Get number of tasks

              $sql = "SELECT * FROM `tasks` WHERE `tasks`.`team` = '$team_id'";
              $tasks = mysqli_query($connection, $sql);
              $rows = mysqli_num_rows($tasks);
            ?>
            <span uk-tooltip="title: Tasks">
              <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&directory=/tasks/index.php"><?php echo $rows; ?> <i class="far fa-check-double"></i></a>
            </span>
            <?php
              // Get number of comments

              $sql = "SELECT * FROM `comments` WHERE `comments`.`team` = '$team_id'";
              $comments = mysqli_query($connection, $sql);
              $rows = mysqli_num_rows($comments);
            ?>
            <span uk-tooltip="title: Discussions">
              <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&directory=/comments/index.php"><?php echo $rows; ?> <i class="far fa-comment"></i></a>
            </span>
          </p>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php

mysqli_close($connection);

?>

<?php require_once 'template-parts/footer.php'; ?>
