<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

session_start();
if (isset($_SESSION['project'])) { $project_id = $_SESSION['project']; }

connect();

// Read form

if (isset($_POST['task']) || isset($_POST['due']) || isset($_POST['progress']) || isset($_POST['description'])) {
  $task = $_POST['task'];
  $due = $_POST['due'];
  $due = date('Y-m-d', strtotime(str_replace('-', '/', $due)));
  $progress = $_POST['progress'];
  $budget = str_replace(',', '', $_POST['budget']);
  $goal = str_replace(',', '', $_POST['goal']);
  $description = $_POST['description'];

  // Insert data

  $sql = "INSERT INTO `tasks` (`name`, `due`, `progress`, `description`, `project`, `budget`, `goal`) VALUES ('$task', '$due', '$progress', '$description', '$project_id', '$budget', '$goal')";
  mysqli_query($connection, $sql);

}

// Get tasks

$sql = "SELECT * FROM `tasks` WHERE `tasks`.`project` = '$project_id' ORDER BY `due`";
$tasks = mysqli_query($connection, $sql);

// Get projects

$sql = "SELECT `name`, `description` FROM `projects` WHERE `projects`.`id` = '$project_id'";
$projects = mysqli_query($connection, $sql);
$project = mysqli_fetch_assoc($projects);
mysqli_close($connection)

?>

<?php require_once '../template-parts/header.php'; ?>

<div uk-grid>
  <div>
    <p class="uk-text-bold"><?php echo mysqli_num_rows($tasks); ?> Tasks for</p>
    <h1><?php if ($project['name']!='') : echo $project['name']; else : ?>Untitled<?php endif; ?></h1>
    <p><?php echo $project['description']; ?></p>
  </div>
  <div class="uk-width-expand uk-text-right">
    <a href="#jqueryform" class="uk-button uk-button-primary">Add Task</a>
  </div>
</div>
<div class="uk-child-width-1-1" uk-grid>
  <?php while ($task = mysqli_fetch_assoc($tasks)) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-small <?php progress_class($task['progress']); ?>">
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
            <?php if ($task['due'] != '1969-12-31' && $task['due'] != '0000-00-00') : echo 'Due '. date('M j, Y', strtotime($task['due'])); else : echo 'No due date'; endif; ?>
              <?php if ($task['budget'] != '') : echo '| Budget $'. number_format($task['budget']); endif; ?>
              <?php if ($task['goal'] != '') : echo '| Goal $'. number_format($task['goal']); endif; ?>
              <?php progress($task['progress']); ?>
          </p>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
  <div>
    <div class="uk-card uk-card-default uk-card-small uk-card-body">
      <form action="index.php" method="post" id="jqueryform">
        <p>Task:</p>
        <p><input type="text" name="task" class="uk-input"></p>
        <p>Due:</p>
        <p><input type="text" name="due" id="datepicker" class="uk-input"></p>
        <p>Progress:</p>
        <select name="progress" class="uk-select">
          <option value="2" selected>In-progress</option>
          <option value="3">On hold</option>
          <option value="1">Completed</option>
          <option>N/A</option>
        </select>
        <p>Budget:</p>
        <p><input type="text" name="budget" class="uk-input"></p>
        <p>Goal:</p>
        <p><input type="text" name="goal" class="uk-input"></p>
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
        <textarea rows="8" class="uk-textarea" name="description" id="description"></textarea>
        <p><span class="uk-button uk-button-primary" id="jqueryformsubmit">Get Started</span></p>
      </form>
      <script>
          CKEDITOR.replace( 'description' );
      </script>
    </div>
  </div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
