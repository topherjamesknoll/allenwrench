<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

// Get project information

session_start();
$team_id = $_SESSION['team'];
$project_id = $_SESSION['project'];
$author = $_SESSION['user'];

connect();
$sql = "SELECT `id`, `name`, `description` FROM `projects` WHERE `projects`.`id` = '$project_id'";
$projects = mysqli_query($connection, $sql);
$project = mysqli_fetch_assoc($projects);

// Insert comments

if (isset($_POST['comment'])) {

  $subject = $_POST['subject'];
  $comment = $_POST['comment'];
  $email = $_POST['email'];

  $sql = "INSERT INTO `comments` (`subject`, `comment`, `team`, `project`, `author`) VALUES ('$subject', '$comment', '$team_id', '$project_id', '$author')";
  mysqli_query($connection, $sql);

  if ($email=='true') {

    // Get Sender

    $sql = "SELECT `email`, `user`, `first`, `last` FROM `members` WHERE `members`.`id` = '$author'";
    $users = mysqli_query($connection, $sql);
    $user = mysqli_fetch_assoc($users);

    // Get email addresses

    $sql = "SELECT `email` FROM `members`";
    $emailaddresses = mysqli_query($connection, $sql);

    while($emailaddress = mysqli_fetch_assoc($emailaddresses)) {
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

$sql = "SELECT * FROM `comments` WHERE `comments`.`project` = '$project_id'";
$comments = mysqli_query($connection, $sql);

mysqli_close($connection);

?>

<?php require_once '../template-parts/header.php'; ?>

<?php if (empty($project_id)) : ?>
  <div uk-alert class="uk-alert-warning">
  <a class="uk-alert-close" uk-close></a>
  <h3>What would you like to work on?</h3>
  <p>You must first select a project to see comments on it.</p>
</div>
<?php else : ?>
  <div uk-grid>
    <div class="uk-width-expand@s">
      <p class="uk-text-bold"><?php echo mysqli_num_rows($comments); ?> Discussions for</p>
      <h1><?php if ($project['name']!='') : echo $project['name']; else : ?>Untitled<?php endif; ?></h1>
      <p><?php echo $project['description']; ?></p>
    </div>
    <div>
      <a href="#adddiscussion" class="uk-button uk-button-primary">Add Discussion</a>
    </div>
  </div>
  <div class="uk-child-width-1-1" uk-grid>
    <?php while($comment = mysqli_fetch_assoc($comments)) : ?>
      <div>
        <div class="uk-card uk-card-default uk-card-body uk-card-small">
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
        <form action="index.php" method="post" id="jqueryform">
          <p>Subject:</p>
          <p><input type="text" name="subject" class="uk-input"></p>
          <p>Message:</p>
          <textarea rows="8" class="uk-textarea" name="comment" id="comment"></textarea>
          <p><span class="uk-button uk-button-primary" id="jqueryformsubmit">Add</span></p>
          <p><input type="checkbox" class="uk-checkbox" name="email" value="true" checked> Email team this comment</p>
        </form>
        <script>
            CKEDITOR.replace( 'comment' );
        </script>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require_once '../template-parts/footer.php'; ?>
