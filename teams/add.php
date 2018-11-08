<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_POST['name']) && isset($_POST['description'])) {

  $name = $_POST['name'];
  $description = $_POST['description'];

  $mysqli->query("INSERT INTO `teams` (`name`, `description`) VALUES ('$name', '$description')");

  header('Location: ' . ABSPATH . '/index.php');

}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<h1>Add Team</h1>
<div class="uk-grid-match uk-child-width-1-1" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="add.php" method="post" id="cmxform">
          <h2 class="uk-card-title">Team Name:</h2>
          <input type="text" name="name" class="uk-input" required>
          <h2 class="uk-card-title">Description:</h2>
          <textarea rows="8" class="uk-textarea" name="description" id="description"></textarea>
          <p><input type="submit" value="Add Team" class="uk-button uk-button-primary submit"></p>
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
</div>

<?php require_once '../template-parts/footer.php'; ?>
