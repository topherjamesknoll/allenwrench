<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

// Get author information

session_start();
$author = $_SESSION['user'];

// Insert messages

if (isset($_POST['message'])) {

  $message = $_POST['message'];
  $email = $_POST['email'];

  $mysqli->query("INSERT INTO `discussions` (`message`, `author`) VALUES ('$message', '$author')");

  if ($email=='true') {

    // Get Sender

    $users = $mysqli->query("SELECT `email`, `user`, `first`, `last` FROM `members` WHERE `members`.`id` = '$author'");
    $user = $users->fetch_assoc();

    // Get email addresses

    $emailaddresses = $mysqli->query("SELECT `email` FROM `members`");

    while($emailaddress = $emailaddresses->fetch_assoc()) {
      $email = '
        <html>
        <body>
        ' . $message . '
        </body>
        </html>
      ';
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';
      $headers[] = 'From: ' . $user['user'] . ' <' . $user['email'] . '>';
      mail($emailaddress['email'], 'New comment on Allen Wrench', $email, implode("\r\n", $headers));
    }
  }

}

// Get Comments

$discussions = $mysqli->query("SELECT * FROM `discussions` LIMIT 10");

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<div uk-grid>
  <div class="uk-width-expand@s">
    <h1>Discussions</h1>
  </div>
  <div>
    <a href="#adddiscussion" class="uk-button uk-button-primary">Add Discussion</a>
  </div>
</div>
<div class="uk-child-width-1-1" uk-grid>
  <?php while($discussion = $discussions->fetch_assoc()) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover speech-bubble">
        <div uk-grid>
          <div class="uk-width-auto">
            <?php avatar($discussion['author'],38); ?>
          </div>
          <div class="uk-width-expand">
              <p><span class="uk-text-bold"><?php user($discussion['author']); ?></span> on <?php echo date('M j g:i A', $discussion['time']); ?></p>
              <p><?php echo $discussion['message']; ?></p>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  <h1 id="adddiscussion">Add to the Discussion</h1>
  <div>
    <div class="uk-card uk-card-default uk-card-small uk-card-body">
      <form action="index.php" method="post">
        <p>Message:</p>
        <textarea rows="8" class="uk-textarea" name="message" id="message"></textarea>
        <p><input type="submit" class="uk-button uk-button-primary" value="Add"></p>
        <p><input type="checkbox" class="uk-checkbox" name="email" value="true" checked> Email team this comment</p>
      </form>
      <script>
          CKEDITOR.replace( 'message' );
      </script>
    </div>
  </div>
</div>

</div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
