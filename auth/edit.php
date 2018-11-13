<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

// Get user

session_start();
$user = $_SESSION['user'];

// Read post data

if (isset($_POST['email'])) { $email = $_POST['email']; }
if (isset($_POST['username'])) { $username = $_POST['username']; }
if (isset($_POST['password'])) {
	$password = $_POST['password'];
	$password = hash('ripemd160', $password);
}
if (isset($_POST['first'])) { $first = $_POST['first']; }
if (isset($_POST['last'])) { $last = $_POST['last']; }
if (isset($_POST['title'])) { $title = $_POST['title']; }

// Get info for fields

$members = $mysqli->query("SELECT `email`, `user`, `password`, `first`, `last`, `title` FROM `members` WHERE `members`.`id` = '$user'");
$member = $members->fetch_assoc();

if (empty($_POST['email'])) { $email=$member['email']; }
if (empty($_POST['username'])) { $username=$member['user']; }
if (empty($_POST['password'])) { $password=$member['password']; }
if (empty($_POST['first'])) { $first=$member['first']; }
if (empty($_POST['last'])) { $last=$member['last']; }
if (empty($_POST['title'])) { $title=$member['title']; }

// Insert into database

$mysqli->query("UPDATE `members` SET `email` = '$email', `user` = '$username', `password` = '$password', `first` = '$first', `last` = '$last', `title` = '$title'  WHERE `members`.`id` = $user");

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<h1>Edit your Profile</h1>
<div class="uk-grid-match uk-child-width-1-1@m" uk-grid>
	<div>
		<div class="uk-card uk-card-default uk-card-body uk-card-small">
      <form action="edit.php" method="post" id="cmxform">
				<div><?php avatar($user,100); ?></div>
				<p><a href="<?php echo ABSPATH; ?>/members/avatar.php" target="_blank">Change picture</a></p>
        <p>Email Address:</p>
        <input type="email" name="email" class="uk-input" value="<?php echo $email; ?>" required>
        <p>Username:</p>
        <input type="text" name="username" class="uk-input" value="<?php echo $username; ?>" required>
        <p>Password:</p>
        <input type="password" name="password" class="uk-input" required>
        <p>First Name:</p>
        <input type="text" name="first" class="uk-input" value="<?php echo $first; ?>">
        <p>Last Name:</p>
        <input type="text" name="last" class="uk-input" value="<?php echo $last; ?>">
        <p>Title:</p>
        <input type="text" name="title" class="uk-input" value="<?php echo $title; ?>">
        <p><input type="submit" value="Update" class="uk-button uk-button-primary submit"></p>
      </form>
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
