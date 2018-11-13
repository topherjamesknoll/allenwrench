<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];

  if (isset($_GET['name']) && isset($_GET['description'])) {

    $name = $_GET['name'];
    $description = $_GET['description'];

    $mysqli->query("INSERT INTO `projects` (`name`, `description`, `team`) VALUES ('$name', '$description', '$team_id')");

    header('Location: ' . ABSPATH . '/projects/index.php');

  }

}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<h1>Add Project</h1>
<div class="uk-grid-match uk-child-width-1-1" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="add.php" method="get" id="cmxform">
          <input type="hidden" name="teamid" value="<?php echo $team_id; ?>">
          <h2 class="uk-card-title">Project Name:</h2>
          <input type="text" name="name" class="uk-input" required>
          <h2 class="uk-card-title">Description:</h2>
          <textarea rows="8" class="uk-textarea" name="description" id="description"></textarea>
          <p><input type="submit" value="Add Project" class="uk-button uk-button-primary submit"></p>
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
