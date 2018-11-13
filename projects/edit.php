<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['projectid']) && isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];
  $project_id = $_GET['projectid'];

  $projects = $mysqli->query("SELECT * FROM `projects` WHERE `projects`.`id` = '$project_id'");
  $project = $projects->fetch_assoc();

  if (isset($_GET['name'])) { $name = $_GET['name']; }
  if (isset($_GET['description'])) {$description = $_GET['description']; }

  $mysqli->query("UPDATE `projects` SET `name` = '$name', `description` = '$description' WHERE `projects`.`id` = '$project_id'");

  if (isset($name) || isset($description)) {
    header('Location: ' . ABSPATH . '/projects/index.php');
  }
}
else {
  header('Location: ' . ABSPATH . '/projects/index.php');
}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<h1>Update Project</h1>
<div class="uk-grid-match uk-child-width-1-1@s" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="edit.php" method="get" id="cmxform">
          <input type="hidden" name="projectid" value="<?php echo $project_id; ?>">
          <input type="hidden" name="teamid" value="<?php echo $team_id; ?>">
          <h2 class="uk-card-title">Project Name:</h2>
          <input type="text" name="name" class="uk-input" value="<?php echo $project['name']; ?>" required>
          <h2 class="uk-card-title">Description:</h2>
          <textarea rows="8" class="uk-textarea" name="description" id="description"><?php echo $project['description']; ?></textarea>
          <p><input type="submit" value="Update Project" class="uk-button uk-button-primary submit"></p>
        </form>
        <script>
            CKEDITOR.replace( 'description' );
        </script>
        <script>
          $("#cmxform").validate();
        </script>
      </div>
    </div>
</div>

</div>

</div>

</div>

<?php require_once '../template-parts/footer.php'; ?>
