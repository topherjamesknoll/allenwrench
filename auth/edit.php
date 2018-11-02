<?php require_once '../config.php'; ?>
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

connect();
$sql = "SELECT `email`, `user`, `password`, `first`, `last`, `title` FROM `members` WHERE `members`.`id` = '$user'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);

if (empty($_POST['email'])) { $email=$row['email']; }
if (empty($_POST['username'])) { $username=$row['user']; }
if (empty($_POST['password'])) { $password=$row['password']; }
if (empty($_POST['first'])) { $first=$row['first']; }
if (empty($_POST['last'])) { $last=$row['last']; }
if (empty($_POST['title'])) { $title=$row['title']; }

// Insert into database

$sql = "UPDATE `members` SET `email` = '$email', `user` = '$username', `password` = '$password', `first` = '$first', `last` = '$last', `title` = '$title'  WHERE `members`.`id` = $user";
mysqli_query($connection, $sql);

?>

<?php require_once '../template-parts/header.php'; ?>

<style>
  body {
		background:url('<?php echo ABSPATH; ?>/images/background.jpg'); no-repeat center center;
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
      <form action="edit.php" method="post">
				<div><?php avatar($user,100); ?></div>
				<p><a href="<?php echo ABSPATH; ?>/members/avatar.php" target="_blank">Change picture</a></p>
				<h2>Edit your Profile</h2>
        <p>Email Address:</p>
        <input type="text" name="email" class="uk-input" value="<?php echo $email; ?>">
        <p>Username:</p>
        <input type="text" name="username" class="uk-input" id="required" value="<?php echo $username; ?>">
        <p>Password:</p>
        <input type="password" name="password" class="uk-input">
        <p>First Name:</p>
        <input type="text" name="first" class="uk-input" value="<?php echo $first; ?>">
        <p>Last Name:</p>
        <input type="text" name="last" class="uk-input" value="<?php echo $last; ?>">
        <p>Title:</p>
        <input type="text" name="title" class="uk-input" value="<?php echo $title; ?>">
        <p><input type="submit" value="Update" class="uk-button uk-button-primary submit"></p>
      </form>
    </div>
  </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
