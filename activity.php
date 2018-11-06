<?php require_once 'config.php'; ?>
<?php user_redirect(); ?>

<?php

// Get Comments

connect();
$sql = "SELECT * FROM `activity` ORDER BY `time`";
$activities = mysqli_query($connection, $sql);
mysqli_close($connection);

?>

<?php require_once 'template-parts/header.php'; ?>

<?php if (mysqli_num_rows($activities)==1) : ?>
  <div uk-alert class="uk-alert-warning">
  <a class="uk-alert-close" uk-close></a>
  <h3>Let's get to work!</h3>
  <p>Anytime someone changes a team or project, or leaves a comment, or completes a task, you will see it here.</p>
</div>
<?php else : ?>
  <h1>Activity</h1>
  <div class="uk-child-width-1-1" uk-grid>
    <?php while($activity = mysqli_fetch_assoc($activities)) : ?>
      <div>
        <div class="uk-card uk-card-default uk-card-body uk-card-small">
          <article class="uk-comment">
            <header class="uk-comment-header uk-grid-medium uk-flex-middle" uk-grid>
              <div class="uk-width-auto">
                <?php avatar($activity['author'],38); ?>
              </div>
              <div class="uk-width-expand">
                <h4 class="uk-comment-title uk-margin-remove"><?php echo user($activity['author']); ?></h4>
                <ul class="uk-comment-meta uk-subnav uk-subnav-divider uk-margin-remove-top">
                  <li style="flex: 0 1 auto;">on <?php echo date('M j g:i A', $comment['time']); ?></li>
                </ul>
              </div>
            </header>
          <div class="uk-comment-body">
            <p><a href="<?php echo ABSPATH . $activity['link']; ?>"><?php echo $activity['description']; ?> on <?php echo date('M j g:i A', $activity['time']); ?></a></p>
          </div>
          </article>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php endif; ?>

<?php require_once 'template-parts/footer.php'; ?>
