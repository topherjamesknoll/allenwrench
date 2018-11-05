<?php require_once '../config.php'; ?>
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

<style>
  body {
    background:url('http://images.ctfassets.net/c04v7yakqz6c/4QIfdNuXM4sSuUu6cUusMy/f059bf356d38e1fabddba68825d0e6e5/sid1.jpg?fm=jpg&w=1600') no-repeat center center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
  }
</style>
<div uk-grid>
  <div class="uk-width-1-4@m"></div>
  <div class="uk-width-1-2@m uk-padding">
    <h1 class="uk-text-center title"><i class="far fa-project-diagram"></i> Allen Wrench</h1>
  </div>
</div>
<div uk-grid>
  <div class="uk-width-1-4@m"></div>
  <div class="uk-width-1-2@m">
    <div class="uk-card uk-card-default uk-card-body">
      <form action="<?php echo ABSPATH; ?>/members/avatar.php" method="post" enctype="multipart/form-data">
				<div><?php avatar($user,150); ?></div>
				<h2>Edit your Avatar</h2>
        <p>Help your teamates recognize you. Upload a profile picture so they can see you.</p>
        <div uk-form-custom="target: true">
            <input type="file" name="file" id="file">
            <input class="uk-input uk-form-width-medium" type="text" placeholder="Select file" disabled>
        </div>
        <input type="submit" class="uk-button uk-button-primary" value="Upload">
      </form>
    </div>
  </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
