<?php

function user_redirect() {
  session_start();
  if (empty($_SESSION['user'])) {
    header('Location: ' . ABSPATH . '/auth/login.php');
  }
}

function get_team_and_project($team, $project) {

  global $team_id;
  global $project_id;

  session_start();
  if ($team != '') {
    $team_id = $_GET['team'];
    $_SESSION['team'] = $team_id;
  }
  else {
    $team_id = $_SESSION['team'];
  }
  if ($project != '') {
    $project_id = $_GET['project'];
    $_SESSION['project'] = $project_id;
  }
  else {
    $project_id = $_SESSION['project'];
  }

}

function avatar($user, $size) {

  // Get user name

  $mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
  $members = $mysqli->query("SELECT `user` FROM `members` WHERE `members`.`id` = '$user'");
  $member = $members->fetch_assoc();

  if (file_exists(dirname(__FILE__) . '/uploads/avatars/' . $user . '.jpg')) {
    echo '
        <span uk-tooltip="title: ' . $member['user'] . '"><img class="uk-border-circle" src="' . ABSPATH . '/uploads/avatars/' . $user . '.jpg" width="'. $size . '" height="' . $size . '"></span>
    ';
  }
  else {
    echo '
      <span uk-tooltip="title: ' . $member['user'] . '"><img class="uk-border-circle" src="' . ABSPATH . '/uploads/avatars/default.jpg" width="'. $size . '" height="' . $size . '"></span>
    ';
  }
}

function priority_class($priority) {
  if ($priority==3) {
    echo 'uk-alert-danger';
  }
  elseif ($priority==2) {
    echo 'uk-alert-warning';
  }
  else {
    return;
  }
}

function progress($progress) {
  if ($progress==3) {
    echo '<em class="uk-text-danger">On hold</em>';
  }
  elseif ($progress==2) {
    echo '<em class="uk-text-warning">In-progress</em>';
  }
  elseif ($progress==1) {
    echo '<em class="uk-text-success">Completed</em>';
  }
}

function user($user) {

  // Get user name

  $mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);
  $members = $mysqli->query("SELECT `user`,`first`,`last`,`title` FROM `members` WHERE `members`.`id` = '$user'");
  $member = $members->fetch_assoc();

  $first = $member['first'];
  $last = $member['last'];
  $username = $member['user'];
  $title = $member['title'];

  echo $username . ' | ';
  if ($first!='') {
    echo $first . ' ' . $last . ' | ';
  }
  if ($title!='') {
    echo $title . ' ';
  }
}

if(!function_exists("create_square_image")){
	function create_square_image($original_file, $destination_file=NULL, $square_size = 96){

		// function created by www.thewebhelp.com

		if(isset($destination_file) and $destination_file!=NULL){
			if(!is_writable($destination_file)){
				echo '<p style="color:#FF0000">Oops, the destination path is not writable. Make that file or its parent folder wirtable.</p>';
			}
		}

		// get width and height of original image
		$imagedata = getimagesize($original_file);
		$original_width = $imagedata[0];
		$original_height = $imagedata[1];

		if($original_width > $original_height){
			$new_height = $square_size;
			$new_width = $new_height*($original_width/$original_height);
		}
		if($original_height > $original_width){
			$new_width = $square_size;
			$new_height = $new_width*($original_height/$original_width);
		}
		if($original_height == $original_width){
			$new_width = $square_size;
			$new_height = $square_size;
		}

		$new_width = round($new_width);
		$new_height = round($new_height);

		// load the image
		if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg")){
			$original_image = imagecreatefromjpeg($original_file);
		}
		if(substr_count(strtolower($original_file), ".gif")){
			$original_image = imagecreatefromgif($original_file);
		}
		if(substr_count(strtolower($original_file), ".png")){
			$original_image = imagecreatefrompng($original_file);
		}

		$smaller_image = imagecreatetruecolor($new_width, $new_height);
		$square_image = imagecreatetruecolor($square_size, $square_size);

		imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

		if($new_width>$new_height){
			$difference = $new_width-$new_height;
			$half_difference =  round($difference/2);
			imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
		}
		if($new_height>$new_width){
			$difference = $new_height-$new_width;
			$half_difference =  round($difference/2);
			imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
		}
		if($new_height == $new_width){
			imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
		}


		// if no destination file was given then display a png
		if(!$destination_file){
			imagepng($square_image,NULL,9);
		}

		// save the smaller image FILE if destination file given
		if(substr_count(strtolower($destination_file), ".jpg")){
			imagejpeg($square_image,$destination_file,100);
		}
		if(substr_count(strtolower($destination_file), ".gif")){
			imagegif($square_image,$destination_file);
		}
		if(substr_count(strtolower($destination_file), ".png")){
			imagepng($square_image,$destination_file,9);
		}

		imagedestroy($original_image);
		imagedestroy($smaller_image);
		imagedestroy($square_image);

	}
}

function draw_calendar($month) {
  if ($month=='') { $month = date('n'); }
  $year = date('Y');

  /* draw table */
  $calendar = '<div class="uk-overflow-auto"><table class="uk-table uk-table-small" style="table-layout: fixed;">';

  /* table headings */
  $headings = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
  $calendar.= '<thead><tr><td>' . implode('</td><td>', $headings) . '</td></tr></thead>';

  /* days and weeks vars now ... */
  $running_day = date('w',mktime(0,0,0,$month,1,$year));
  $days_in_month = date('t',mktime(0,0,0,$month,1,$year));
  $days_in_this_week = 1;
  $day_counter = 0;
  $dates_array = array();

  /* row for week one */
  $calendar.= '<tbody><tr>';

  /* print "blank" days until the first of the current week */
  for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td> </td>';
    $days_in_this_week++;
  endfor;

  /* keep going with days.... */
  for($list_day = 1; $list_day <= $days_in_month; $list_day++):
    $calendar.= '<td>';
    /* add in the day number */
    $calendar.= '<p>'.$list_day.'</p>';

    /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
    $calendar.= str_repeat('<p> </p>',2);

    $due = $year . '-' . $month . '-' . str_pad($list_day, 2, '0', STR_PAD_LEFT);

    $mysqli = new mysqli(HOST,USER,PASSWORD,DATABASE);

    $due_dates = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`due` = '$due'");

    $calendar.= '<ul class="uk-list uk-list-divider">';
    while ($due_date = $due_dates->fetch_assoc()) {
      $calendar.= '<li class="uk-text-warning">Due: ' . $due_date['name'] . '</li>';
    }

    $start_dates = $mysqli->query("SELECT * FROM `tasks` WHERE `tasks`.`start` = '$due'");

    while ($start_date = $start_dates->fetch_assoc()) {
      $calendar.= '<li class="uk-text-success">' . $start_date['name'] . '</li>';
    }
    $calendar.='</ul>';

    $calendar.= '</td>';
    if($running_day == 6):
      $calendar.= '</tr>';
      if(($day_counter+1) != $days_in_month):
        $calendar.= '<tr>';
      endif;
      $running_day = -1;
      $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
  endfor;

  /* finish the rest of the days in the week */
  if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
      $calendar.= '<td> </td>';
    endfor;
  endif;

  /* final row */
  $calendar.= '</tr></tbody>';

  /* end the table */
  $calendar.= '</table></div>';

  /* all done, return result */
  return $calendar;
}

?>
