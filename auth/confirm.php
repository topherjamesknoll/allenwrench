<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>

<?php

	// Read info

	$email = $_GET['email'];
	$confirmation = $_GET['confirmation'];

	// Check database

	$members = $mysqli->query("SELECT * FROM `members` WHERE `members`.`email` = '$email' and `members`.`confirmation` = '$confirmation'");
	$rows = $members->num_rows;

  // Activate

  if ($rows==1) {

		$mysqli->query("UPDATE `members` SET `active` = '1' WHERE `members`.`email` = '$email'");
  }

  // Login

  $member = $mysqli->fetch_assoc($members);
  session_start();
  $_SESSION['user'] = $row['member'];

	// Redirect

  header('Location: ' . ABSPATH . '/auth/edit.php');

?>
