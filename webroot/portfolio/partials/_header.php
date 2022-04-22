<?php
  session_start();

  if (isset($_SESSION['id'])) {
    require_once 'scripts/db-connect.php';
    require_once 'classes/models/User.class.php';

    // TODO handle invalid id in user class
    $user = new User($_SESSION['id'], $db);
    $logged_in = true;
  } else {
    $logged_in = false;
  }
?>

<header class="header">
  <div class="start">
    <div class="logo"><a href=".">Dawid Lachowicz</a></div>
    <label for="nav-toggle" class="mobile toggle">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="toggle-icon" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
      </svg>
    </label>
  </div>
  <input type="checkbox" name="nav-toggle" id="nav-toggle" class="hidden">
  <div class="links">
    <nav>
      <ul class="main-nav">
        <li><a href=".#about-me">About me</a></li>
        <li><a href="skills">Skills</a></li>
        <li><a href="education">Education</a></li>
        <li><a href="experience">Experience</a></li>
        <li><a href="portfolio">Portfolio</a></li>
        <li><a href="contact">Contact</a></li>
        <li><a href="blog">Blog</a></li>
      </ul>
    </nav>
    <div class="panel">
      <?php if ($logged_in): ?>
        <span><?= $user->getFirstName() ?></span>
        <?php // TODO change login-btn to btn ?>
        <a href="logout" class="login-btn">Log out</a>
      <?php else: ?>
        <a href="register" class="login-btn">Sign up</a>
        <a href="login" class="login-btn">Log in</a>
      <?php endif; ?>
    </div>
  </div>
</header>
