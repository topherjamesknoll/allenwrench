<head>
  <title>Allen Wrench</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo ABSPATH; ?>/css/style.css">
</head>
<body>

<nav class="uk-navbar-container" uk-navbar uk-sticky>
  <div class="uk-navbar-left">
    <a class="uk-navbar-item uk-logo" href="<?php echo ABSPATH; ?>"><span class="uk-visible@s"><i class="far fa-project-diagram"></i></span>&nbsp;AW</a>
    <ul class="uk-navbar-nav">
      <li><a href="<?php echo ABSPATH; ?>/index.php"><span class="uk-hidden@s"><i class="far fa-users"></i></span><span class="uk-visible@s">&nbsp;Teams</span></a></li>
      <li><a href="<?php echo ABSPATH; ?>/projects/index.php"><span class="uk-hidden@s"><i class="far fa-project-diagram"></i></span><span class="uk-visible@s">&nbsp;Projects</a></span></li>
      <li><a href="<?php echo ABSPATH; ?>/comments/index.php"><span class="uk-hidden@s"><i class="far fa-comment"></i></span><span class="uk-visible@s">&nbsp;Comments</a></span></li>
      <li><a href="mailto:topher@getallenwrench.com"><span class="uk-hidden@s"><i class="far fa-life-ring"></i></span><span class="uk-visible@s">&nbsp;Support</a></span></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a href="<?php echo ABSPATH; ?>/members/index.php">Members</a></li>
      <li>
        <a href="#"><?php avatar($_SESSION['user'],38); ?></a>
        <div class="uk-navbar-dropdown">
          <ul class="uk-nav uk-navbar-dropdown-nav">
            <li class="uk-active"><a href="<?php echo ABSPATH; ?>/auth/add.php">Invite Members</a></li>
            <li><a href="<?php echo ABSPATH; ?>/auth/edit.php">Edit Profile</a></li>
            <li><a href="<?php echo ABSPATH; ?>/auth/logout.php">Logout</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>

<div class="uk-container">
