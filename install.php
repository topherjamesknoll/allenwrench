<?php

if (isset($_POST['host']) && isset($_POST['database']) && isset($_POST['databaseuser']) && isset($_POST['databasepassword']) && isset($_POST['administratoruser']) && isset($_POST['administratorpassword'])) {

  $host = $_POST['host'];
  $database = $_POST['database'];
  $database_user = $_POST['databaseuser'];
  $database_password = $_POST['databasepassword'];
  $administrator_user = strtolower($_POST['administratoruser']);
  $administrator_password = $_POST['administratorpassword'];

  // Create tables

  $connection = mysqli_connect($host, $database_user, $database_password, $database);
  $sql = "CREATE TABLE `members` (
      id INT(11) NOT NULL AUTO_INCREMENT,
      email VARCHAR(255) NOT NULL,
      confirmation VARCHAR(255) NOT NULL,
      active INT(11) NOT NULL,
      user VARCHAR(255) NOT NULL,
      password VARCHAR(255) NOT NULL,
      first VARCHAR(255) NOT NULL,
      last VARCHAR(255) NOT NULL,
      title VARCHAR(255) NOT NULL,
      PRIMARY KEY (`id`)
    )
  ";
  mysqli_query($connection, $sql);

  $sql = "CREATE TABLE `teams` (
      id INT(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      description TEXT NOT NULL,
      PRIMARY KEY (`id`)
    )
  ";
  mysqli_query($connection, $sql);

  $sql = "CREATE TABLE `activity` (
      id INT(11) NOT NULL AUTO_INCREMENT,
      description TEXT NOT NULL,
      author INT(11) NOT NULL,
      time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      link VARCHAR(255) NOT NULL,
      PRIMARY KEY (`id`)
    )
  ";
  mysqli_query($connection, $sql);

  $sql = "CREATE TABLE `members_teams` (
      member INT(11) NOT NULL,
      team INT(11) NOT NULL
    )
  ";
  mysqli_query($connection, $sql);

  $sql = "CREATE TABLE `projects` (
      id INT(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      description TEXT NOT NULL,
      goal INT(11) NOT NULL,
      budget INT(11) NOT NULL,
      team INT(11) NOT NULL,
      PRIMARY KEY (`id`)
    )
  ";
  mysqli_query($connection, $sql);

  $sql = "CREATE TABLE `tasks` (
      id INT(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      description TEXT NOT NULL,
      team INT(11) NOT NULL,
      project INT(11) NOT NULL,
      progress INT(11) NOT NULL,
      priority INT(11) NOT NULL,
      budget INT(11) NOT NULL,
      goal INT(11) NOT NULL,
      start DATE NOT NULL,
      due DATE NOT NULL,
      PRIMARY KEY (`id`)
    )
  ";
  mysqli_query($connection, $sql);

  $sql = "CREATE TABLE `comments` (
      id INT(11) NOT NULL AUTO_INCREMENT,
      subject VARCHAR(255) NOT NULL,
      comment TEXT NOT NULL,
      team INT(11) NOT NULL,
      project INT(11) NOT NULL,
      author INT(11) NOT NULL,
      time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    )
  ";
  mysqli_query($connection, $sql);

  // Create config.php

  $abspath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER[PHP_SELF]);


  $config_file = fopen("config.php", "w");
  $config_body = "
    <?

    // Variables

    define('HOST','" . $host . "');
    define('USER','" . $database_user . "');
    define('PASSWORD','" . $database_password . "');
    define('DATABASE','" . $database . "');

    define('ABSPATH','" . $abspath . "');

    // Functions

    require_once 'functions.php';

    ?>
  ";
  fwrite($config_file, $config_body);
  fclose($config_file);

  // Create admin user

  $administrator_password = hash('ripemd160', $administrator_password);

  $sql = "INSERT INTO `members` (`user`,`password`,`active`, `title`) VALUES ('$administrator_user', '$administrator_password', '1', 'Administrator')";
  mysqli_query($connection, $sql);

  if (isset($_POST['examples'])) {

    // Create dummy members

    $sql = "INSERT INTO `members` (`user`, `first`, `last`, `active`, `title`) VALUES ('tom', 'Tom', 'Wrench', '1', 'Dummy');";
    $sql.= "INSERT INTO `members` (`user`, `first`, `last`, `active`, `title`) VALUES ('sally', 'Sally', 'Wrench', '1', 'Dummy');";

    // Create dummy teams

    $sql.= "INSERT INTO `teams` (`name`,`description`) VALUES ('Maintenance', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');";
    $sql.= "INSERT INTO `teams` (`name`,`description`) VALUES ('IT', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');";
    $sql.= "INSERT INTO `teams` (`name`,`description`) VALUES ('Marketing', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');";
    $sql.= "INSERT INTO `teams` (`name`,`description`) VALUES ('Human Resources', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');";
    $sql.= "INSERT INTO `teams` (`name`,`description`) VALUES ('Business Development', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.');";

    // Asign members to teams

    $sql.= "INSERT INTO `members_teams` (`member`,`team`) VALUES ('1', '1');";
    $sql.= "INSERT INTO `members_teams` (`member`,`team`) VALUES ('2', '2');";
    $sql.= "INSERT INTO `members_teams` (`member`,`team`) VALUES ('1', '3');";
    $sql.= "INSERT INTO `members_teams` (`member`,`team`) VALUES ('2', '3');";
    $sql.= "INSERT INTO `members_teams` (`member`,`team`) VALUES ('3', '3');";

    // Create dummy activity

    $sql.= "INSERT INTO `activity` (`description`, `author`, `link`) VALUES ('added a team', '1', '/teams/index.php');";
    $sql.= "INSERT INTO `activity` (`description`, `author`, `link`) VALUES ('deleted a team', '3', '/teams/index.php');";
    $sql.= "INSERT INTO `activity` (`description`, `author`, `link`) VALUES ('modified a task', '2', '/tasks/index.php');";
    $sql.= "INSERT INTO `activity` (`description`, `author`, `link`) VALUES ('made a comment', '1', '/comments/index.php');";

    // Create dummy projects

    $sql.= "INSERT INTO `projects` (`name`,`description`, `team`) VALUES ('Spring Cleaning', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1');";
    $sql.= "INSERT INTO `projects` (`name`,`description`, `team`) VALUES ('Winter Cleaning', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1');";
    $sql.= "INSERT INTO `projects` (`name`,`description`, `team`) VALUES ('Upgrade Computers and Software', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2');";

    // Create dummy tasks

    $sql.= "INSERT INTO `tasks` (`name`,`description`, `team`, `project`, `progress`, `priority`, `budget`, `goal`) VALUES ('Scrub the toilets', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '1', '1', '14000', '20000');";
    $sql.= "INSERT INTO `tasks` (`name`,`description`, `team`, `project`, `progress`, `priority`, `budget`, `goal`) VALUES ('Scrub the shower', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '2', '2', '12000', '30000');";
    $sql.= "INSERT INTO `tasks` (`name`,`description`, `team`, `project`, `progress`, `priority`, `budget`, `goal`) VALUES ('Clean the sink', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '3', '1', '10000', '4000');";
    $sql.= "INSERT INTO `tasks` (`name`,`description`, `team`, `project`, `progress`, `priority`, `budget`, `goal`) VALUES ('Take out the trash', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '1', '3', '1000', '700');";
    $sql.= "INSERT INTO `tasks` (`name`,`description`, `team`, `project`, `progress`, `priority`, `budget`, `goal`) VALUES ('Install Allen Wrench on all Institution Computers', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2', '1', '1', '3', '0', '10000');";

    // Create dummy comments

    $sql.= "INSERT INTO `comments` (`subject`,`comment`, `team`, `project`, `author`) VALUES ('This is the first comment in the database', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '1');";
    $sql.= "INSERT INTO `comments` (`subject`,`comment`, `team`, `project`, `author`) VALUES ('This is the second comment in the database', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '1');";
    $sql.= "INSERT INTO `comments` (`subject`,`comment`, `team`, `project`, `author`) VALUES ('This is the third comment in the database', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '1');";
    $sql.= "INSERT INTO `comments` (`subject`,`comment`, `team`, `project`, `author`) VALUES ('This is the fourth comment in the database', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '1', '1', '2')";

    mysqli_multi_query($connection, $sql);

  }

  mysqli_close($connection);



  // Send to homepage

  header('Location: index.php');

}
else if (file_exists('config.php')) {
  header('Location: index.php');
}

