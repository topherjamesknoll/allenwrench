<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

// Get project information

session_start();
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
  $comment = $_POST['comment'];

  $sql = "INSERT INTO `comments` (`subject`, `comment`, `project`, `author`) VALUES ('$subject', '$comment', '$project_id', '$author')";
  mysqli_query($connection, $sql);

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
  <?php if (mysqli_num_rows($comments)==0) : ?>
    <div uk-alert>
      <a class="uk-alert-close" uk-close></a>
      <h3>It's quiet in here.</h3>
      <p>There doesn't seem to be any comments here. Speak your mind and use the form below to share yours.</p>
    </div>
  <?php endif; ?>
  <div uk-grid>
    <div>
      <p class="uk-text-bold"><?php echo mysqli_num_rows($comments); ?> Comments for</p>
      <h1><?php echo $project['name']; ?></h1>
      <p><?php echo $project['description']; ?></p>
    </div>
    <div class="uk-width-expand uk-text-right">
      <a href="#commentform" class="uk-button uk-button-primary">Add Comment</a>
    </div>
  </div>
  <div class="uk-child-width-1-1" uk-grid>
    <?php while($comment = mysqli_fetch_assoc($comments)) : ?>
      <div>
        <div class="uk-card uk-card-default uk-card-small">
          <div class="uk-card-header">
            <div uk-grid>
              <div class="uk-width-auto">
                <?php avatar($comment['author'],38); ?>
              </div>
              <div class="uk-width-expand">
                <h3 class="uk-card-title"><?php echo $comment['subject']; ?></h3>
                <p class="uk-text-small uk-text-muted"><?php user($comment['author']); ?> on <?php echo date('M j g:i A', $comment['time']); ?></p>
              </div>
            </div>
          </div>
          <div class="uk-card-body">
            <p><?php echo $comment['comment']; ?></p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="index.php" method="post" id="commentform">
          <p>Subject:</p>
          <p><input type="text" name="subject" class="uk-input"></p>
          <p>Message:</p>
          <textarea rows="8" class="uk-textarea" name="comment"></textarea>
          <p><span class="uk-button uk-button-primary" id="commentformsubmit">Send <i class="far fa-paper-plane"></i></span></p>
        </form>
      </div>
    </div>
  </div>
<?php endif; ?>

<?php require_once '../template-parts/footer.php'; ?>
