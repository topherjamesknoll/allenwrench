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
$result = mysqli_query($connection, $sql);

?>

<?php require_once 'template-parts/header.php'; ?>

<?php if (mysqli_num_rows($result)==0) : ?>
  <div uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <h3>It's quiet in here.</h3>
    <p>There doesn't seem to be anything here. Try adding a team.</p>
  </div>
<?php endif; ?>
<div uk-grid>
  <div>
    <h1>Teams</h1>
  </div>
  <div class="uk-width-expand uk-text-right">
    <a href="<?php echo ABSPATH; ?>/teams/add.php" class="uk-button uk-button-primary">Add Team</a>
  </div>
</div>
<div class="uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-hover">
        <div class="uk-card-header">
          <p class="uk-text-right">
            <a href="<?php echo ABSPATH; ?>/teams/edit.php?teamid=<?php echo $row['id']; ?>"><i class="far fa-wrench"></i></a>
            <a href="<?php echo ABSPATH; ?>/teams/delete.php?teamid=<?php echo $row['id']; ?>"><i class="far fa-trash-alt"></i></a>
          </p>
          <h2 class="uk-card-title"><a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $row['id']; ?>&project=&directory=/projects/index.php"><?php echo $row['name']; ?></a></h2>
        </div>
        <div class="uk-card-body">
          <p><?php echo $row['description']; ?></p>
        </div>
        <div class="uk-card-footer">
          <?php
            // Get number of projects

            $team = $row['id'];

            $sql = "SELECT * FROM `projects` WHERE `projects`.`team` = '$team'";
            $projects = mysqli_query($connection, $sql);
            $rows = mysqli_num_rows($projects);
          ?>
          <p><a href="<?php echo ABSPATH; ?>/switch.php?team=<?php echo $row['id']; ?>&project=&directory=/projects/index.php"><?php echo $rows; ?> <i class="far fa-project-diagram"></i></a></p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php

mysqli_close($connection);

?>

<?php require_once 'template-parts/footer.php'; ?>
