<?php

function user_redirect() {
  session_start();
  if (empty($_SESSION['user'])) {
    header('Location: ' . ABSPATH . '/auth/login.php');
  }
}

function connect() {
  global $connection;
  $connection = mysqli_connect(HOST,USER,PASSWORD,DATABASE);
}

function avatar($user, $size) {

  // Get user name

  $connection = mysqli_connect(HOST,USER,PASSWORD,DATABASE);
  $sql = "SELECT `user` FROM `members` WHERE `members`.`id` = '$user'";
  $result = mysqli_query($connection, $sql);
  $row = mysqli_fetch_assoc($result);

  if (file_exists(dirname(__FILE__) . '/uploads/avatars/' . $user . '.jpg')) {
    echo '
        <div uk-tooltip="title: ' . $row['user'] . '"><img class="uk-border-circle" src="' . ABSPATH . '/uploads/avatars/' . $user . '.jpg" width="'. $size . '" height="' . $size . '"></div>
    ';
  }
  else {
    echo '
      <div uk-tooltip="title: ' . $row['user'] . '"><img class="uk-border-circle" src="' . ABSPATH . '/uploads/avatars/default.jpg" width="'. $size . '" height="' . $size . '"></div>
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
    echo ' | <strong><em>On hold</em></strong>';
  }
  elseif ($progress==2) {
    echo ' | <strong><em>In-progress</em></strong>';
  }
  elseif ($progress==1) {
    echo ' | <strong><em>Completed</em></strong>';
  }
}

function user($user) {

  // Get user name

  $connection = mysqli_connect(HOST,USER,PASSWORD,DATABASE);
  $sql = "SELECT `user`,`first`,`last`,`title` FROM `members` WHERE `members`.`id` = '$user'";
  $result = mysqli_query($connection, $sql);
  $row = mysqli_fetch_assoc($result);

  $first = $row['first'];
  $last = $row['last'];
  $username = $row['user'];
  $title = $row['title'];

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

?>
