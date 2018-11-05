<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

// Read form

if (isset($_GET['id'])) { $id = $_GET['id']; }

connect();

if (isset($_GET['taskname']) || isset($_GET['description']) || isset($_GET['progress']) || isset($_GET['due'])) {

  $task_name = $_GET['taskname'];
  $description = $_GET['description'];
  $progress = $_GET['progress'];
  $budget = str_replace(',', '', $_GET['budget']);
  $goal = str_replace(',', '', $_GET['goal']);
  $due = $_GET['due'];
  $due = date('Y-m-d', strtotime(str_replace('-', '/', $due)));

  //Update task in database

  $sql = "UPDATE `tasks` SET `name` = '$task_name', `description` = '$description', `progress` = '$progress', `due` = '$due' WHERE `tasks`.`id` = '$id'";
  mysqli_query($connection, $sql);

  header('Location: ' . ABSPATH . '/tasks/index.php');

}

// Get tasks

$sql = "SELECT * FROM `tasks` WHERE `tasks`.`id` = '$id'";
$tasks = mysqli_query($connection, $sql);
$task = mysqli_fetch_assoc($tasks);

?>

<?php require_once '../template-parts/header.php'; ?>

<h1>Update Task</h1>
<div class="uk-child-width-1-1" uk-grid>
  <div>
    <div class="uk-card uk-card-default uk-card-small uk-card-body">
      <form action="edit.php" method="get" id="jqueryform">
        <input type="hidden" name="id" value="<?php echo $id; ?>"
        <p>Name:</p>
        <p><input type="text" name="taskname" class="uk-input" value="<?php echo $task['name']; ?>"></p>
        <p>Due:</p>
        <p><input type="text" name="due" id="datepicker" class="uk-input" value="<?php echo $task['due']; ?>"></p>
        <p>Progress:</p>
        <select name="progress" class="uk-select">
          <option value="2" selected>In-progress</option>
          <option value="3">On hold</option>
          <option value="1">Completed</option>
          <option>N/A</option>
        </select>
        <p>Budget:</p>
        <p><input type="text" name="budget" class="uk-input" value="<?php echo $task['budget']; ?>"></p>
        <p>Goal:</p>
        <p><input type="text" name="goal" class="uk-input" value="<?php echo $task['goal']; ?>"></p>
        <script>
          var picker = new Pikaday(
          {
          field: document.getElementById('datepicker'),
          firstDay: 1,
          minDate: new Date(),
          maxDate: new Date(2020, 12, 31),
          yearRange: [2000,2020]
          });
        </script>
        <p>Description:</p>
        <textarea rows="8" class="uk-textarea" name="description" id="description"><?php echo $task['description']; ?></textarea>
        <p><span class="uk-button uk-button-primary" id="jqueryformsubmit">Update Task</span></p>
      </form>
      <script>
          CKEDITOR.replace( 'description' );
      </script>
    </div>
  </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
