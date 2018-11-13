<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

$user = $_SESSION['user'];

if (isset($_FILES['file'])) {
  $file = basename($_FILES['file']['name']);
  $newfile = '../uploads/avatars/' . $user . '.jpg';
  move_uploaded_file($_FILES['file']['tmp_name'], $newfile);

  create_square_image('../uploads/avatars/' . $user . '.jpg','../uploads/avatars/' . $user . '.jpg',200);

}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<h1>Edit your Profile Picture</h1>
<div class="uk-grid-match uk-child-width-1-1@m" uk-grid>
	<div>
		<div class="uk-card uk-card-default uk-card-body uk-card-small">
      <form action="<?php echo ABSPATH; ?>/members/avatar.php" method="post" enctype="multipart/form-data">
				<p><?php avatar($user,150); ?></p>
        <div uk-form-custom="target: true">
            <input type="file" name="file" id="file">
            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
        </div>
        <input type="submit" class="uk-button uk-button-primary" value="Upload">
      </form>
    </div>
  </div>
</div>

</div>

</div>

</div>

<?php require_once '../template-parts/footer.php'; ?>
