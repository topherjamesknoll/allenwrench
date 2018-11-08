<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

session_start();
if (isset($_SESSION['team'])) { $team_id = $_SESSION['team']; }
if (isset($_SESSION['project'])) { $project_id = $_SESSION['project']; }

// Get team information

$teams = $mysqli->query("SELECT `id`, `name`, `description` FROM `teams` WHERE `teams`.`id` = '$team_id'");
$team = $teams->fetch_assoc();

// Get projects

$projects = $mysqli->query("SELECT * FROM `projects` WHERE `projects`.`team` = '$team_id'");

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<?php if ($team_id!='') : ?>
  <div uk-grid>
    <div class="uk-width-expand@s">
      <p class="uk-text-bold"><?php echo $projects->num_rows; ?> projects for</p>
      <h1><?php if ($team['name']!='') : echo $team['name']; else : ?>Untitled<?php endif; ?></h1>
      <p><?php echo $team['description']; ?></p>
    </div>
    <div>
      <?php if ($teams->num_rows!=0) : ?>
        <a href="<?php echo ABSPATH; ?>/projects/add.php?teamid=<?php echo $team['id']; ?>" class="uk-button uk-button-primary">Add Project</a>
      <?php endif; ?>
    </div>
  </div>
<?php else : ?>
  <div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <h3>No Team</h3>
    <p>Please go back and select a team.</p>
  </div>
<?php endif; ?>
<div class="uk-grid-match uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid>
  <?php while ($project = mysqli_fetch_assoc($projects)) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-hover uk-card-small">
        <p class="uk-text-right">
          <span uk-tooltip="title: Edit Project">
            <a href="<?php echo ABSPATH; ?>/projects/edit.php?projectid=<?php echo $project['id']; ?>&teamid=<?php echo $team['id']; ?>"><i class="far fa-wrench"></i></a>
          </span>
          <span uk-tooltip="title: Delete Project">
            <a href="<?php echo ABSPATH; ?>/projects/delete.php?projectid=<?php echo $project['id']; ?>&teamid=<?php echo $team['id']; ?>"><i class="far fa-trash-alt"></i></a>
          </span>
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

            $tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`project` = '$project_id'");

          ?>
          <span uk-tooltip="title: Tasks">
            <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/tasks/index.php"><?php echo mysqli_num_rows($tasks); ?> <i class="far fa-check-double"></i></a>
          </span>
          <?php
            // Get number of comments

            $comments = $mysqli->query("SELECT * FROM `comments` WHERE `comments`.`project` = '$project_id'");

          ?>
          <span uk-tooltip="title: Discussions">
            <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&project=<?php echo $project['id']; ?>&directory=/comments/index.php"><?php echo mysqli_num_rows($comments); ?> <i class="far fa-comment"></i></a>
          </span>
        </p>
        <?php
          // Get budget

          $budgets = $mysqli->query("SELECT SUM(`budget`) AS `value_sum` FROM `tasks` WHERE `tasks`.`project` = '$project_id'");
          $budget = $budgets->fetch_assoc;
          echo 'Budgets $' . number_format($budget['value_sum']);

        ?>
        <br>
        <?php
          // Get goal

          $goals = $mysqli->query("SELECT SUM(`goal`) AS `value_sum` FROM `tasks` WHERE `tasks`.`project` = '$project_id'");
          $goal = $goals->fetch_assoc();
          echo 'Goals $' . number_format($goal['value_sum']);

        ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</div>
</div>

</div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
