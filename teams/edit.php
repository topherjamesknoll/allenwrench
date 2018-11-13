<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ../install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

if (isset($_GET['teamid'])) {

  $team_id = $_GET['teamid'];

  if (isset($_GET['name']) || isset($_GET['description'])) {

    $name = $_GET['name'];
    $description = $_GET['description'];

    $mysqli->query("UPDATE `teams` SET `name` = '$name', `description` = '$description' WHERE `teams`.`id` = '$team_id'");

    header('Location: ' . ABSPATH . '/index.php');

  }

  // Get team info for form

  $teams = $mysqli->query("SELECT * FROM `teams` WHERE `teams`.`id` = '$team_id'");
  $team = $teams->fetch_assoc();

  // Get members for checkmarks

  $members = $mysqli->query("SELECT `id` FROM `members`");

}
else {
  header('Location: ' . ABSPATH . '/index.php');
}

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<form action="edit.php" method="get" id="cmxform">
  <h1>Update Team</h1>
  <div class="uk-grid-match uk-child-width-1-2@s" uk-grid>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <h2 class="uk-card-title">Team Name:</h2>
        <input type="text" name="name" class="uk-input" value="<?php echo $team['name']; ?>" required>
        <h2 class="uk-card-title">Description:</h2>
        <textarea rows="8" class="uk-textarea" name="description" id="description"><?php echo $team['description']; ?></textarea>
        <p><input type="submit" value="Update Team" class="uk-button uk-button-primary submit"></p>
        <input type="hidden" name="teamid" value="<?php echo $team['id']; ?>">
      </div>
    </div>
    <div>
      <div class="uk-card uk-card-default uk-card-small uk-card-body">
        <h2 class="uk-card-title">Team Members:</h2>
        <?php
          function checkmark($person) {
            // Get team id

            $team_id = $_GET['teamid'];

            // Get user id

            $mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
            $result = $mysqli->query("SELECT * FROM `members_teams` WHERE `members_teams`.`member` = '$person' AND `members_teams`.`team` = '$team_id'");

            // if match

            if ($result->num_rows==1) : echo'checked'; endif;

          }
        ?>
        <?php while ($member = $members->fetch_assoc()) : ?>
          <p>
            <?php avatar($member['id'],38); ?>&nbsp;
            <input type="checkbox" <?php checkmark($member['id']); ?> class="uk-checkbox" name="<?php echo $member['id']; ?>">&nbsp;
            <?php user($member['id']); ?>
          </p>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
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

<?php require_once '../template-parts/footer.php'; ?>
