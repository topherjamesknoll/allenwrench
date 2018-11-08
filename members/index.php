<?php if (file_exists('../config.php')) : require_once '../config.php'; else : header('Location: ' . ABSPATH . '/install.php'); endif; ?>
<?php user_redirect(); ?>

<?php

// Get users

$members = $mysqli->query("SELECT * FROM `members`");

?>

<?php require_once '../template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once '../template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<h1>Members</h1>
<div class="uk-grid-match uk-child-width-1-2@s" uk-grid>
  <?php while($member = $members->fetch_assoc()) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-small uk-card-hover">
        <article class="uk-comment">
          <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
            <div class="uk-width-auto">
              <?php avatar($member['id'],100); ?>
            </div>
            <div class="uk-width-expand">
              <h4 class="uk-comment-title uk-margin-remove"><?php echo user($member['id']); ?></h4>
            </div>
          </header>
        </article>
      </div>
    </div>
  <?php endwhile; ?>
</div>

</div>
</div>

</div>
</div>

<?php require_once '../template-parts/footer.php'; ?>
