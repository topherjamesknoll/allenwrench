<?php require_once '../config.php'; ?>
<?php user_redirect(); ?>

<?php

// Get users

connect();
$sql = "SELECT * FROM `members`";
$result = mysqli_query($connection, $sql);

?>

<?php require_once '../template-parts/header.php'; ?>

<h1>Members</h1>
<div class="uk-grid-match uk-child-width-1-2@m uk-child-width-1-3@l" uk-grid>
  <?php while($row = mysqli_fetch_assoc($result)) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
        <?php avatar($row['id'],100); ?>
          <p>
            <?php echo $row['user']; ?>
            <?php if ($row['title']!='') : echo ' | ' . $row['title']; endif; ?>
          </p>
          <?php if ($row['first']!='') : ?><h2 class="uk-card-title"><?php echo $row['first'] . ' ' . $row['last']; ?></h2><?php endif; ?>
          <?php if ($row['email']!='') : ?><p><a href="mailto:<?php echo $row['email']; ?>">Email</a></p><?php endif; ?>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<?php require_once '../template-parts/footer.php'; ?>
