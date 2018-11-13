<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>

<?php

if (isset($_POST['user']) && isset($_POST['password'])) {
  $user = $_POST['user'];
  $password = hash('ripemd160', $_POST['password']);

  $members = $mysqli->query("SELECT `id` FROM `members` WHERE `user` = '$user' AND `password` = '$password'");
  $member = $members->fetch_assoc();
  if ($members->num_rows == 1) {
    session_start();
    $_SESSION['user'] = $member['id'];

    header('Location: ' . ABSPATH . '/');
  }
  else {
    die('Wrong credentials');
  }
}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-width-1-1 uk-padding">

<style>
  body {
    background:url('<?php echo ABSPATH; ?>/images/01.png') no-repeat center center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
  }
  .uk-navbar {
    visibility: hidden;
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
      <form action="login.php" method="post">
      <h2>Login</h2>
        <p>Username</p>
        <input type="text" name="user" class="uk-input">
        <p>Password</p>
        <input type="password" name="password" class="uk-input">
        <p><input type="submit" value="Login" class="uk-button uk-button-primary"></p>
      </form>
    </div>
  </div>
</div>

</div>

<?php require_once '../template-parts/footer.php'; ?>
