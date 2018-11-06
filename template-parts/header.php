<head>
  <title>Allen Wrench</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo ABSPATH; ?>/css/style.css">
  <script src="<?php echo ABSPATH; ?>/js/ckeditor/ckeditor.js"></script>
  <script src="<?php echo ABSPATH; ?>/js/pikaday.js"></script>
</head>
<body>

<nav class="uk-navbar-container uk-light" uk-navbar uk-sticky>
  <div class="uk-navbar-left">
      <a class="uk-navbar-toggle" uk-toggle="target: #offcanvas-nav">
          <span uk-navbar-toggle-icon></span> <span class="uk-margin-small-left">Menu</span>
      </a>
  </div>
  <div class="uk-navbar-center">
    <ul class="uk-navbar-nav">
      <li>
        <a href="#"><?php avatar($_SESSION['user'],38); ?></a>
        <div uk-dropdown="pos: bottom-justify">
          <ul class="uk-nav uk-navbar-dropdown-nav">
            <li><a href="<?php echo ABSPATH; ?>/auth/add.php">Invite Members</a></li>
            <li><a href="<?php echo ABSPATH; ?>/auth/edit.php">Edit Profile</a></li>
            <li><a href="<?php echo ABSPATH; ?>/auth/logout.php">Logout</a></li>
            <li><a href="<?php echo ABSPATH; ?>/members/index.php">Members</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>

<div id="offcanvas-nav" uk-offcanvas="overlay: true">
  <div class="uk-offcanvas-bar">
    <h2><i class="far fa-project-diagram"></i> Allen Wrench</h2>
    <ul class="uk-nav uk-nav-default">
    <li><a href="<?php echo ABSPATH; ?>/activity.php">Activity</a></li>
    <li class="uk-nav-divider"></li>
    <li><a href="<?php echo ABSPATH; ?>/index.php">Teams</a></li>
    <li><a href="<?php echo ABSPATH; ?>/projects/index.php">Projects</a></li>
    <li><a href="<?php echo ABSPATH; ?>/tasks/index.php">Tasks</a></li>
    <li><a href="<?php echo ABSPATH; ?>/comments/index.php">Discussions</a></li>
    <li class="uk-nav-divider"></li>
    <li><a href="mailto:topher@getallenwrench.com">Email Support</a></li>
    </ul>
  </div>
</div>

<div class="uk-section uk-section-default">
  <div class="uk-container uk-container-expand">
