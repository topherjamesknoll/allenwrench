<?php require_once '../config.php'; ?>

<?php

	// Read info

	$email = $_GET['email'];
	$confirmation = $_GET['confirmation'];

	// Check database

	connect();
	$sql = "SELECT * FROM `members` WHERE `members`.`email` = '$email' and `members`.`confirmation` = '$confirmation'";
	$result = mysqli_query($connection, $sql);
  $rows = mysqli_num_rows($result);

  // Activate

  if ($rows==1) {
    $sql = "UPDATE `members` SET `active` = '1' WHERE `members`.`email` = '$email'";
    mysqli_query($connection, $sql);
  }

  mysqli_close($connection);

  // Login

  $row = mysqli_fetch_assoc($result);
  session_start();
  $_SESSION['user'] = $row['id'];

	// Redirect

  header('Location: ' . ABSPATH . '/auth/edit.php');

?>
