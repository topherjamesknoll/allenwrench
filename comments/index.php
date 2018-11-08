<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

// Get project information

session_start();
$team_id = $_SESSION['team'];
$project_id = $_SESSION['project'];
$author = $_SESSION['user'];

$projects = $mysqli->query("SELECT `id`, `name`, `description` FROM `projects` WHERE `projects`.`id` = '$project_id'");
$project = $projects->fetch_assoc();

// Insert comments

if (isset($_POST['comment'])) {

  $subject = $_POST['subject'];
  $comment = $_POST['comment'];
  $email = $_POST['email'];

  $mysqli->query("INSERT INTO `comments` (`subject`, `comment`, `team`, `project`, `author`) VALUES ('$subject', '$comment', '$team_id', '$project_id', '$author')");

  if ($email=='true') {

    // Get Sender

    $users = $mysqli->query("SELECT `email`, `user`, `first`, `last` FROM `members` WHERE `members`.`id` = '$author'");
    $user = $users->fetch_assoc();

    // Get email addresses

    $emailaddresses = $mysqli->query("SELECT `email` FROM `members`");

    while($emailaddress = $emailaddresses->fetch_assoc()) {
      $message = '
        <html>
        <body>
        ' . $comment . '
        </body>
        </html>
      ';
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=iso-8859-1';
      $headers[] = 'From: ' . $user['user'] . ' <' . $user['email'] . '>';
      mail($emailaddress['email'], 'New comment on Allen Wrench', $message, implode("\r\n", $headers));
    }
  }

}

// Get Comments

$comments = $mysqli->query("SELECT * FROM `comments` WHERE `comments`.`project` = '$project_id'");

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<?php if ($project_id!='') : ?>
  <div uk-grid>
    <div class="uk-width-expand@s">
      <p class="uk-text-bold"><?php echo mysqli_num_rows($comments); ?> discussions for</p>
      <h1><?php if ($project['name']!='') : echo $project['name']; else : ?>Untitled<?php endif; ?></h1>
      <p><?php echo $project['description']; ?></p>
    </div>
    <div>
      <a href="#adddiscussion" class="uk-button uk-button-primary">Add Discussion</a>
    </div>
  </div>
  <div class="uk-child-width-1-1" uk-grid>
    <?php while($comment = $comments->fetch_assoc()) : ?>
      <div>
        <div class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
          <article class="uk-comment">
            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
              <div class="uk-width-auto">
                <?php avatar($comment['author'],38); ?>
              </div>
              <div class="uk-width-expand">
                <h4 class="uk-comment-title uk-margin-remove"><?php echo $comment['subject']; ?></h4>
                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                  <li style="flex: 0 1 auto;"><?php user($comment['author']); ?> on <?php echo date('M j g:i A', $comment['time']); ?> |&nbsp;<a href="#adddiscussion">REPLY</a></li>
                </ul>
              </div>
            </header>
          <div class="uk-comment-body">
            <p><?php echo $comment['comment']; ?></p>
          </div>
          </article>
        </div>
      </div>
    <?php endwhile; ?>
    <h1 id="adddiscussion">Add to the Discussion</h1>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="index.php" method="post">
          <p>Subject:</p>
          <p><input type="text" name="subject" class="uk-input"></p>
          <p>Message:</p>
          <textarea rows="8" class="uk-textarea" name="comment" id="comment"></textarea>
          <p><input type="submit" class="uk-button uk-button-primary" value="Add"></p>
          <p><input type="checkbox" class="uk-checkbox" name="email" value="true" checked> Email team this comment</p>
        </form>
        <script>
            CKEDITOR.replace( 'comment' );
        </script>
      </div>
    </div>
  </div>
<?php else : ?>
  <div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <h3>No Project</h3>
    <p>Please go back and select a project.</p>
  </div>
<?php endif; ?>

</div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
