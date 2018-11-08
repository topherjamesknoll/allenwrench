<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

session_start();
if (isset($_SESSION['team'])) { $team_id = $_SESSION['team']; }
if (isset($_SESSION['project'])) { $project_id = $_SESSION['project']; }

// Read form

if (isset($_POST['task']) || isset($_POST['start']) || isset($_POST['due']) || isset($_POST['progress']) || isset($_POST['priority']) || isset($_POST['budget']) || isset($_POST['goal']) || isset($_POST['description'])) {
  $task = $_POST['task'];
  $start = $_POST['start'];
  $start = date('Y-m-d', strtotime(str_replace('-', '/', $start)));
  $due = $_POST['due'];
  $due = date('Y-m-d', strtotime(str_replace('-', '/', $due)));
  $progress = $_POST['progress'];
  $priority = $_POST['priority'];
  $budget = str_replace(',', '', $_POST['budget']);
  $goal = str_replace(',', '', $_POST['goal']);
  $description = $_POST['description'];
  // Insert data

  $mysqli->query("INSERT INTO `tasks` (`name`, `start`, `due`, `progress`, `priority`, `description`, `team`, `project`, `budget`, `goal`) VALUES ('$task', '$start', '$due', '$progress', '$priority', '$description', '$team_id', '$project_id', '$budget', '$goal')");

}

// Get tasks
$tasks = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`project` = '$project_id' ORDER BY `due`");

// Get projects

$projects = $mysqli->query("SELECT `name`, `description` FROM `projects` WHERE `projects`.`id` = '$project_id'");
$project = $projects->fetch_assoc();

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
      <p class="uk-text-bold"><?php echo $tasks->num_rows; ?> tasks for</p>
      <h1><?php if ($project['name']!='') : echo $project['name']; else : ?>Untitled<?php endif; ?></h1>
      <p><?php echo $project['description']; ?></p>
    </div>
    <div>
      <a href="#addtask" class="uk-button uk-button-primary">Add Task</a>
    </div>
  </div>
  <div class="uk-child-width-1-1" uk-grid>
    <?php while ($task = $tasks->fetch_assoc()) : ?>
      <div>
        <div class="uk-card uk-card-default uk-card-small <?php priority_class($task['priority']); ?>">
          <div class="uk-card-body">
            <p class="uk-text-right">
              <a href="<?php echo ABSPATH; ?>/tasks/edit.php?id=<?php echo $task['id']; ?>"><i class="far fa-wrench"></i></a>
              <a href="<?php echo ABSPATH; ?>/tasks/delete.php?task=<?php echo $task['id']; ?>"><i class="far fa-trash-alt"></i></a>
            </p>
            <h2 class="uk-card-title">
              <?php if ($task['name']!='') : echo $task['name']; else : ?>Untitled<?php endif; ?>
            </h2>
            <p><?php echo $task['description']; ?></p>
            <p>
              <?php if ($task['due'] != '1969-12-31' && $task['due'] != '0000-00-00') : echo 'Due <strong>'. date('M j, Y', strtotime($task['due'])) . '</strong>'; else : echo 'No due date'; endif; ?>
                <?php if ($task['budget'] != '') : echo '| Budget <strong>$'. number_format($task['budget']) . '</strong>'; endif; ?>
                <?php if ($task['goal'] != '') : echo '| Goal <strong>$'. number_format($task['goal']) . '</strong>'; endif; ?>
                <?php progress($task['progress']); ?>
            </p>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    <h1 id="addtask">Add a Task</h1>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <form action="index.php" method="post" id="cmxform">
          <p>Task:</p>
          <p><input type="text" name="task" class="uk-input" required></p>
          <div class="uk-child-width-1-2" uk-grid>
            <div>
              <p>Start Date:</p>
              <p><input type="text" name="start" id="datepicker1" class="uk-input"></p>
            </div>
            <div>
              <p>Due Date:</p>
              <p><input type="text" name="due" id="datepicker2" class="uk-input"></p>
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
              <p><input type="text" name="budget" class="uk-input"></p>
            </div>
            <div>
              <p>Goal:</p>
              <p><input type="text" name="goal" class="uk-input"></p>
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
          <textarea rows="8" class="uk-textarea" name="description" id="description"></textarea>
          <p><input type="submit" class="uk-button uk-button-primary" value="Add Task"></p>
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
<?php else : ?>
  <div class="uk-alert-warning" uk-alert>
    <a class="uk-alert-close" uk-close></a>
    <h3>No Project</h3>
    <p>Please go back and select a project.</p>
  </div>
<?php endif; ?>

</div>
</div>

</div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
