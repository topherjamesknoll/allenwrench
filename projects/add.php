<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];

  if (isset($_GET['name']) && isset($_GET['description'])) {

    $name = $_GET['name'];
    $description = $_GET['description'];

    connect();
    $sql = "INSERT INTO `projects` (`name`, `description`, `team`) VALUES ('$name', '$description', '$team_id')";
    mysqli_query($connection, $sql);
    mysqli_close($connection);

    header('Location: ' . ABSPATH . '/projects/index.php');

  }

}

?>

<?php require_once '../template-parts/header.php'; ?>

<h1>Add Project</h1>
<div class="uk-grid-match uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="add.php" method="get">
          <input type="hidden" name="teamid" value="<?php echo $team_id; ?>">
          <h2 class="uk-card-title">Project Name:</h2>
          <input type="text" name="name" class="uk-input">
          <h2 class="uk-card-title">Description:</h2>
          <textarea rows="8" class="uk-textarea" name="description"></textarea>
          <p><input type="submit" value="Add Project" class="uk-button uk-button-primary"></p>
        </form>
      </div>
    </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
