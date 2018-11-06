<?php require_once 'config.php'; ?>
<?php user_redirect(); ?>

<?php require_once 'template-parts/header.php'; ?>

<?php

connect();

?>
<h1>Calendar</h1>
<p>See all the start and due dates for each of your tasks here in one place.</p>
<div class="uk-child-width-1-2@s uk-child-width-1-4@l uk-grid-match" uk-grid>
  <?php $date = date('Y-m-d'); ?>
  <?php for( $days = 0; $days < 16; $days++ ) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-hover">
        <p><?php echo date('D',strtotime($date)); ?></p>
        <h2><?php echo date('M j',strtotime($date)); ?></h2>
        <ul class="uk-list uk-list-divider">
          <?php
            // Get any due dates

            $sql = "SELECT `name` FROM `tasks` WHERE `tasks`.`start` = '$date'";
            $start_dates = mysqli_query($connection, $sql);
            while ($start_date = mysqli_fetch_assoc($start_dates)) {
              if ($start_date['name'] != '') : echo '<li class="uk-text-success">Start: ' . $start_date['name'] . '</li>'; endif;
            }
          ?>
          <?php
            // Get any due dates

            $sql = "SELECT `name` FROM `tasks` WHERE `tasks`.`due` = '$date'";
            $due_dates = mysqli_query($connection, $sql);
            while ($due_date = mysqli_fetch_assoc($due_dates)) {
              if ($due_date['name'] != '') : echo '<li class="uk-text-danger">Due: ' . $due_date['name'] . '</li>'; endif;
            }
          ?>
          <?php $date = date('Y-m-d', strtotime('+1 day', strtotime($date))); ?>
        </ul>
      </div>
    </div>
  <?php endfor; ?>
</div>

<?php require_once 'template-parts/footer.php'; ?>
