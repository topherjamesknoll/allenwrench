<?php if (file_exists('config.php')) : require_once 'config.php'; else : header('Location: install.php'); endif; ?>
<?php user_redirect(); ?>

<?php require_once 'template-parts/header.php'; ?>

<div class="uk-grid-match" uk-grid>

<?php require_once 'template-parts/sidebar.php'; ?>

<div class="uk-width-2-3@m uk-width-3-4@l">

<div class="uk-section">
<div class="uk-container uk-container-expand">

<h1>Calendar</h1>
<p>See all the start and due dates for each of your tasks here in one place.</p>
<div class="uk-child-width-1-2@s uk-child-width-1-6@l uk-grid-match" uk-grid>
  <?php $date = date('Y-m-d'); ?>
  <?php for( $days = 0; $days < 18; $days++ ) : ?>
    <div>
      <div class="uk-card uk-card-default uk-card-body uk-card-hover">
        <p><?php echo date('D',strtotime($date)); ?></p>
        <h2><?php echo date('M j',strtotime($date)); ?></h2>
        <ul class="uk-list uk-list-divider">
          <?php
            // Get any due dates

            $due_dates = $mysqli->query("SELECT `name` FROM `tasks` WHERE `tasks`.`due` = '$date'");
            while ($due_date = $due_dates->fetch_assoc()) {
              if ($due_date['name'] != '') : echo '<li class="uk-text-danger uk-text-bold">Due: ' . $due_date['name'] . '</li>'; endif;
            }
          ?>
          <?php
            // Get any start dates

            $start_dates = $mysqli->query("SELECT `name` FROM `tasks` WHERE `tasks`.`start` = '$date'");
            while ($start_date = $start_dates->fetch_assoc()) {
              if ($start_date['name'] != '') : echo '<li class="uk-text-success">' . $start_date['name'] . '</li>'; endif;
            }
          ?>
          <?php $date = date('Y-m-d', strtotime('+1 day', strtotime($date))); ?>
        </ul>
      </div>
    </div>
  <?php endfor; ?>
</div>

</div>
</div>

</div>
</div>

<?php require_once 'template-parts/footer.php'; ?>
