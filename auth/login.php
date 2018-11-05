<?php require_once '../config.php'; ?>

<?php

if (isset($_POST['user']) && isset($_POST['password'])) {
  $user = $_POST['user'];
  $password = hash('ripemd160', $_POST['password']);

  connect();
  $sql = "SELECT `id` FROM `members` WHERE `user` = '$user' AND `password` = '$password'";
  $result = mysqli_query($connection, $sql);
  $row = mysqli_fetch_assoc($result);
  if (mysqli_num_rows($result) == 1) {
    session_start();
    $_SESSION['user'] = $row['id'];

    header('Location: ' . ABSPATH . '/');
  }
  else {
    die('Wrong credentials');
  }
}

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

<?php require_once '../template-parts/footer.php'; ?>
