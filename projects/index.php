<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

get_team_and_project($_GET['team'],$_GET['project']);

// Get team information

$teams = $mysqli->query("SELECT `id`, `name`, `description` FROM `teams` WHERE `teams`.`id` = '$team_id'");
$team = $teams->fetch_assoc();

// Get projects

$projects = $mysqli->query("SELECT * FROM `projects` WHERE `projects`.`team` = '$team_id'");

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<?php if ($team_id!='') : ?>
  <div uk-grid>
    <div class="uk-width-expand@s">
      <p class="uk-text-lead"><?php echo $projects->num_rows; ?> projects for</p>
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
          <a href="<?php echo ABSPATH; ?>/tasks/index.php?project=<?php echo $project['id']; ?>">
            <?php if ($project['name']!='') : echo $project['name']; else : ?>Untitled<?php endif; ?>
          </a>
        </h2>
        <?php
          $project_id = $project['id'];

          // Due dates

          $task_due_dates = $mysqli->query("SELECT `due` FROM `tasks` WHERE `tasks`.`project` = $project_id ORDER BY `due` DESC");
          $task_due_date = $task_due_dates->fetch_assoc();

          if ($task_due_dates->num_rows==0) {
            $new_due_date = 'No due date<br>';
          }
          else {
            $due_date = strtotime($task_due_date['due']);
            $new_due_date = '<strong>Due: ' . date("M d", $due_date) . '</strong><br>';
          }
          echo $new_due_date;

          // Worth

          $goals = $mysqli->query("SELECT SUM(`goal`) AS `goals` FROM `tasks` WHERE `tasks`.`project` = '$project_id'");
          $goal = $goals->fetch_assoc();

          $budgets = $mysqli->query("SELECT SUM(`budget`) AS `budgets` FROM `tasks` WHERE `tasks`.`project` = '$project_id'");
          $budget = $budgets->fetch_assoc();

          $worth = $goal['goals'] - $budget['budgets'];
          if ($worth != '') {
            echo 'Worth $' . number_format($worth) . '</br>';
          }

          // Urgent???

          $priorities = $mysqli->query("SELECT `priority` FROM `tasks` WHERE `tasks`.`project` = $project_id AND `tasks`.`priority` = '1'");
          if ($priorities->num_rows > 0) {
            echo '<span class="uk-text-danger">Urgent</span>';
          }

        ?>
        <p><?php echo $project['description']; ?></p>
        <p>
          <?php
            // Get number of tasks

            $project_id = $project['id'];

            $tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`project` = '$project_id'");

          ?>
          <a href="<?php echo ABSPATH; ?>/tasks/index.php?project=<?php echo $project['id']; ?>"> <i class="far fa-check-double"></i>&nbsp;<?php echo mysqli_num_rows($tasks); ?>&nbsp;tasks</a>&nbsp;
          <?php
            // Get number of comments

            $project_id = $project['id'];

            $comments = $mysqli->query("SELECT * FROM `comments_projects` WHERE `comments_projects`.`project` = '$project_id' ORDER BY `id` DESC");

          ?>
          <a href="#offcanvas-<?php echo $project_id; ?>" uk-toggle="target: #offcanvas-<?php echo $project_id; ?>"> <i class="far fa-comment"></i>&nbsp;<?php echo mysqli_num_rows($comments); ?>&nbsp;comments</a>&nbsp;
          | <a href="<?php echo ABSPATH ?>/projects/add-comment.php?project=<?php echo $project['id']; ?>">Add comment</a>
        </p>
        <div id="offcanvas-<?php echo $project_id; ?>" uk-offcanvas="flip: true; overlay: true">
          <div class="uk-offcanvas-bar">
          <button class="uk-offcanvas-close" type="button" uk-close></button>
          <?php if ($comments->num_rows == 0) : ?>
            <p>There are no comments. Say something good!</p>
          <?php else : ?>
            <?php while($comment = $comments->fetch_assoc()) : ?>
              <?php avatar($comment['author'],38); ?>
              <p><span class="uk-text-bold"><?php user($comment['author']); ?></span> on <?php echo date('M j g:i A', $comment['time']); ?></p>
              <p><?php echo $comment['message']; ?></p>
            <?php endwhile; ?>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</div>

</div>

</div>

<?php require_once '../template-parts/footer.php'; ?>
