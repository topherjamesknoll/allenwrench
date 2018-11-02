<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_POST['email']) && isset($_POST['first']) && isset($_POST['last'])) {

	// Read info

	$email = $_POST['email'];
	$first = $_POST['first'];
	$last = $_POST['last'];
	$confirmation = hash('ripemd160', $email);
	$confirmation_url = ABSPATH . '/auth/confirm.php?email=' . $email . '&confirmation=' . $confirmation;

	// Insert into database

	connect();
	$sql = "INSERT INTO `members` (`email`, `active`, `confirmation`) VALUES ('$email', '0', '$confirmation')";
	mysqli_query($connection, $sql);
	mysqli_close($connection);

	// Send confirmation link

	  $message = '
	    <html>
	    <body>
	      <p>You have been invited to Allen Wrench. Please click the link to complete your profile.</p>
	      <p><strong><a href="' . $confirmation_url . '">COMPLETE YOUR PROFILE HERE</a></strong></p>
	    </body>
	    </html>
	  ';
	  $headers[] = 'MIME-Version: 1.0';
	  $headers[] = 'Content-type: text/html; charset=iso-8859-1';
	  $headers[] = 'From: Topher <topher@getallenwrench.com>';
	  mail($email, 'Confirm your Allen Wrench email address', $message, implode("\r\n", $headers));

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
      <form action="add.php" method="post">
      <h2>Add a Member</h2>
        <p>Email Address:</p>
        <input type="text" name="email" class="uk-input">
        <p>First Name:</p>
        <input type="text" name="first" class="uk-input">
        <p>Last Name:</p>
        <input type="text" name="last" class="uk-input">
        <p><input type="submit" value="Add" class="uk-button uk-button-primary"></p>
      </form>
    </div>
  </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
