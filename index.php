<?php if (file_exists('config.php')) : require_once 'config.php'; else : header('Location: install.php'); endif; ?>
<?php user_redirect(); ?>

<?php require_once 'template-parts/header.php'; ?>

<?php

$projects = $mysqli->query ("SELECT * FROM `projects`");

?>

<div class="uk-grid-match" uk-grid>

<?php require_once 'template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<!--<ul uk-tab>
  <li><a href="">Projects</a></li>
  <li><a href="">Tasks</a></li>
  <li><a href="">Discussions</a></li>
  <li><a href="">Teams</a></li>
</ul>-->

<h1>Dashboard</h1>
<div class="uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid="masonry: true">
  <?php while ($project = $projects->fetch_assoc()) : ?>
  <div>
    <div class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
      <h2 class="uk-card-title">
        <a href="<?php echo ABSPATH . '/tasks/index.php?project=' . $project['id']; ?>">
          <?php if ($project['name'] != '') : echo $project['name']; else : echo 'Untitled'; endif; ?>
        </a>
      </h2>
      <?php

      // Get completed tasks

      $project_id = $project['id'];

      $completed_tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`project` = $project_id AND `tasks`.`progress` = '1'");
      $tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`project` = $project_id");

      ?>
      <progress class="uk-progress" value="<?php echo $completed_tasks->num_rows; ?>" max="<?php echo $tasks->num_rows; ?>"></progress>
      <p><?php echo $completed_tasks->num_rows; ?> of <?php echo $tasks->num_rows; ?> tasks completed</p>
    </div>
  </div>
<?php endwhile; ?>
</div>

</div>

</div>

</div>

<?php require_once 'template-parts/footer.php'; ?>
