<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
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

	$mysqli->query("INSERT INTO `members` (`email`, `active`, `confirmation`) VALUES ('$email', '0', '$confirmation')");

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

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<h1>Invite a Member</h1>
<div class="uk-grid-match uk-child-width-1-1@m" uk-grid>
	<div>
		<div class="uk-card uk-card-default uk-card-body uk-card-small">
			<form action="add.php" method="post" id="cmxform">
				<p>Email Address:</p>
				<input type="email" name="email" class="uk-input" required>
				<p>First Name:</p>
				<input type="text" name="first" class="uk-input">
				<p>Last Name:</p>
				<input type="text" name="last" class="uk-input">
				<p><input type="submit" value="Add" class="uk-button uk-button-primary submit"></p>
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
</div>

<?php require_once '../template-parts/footer.php'; ?>
