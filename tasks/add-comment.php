<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['task'])) {

  $task_id = $_GET['task'];

  $tasks = $mysqli->query("SELECT `name` FROM `tasks` WHERE `tasks`.`id` = '$task_id'");
  $task = $tasks->fetch_assoc();

  if (isset($_GET['comment'])) {

    $comment = $_GET['comment'];

    session_start();
    $author = $_SESSION['user'];

    $mysqli->query("INSERT INTO `comments_tasks` (`task`, `message`, `author`) VALUES ('$task_id', '$comment', '$author')");

    header('Location: ' . ABSPATH . '/tasks/index.php');
  }

}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<p class="uk-text-lead">Add Comment to</p>
<h1><?php echo $task['name']; ?></h1>
<div class="uk-grid-match uk-child-width-1-1" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="add-comment.php" method="get">
          <input type="hidden" name="task" value="<?php echo $task_id; ?>">
          <h2 class="uk-card-title">Comment:</h2>
          <textarea rows="8" class="uk-textarea" name="comment" id="comment"></textarea>
          <p><input type="submit" value="Add Comment" class="uk-button uk-button-primary submit"></p>
        </form>
        <script>
            CKEDITOR.replace( 'comment' );
        </script>
      </div>
    </div>
</div>

</div>

</div>

</div>

<?php require_once '../template-parts/footer.php'; ?>
