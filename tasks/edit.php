<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

// Read form

if (isset($_GET['id'])) { $id = $_GET['id']; }

if (isset($_GET['taskname']) || isset($_GET['description']) || isset($_GET['progress']) || isset($_GET['priority']) || isset($_GET['budget']) || isset($_GET['goal']) || isset($_GET['start']) || isset($_GET['due'])) {

  $task_name = $_GET['taskname'];
  $description = $_GET['description'];
  $progress = $_GET['progress'];
  $priority = $_GET['priority'];
  $budget = str_replace('$','',str_replace(',', '', $_GET['budget']));
  $goal = str_replace('$','',str_replace(',', '', $_GET['goal']));
  $start = $_GET['start'];
  $start = date('Y-m-d', strtotime(str_replace('-', '/', $start)));
  $due = $_GET['due'];
  $due = date('Y-m-d', strtotime(str_replace('-', '/', $due)));

  //Update task in database

  $mysqli->query("UPDATE `tasks` SET `name` = '$task_name', `description` = '$description', `progress` = '$progress', `priority` = '$priority', `budget` = '$budget', `goal` = '$goal', `start` = '$start', `due` = '$due' WHERE `tasks`.`id` = '$id'");

  header('Location: ' . ABSPATH . '/tasks/index.php');

}

// Get tasks

$tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`id` = '$id'");
$task = $tasks->fetch_assoc();

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<h1>Update Task</h1>
<div class="uk-child-width-1-1" uk-grid>
  <div>
    <div class="uk-card uk-card-default uk-card-small uk-card-body">
      <form action="edit.php" method="get" id="cmxform">
        <input type="hidden" name="id" value="<?php echo $id; ?>"
        <p>Name:</p>
        <p><input type="text" name="taskname" class="uk-input" value="<?php echo $task['name']; ?>" required></p>
        <div class="uk-child-width-1-2" uk-grid>
          <div>
            <p>Start Date:</p>
            <p><input type="text" name="start" id="datepicker1" class="uk-input" value="<?php echo $task['start']; ?>"></p>
          </div>
          <div>
            <p>Due Date:</p>
            <p><input type="text" name="due" id="datepicker2" class="uk-input" value="<?php echo $task['due']; ?>"></p>
          </div>
          <div>
            <p>Progress:</p>
            <select name="progress" class="uk-select">
              <option value="2" selected>In-progress</option>
              <option value="3">On hold</option>
              <option value="1">Completed</option>
            </select>
          </div>
          <div>
            <p>Priority:</p>
            <select name="priority" class="uk-select">
              <option value="1" selected>None</option>
              <option value="2">Medium</option>
              <option value="3">High</option>
            </select>
          </div>
          <div>
            <p>Budget:</p>
            <p><input type="text" name="budget" class="uk-input" value="<?php echo $task['budget']; ?>"></p>
          </div>
          <div>
            <p>Goal:</p>
            <p><input type="text" name="goal" class="uk-input" value="<?php echo $task['goal']; ?>"></p>
          </div>
        </div>
        <script>
          var picker = new Pikaday(
          {
            field: document.getElementById('datepicker1'),
            firstDay: 1,
            minDate: new Date(),
            maxDate: new Date(2020, 12, 31),
            yearRange: [2000,2020]
          });
          var picker = new Pikaday(
          {
            field: document.getElementById('datepicker2'),
            firstDay: 1,
            minDate: new Date(),
            maxDate: new Date(2020, 12, 31),
            yearRange: [2000,2020]
          });
        </script>
        <p>Description:</p>
        <textarea rows="8" class="uk-textarea" name="description" id="description"><?php echo $task['description']; ?></textarea>
        <p><input type="submit" class="uk-button uk-button-primary" value="Update Task"></p>
      </form>
      <script>
          CKEDITOR.replace( 'description' );
      </script>
      <script>
        $("#cmxform").validate();
      </script>
    </div>
  </div>
</div>

</div>

</div>

</div>

<?php require_once '../template-parts/footer.php'; ?>