?>

<!-- Output form -->

<head>
  <title>Install Allen Wrench</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>
  html {
    background:url('images/background.jpg'); no-repeat center center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
  }
</style>
<div uk-grid>
  <div class="uk-width-1-4@m"></div>
  <div class="uk-width-1-2@m uk-padding">
    <h1 class="uk-text-center title"><i class="far fa-project-diagram"></i> Install Allen Wrench</h1>
  </div>
</div>
<form action="install.php" method="post">
  <div uk-grid>
    <div class="uk-width-1-4@m"></div>
    <div class="uk-width-1-2@m">
      <div class="uk-card uk-card-default uk-card-body uk-visible" id="installcardone">
        <h2 class="uk-card-title">Database</h2>
        <p>This will tell Allen Wrench where to store your information. You must have an existing database for AW to run. <a href="https://support.hostgator.com/articles/cpanel/how-do-i-create-a-mysql-database-a-user-and-then-delete-if-needed" target="_blank">Click here for some instructions on how to create a database.</a></p>
        <hr>
        <p>Host:</p>
        <p><input type="text" name="host" class="uk-input"></p>
        <p>Database name:</p>
        <p><input type="text" name="database" class="uk-input"></p>
        <p>Database username:</p>
        <p><input type="text" name="databaseuser" class="uk-input"></p>
        <p>Database password:</p>
        <p><input type="password" name="databasepassword" class="uk-input"></p>
        <p><input type="button" id="installnextbutton" value="Next" class="uk-button uk-button-primary uk-button-large">
        <p>Need help? Email <a href="mailto:topher@allenwrench.com">topher@allenwrench.com</a></p>
      </div>
      <div class="uk-card uk-card-default uk-card-body uk-hidden" id="installcardtwo">
        <h2 class="uk-card-title">Administration</h2>
        <p>Now we need to setup an administration username and password. Choose something good!</p>
        <hr>
        <p>Administrator username:</p>
        <p><input type="text" name="administratoruser" class="uk-input"></p>
        <p>Administrator password:</p>
        <p><input type="password" name="administratorpassword" class="uk-input"></p>
        <p><input type="checkbox" name="examples" value="true" checked class="uk-checkbox"> Install example projects</p>
        <p><input type="submit" value="Install" class="uk-button uk-button-primary uk-button-large">
        <p>Need help? Email <a href="mailto:topher@allenwrench.com">topher@allenwrench.com</a></p>
      </div>
    </div>
  </div>
</form>
<script src="js/jquery.min.js"></script>
<script src="js/uikit.min.js"></script>
<script src="js/custom.js"></script>
</body>
