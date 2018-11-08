<?php if (file_exists('config.php')) : require_once 'config.php'; else : header('Location: install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

// Get teams

$teams = $mysqli->query("SELECT * FROM `teams`");

?>

<?php require_once 'template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once 'template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<div uk-grid>
  <div class="uk-width-expand">
    <h1>Teams</h1>
  </div>
  <div>
    <a href="<?php echo ABSPATH; ?>/teams/add.php" class="uk-button uk-button-primary">Add Teams</a>
  </div>
</div>
<div class="uk-grid-match uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid>
  <?php while ($team = $teams->fetch_assoc()) : ?>
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

              $projects = $mysqli->query("SELECT * FROM `projects` WHERE `projects`.`team` = '$team_id'");
              $rows = $projects->num_rows;
            ?>
            <span uk-tooltip="title: Projects">
              <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&directory=/projects/index.php"><?php echo $rows; ?> <i class="far fa-project-diagram"></i></a>
            </span>
            <?php
              // Get number of tasks

              $tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`team` = '$team_id'");
              $rows = $tasks->num_rows;
            ?>
            <span uk-tooltip="title: Tasks">
              <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&directory=/tasks/index.php"><?php echo $rows; ?> <i class="far fa-check-double"></i></a>
            </span>
            <?php
              // Get number of comments

              $comments = $mysqli->query("SELECT * FROM `comments` WHERE `comments`.`team` = '$team_id'");
              $rows = $comments->num_rows;
            ?>
            <span uk-tooltip="title: Discussions">
              <a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $team_id; ?>&directory=/comments/index.php"><?php echo $rows; ?> <i class="far fa-comment"></i></a>
            </span>
          </p>
          <p>
            <?php
            // Get members

            $team_id = $team['id'];

            $members = $mysqli->query("SELECT `member` FROM `members_teams` WHERE `members_teams`.`team` = '$team_id'");
            while ($member = $members->fetch_assoc()) {
              echo avatar($member['member'], 38);
            }
            ?>
          </p>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</div>
</div>

</div>
</div>

<?php require_once 'template-parts/footer.php'; ?>
