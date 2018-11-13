<?php if (file_exists('config.php')) : require_once 'config.php'; else : header('Location: install.php'); endif; ?>
<?php user_redirect(); ?>

<?php require_once 'template-parts/header.php'; ?>

<?php

if (isset($_POST['month'])) {
  $month_number=$_POST['month'];
  $date = DateTime::createFromFormat('!m', $month_number);
  $month_name = $date->format('F');
}





 ?>

<div class="uk-grid-match" uk-grid>

<?php require_once 'template-parts/sidebar.php'; ?>

<div class="uk-width-expand">

<div class="uk-section">

<div uk-grid>
  <div class="uk-width-expand@s">
    <h1>
      <?php if (isset($_POST['month'])) : echo $month_name . ' ' . date('Y'); else : echo 'Calendar'; endif; ?>
    </h1>
		<p>See all the start and due dates for each of your tasks here in one place.</p>
  </div>
  <div>
		<form action="calendar3.php" method="post">
			<select name="month" class="uk-select uk-form-width-small" id="months">
        <option>Month</option>
        <option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
				<option value="04">April</option>
				<option value="05">May</option>
				<option value="06">June</option>
				<option value="07">July</option>
				<option value="08">August</option>
				<option value="09">September</option>
				<option value="10">October</option>
				<option value="11">November</option>
				<option value="12">December</option>
			</select>
			<input type="submit" class="uk-hidden">
    	<a href="<?php echo ABSPATH; ?>/tasks/index.php#addtask" class="uk-button uk-button-primary">Add Task</a>
		</form>
  </div>
</div>
<?php echo draw_calendar($month_number); ?>

</div>

</div>

</div>

<?php require_once 'template-parts/footer.php'; ?>
