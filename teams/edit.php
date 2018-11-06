<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];

  connect();

  if (isset($_GET['name']) || isset($_GET['description'])) {

    $name = $_GET['name'];
    $description = $_GET['description'];

    $sql = "UPDATE `teams` SET `name` = '$name', `description` = '$description' WHERE `teams`.`id` = '$team_id'";
    mysqli_query($connection, $sql);

    header('Location: ' . ABSPATH . '/index.php');

  }

  // Get team info for form

  $sql = "SELECT * FROM `teams` WHERE `teams`.`id` = '$team_id'";
  $teams = mysqli_query($connection, $sql);
  $team = mysqli_fetch_assoc($teams);

  // Get members for checkmarks

  $sql = "SELECT `member` FROM `members_teams` WHERE `members_teams`.`team` = '$team_id'"
  $results = mysqli_query($connection, $sql);
  $row = mysqli_fetch_assoc($results);

  $sql = "SELECT * FROM `members` WHERE `members`.`id` = '$team_id'"
  $results = mysqli_query($connection, $sql);

  mysqli_close($connection);

}
else {
  header('Location: ' . ABSPATH . '/index.php');
}

?>

<?php require_once '../template-parts/header.php'; ?>

<form action="edit.php" method="get">
  <h1>Update Team</h1>
  <div class="uk-grid-match uk-child-width-1-2@s" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <h2 class="uk-card-title">Team Name:</h2>
        <input type="text" name="name" class="uk-input" value="<?php echo $team['name']; ?>" id="required">
        <h2 class="uk-card-title">Description:</h2>
        <textarea rows="8" class="uk-textarea" name="description"><?php echo $team['description']; ?></textarea>
        <p><input type="submit" value="Update Team" class="uk-button uk-button-primary submit"></p>
        <input type="hidden" name="teamid" value="<?php echo $row['id']; ?>">
      </div>
    </div>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <h2 class="uk-card-title">Team Members:</h2>
        <?php while ($member = mysqli_fetch_assoc($members)) : ?>
          <p>
            <?php avatar($member['id'],38); ?>&nbsp;
            <input type="checkbox" class="uk-checkbox" name="" value="">&nbsp;
            <?php if ($member['user'] != '') : echo $member['user']; endif; ?>
            <?php if ($member['first'] != '') : echo ' | ' . $member['first']; endif; ?>
            <?php if ($member['last'] != '') : echo ' ' . $member['last']; endif; ?>
            <?php if ($member['title'] != '') : echo ' | ' .$member['title']; endif; ?>
          </p>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</form>

<?php require_once '../template-parts/footer.php'; ?>
