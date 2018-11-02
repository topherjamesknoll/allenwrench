<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['projectid']) && isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];
  $project_id = $_GET['projectid'];

  connect();
  $sql = "SELECT * FROM `projects` WHERE `projects`.`id` = '$project_id'";
  $projects = mysqli_query($connection, $sql);
  $project = mysqli_fetch_assoc($projects);

  if (isset($_GET['name'])) { $name = $_GET['name']; }
  if (isset($_GET['description'])) {$description = $_GET['description']; }

  $sql = "UPDATE `projects` SET `name` = '$name', `description` = '$description' WHERE `projects`.`id` = '$project_id'";
  mysqli_query($connection, $sql);
  mysqli_close($connection);

  if (isset($name) || isset($description)) {
    header('Location: ' . ABSPATH . '/projects/index.php');
  }
}
else {
  header('Location: ' . ABSPATH . '/projects/index.php');
}

?>

<?php require_once '../template-parts/header.php'; ?>

<h1>Edit Project</h1>
<div class="uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="edit.php" method="get">
          <input type="hidden" name="projectid" value="<?php echo $project_id; ?>">
          <input type="hidden" name="teamid" value="<?php echo $team_id; ?>">
          <h2 class="uk-card-title">Project Name:</h2>
          <input type="text" name="name" class="uk-input" value="<?php echo $project['name']; ?>">
          <h2 class="uk-card-title">Description:</h2>
          <textarea rows="8" class="uk-textarea" name="description"><?php echo $project['description']; ?></textarea>
          <p><input type="submit" value="Edit Team" class="uk-button uk-button-primary"></p>
        </form>
      </div>
    </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
