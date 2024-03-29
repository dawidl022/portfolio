<?php
  require_once 'scripts/load-user.php';
?>

<div class="top-bar">
  <header class="header">
    <div class="start">
      <div class="logo"><a href="/">Dawid Lachowicz</a></div>
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
          <li><a href="/#about-me">About me</a></li>
          <li><a href="/skills">Skills</a></li>
          <li><a href="/education">Education</a></li>
          <li><a href="/experience">Experience</a></li>
          <li><a href="/portfolio">Portfolio</a></li>
          <li><a href="/contact">Contact</a></li>
        </ul>
      </nav>
      <div class="panel">
        <?php if ($logged_in): ?>
          <span><?= $user->getFirstName() ?></span>
          <a href="/logout" class="login-btn">Log out</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <?php if (isset($_SESSION['flash_message']) && isset($_SESSION['flash_type'])): ?>
    <aside class="flash <?= $_SESSION['flash_type'] ?>">
      <strong class="message">
      <?php
        switch ($_SESSION['flash_message']) {
          case 'welcome':
            echo "Welcome {$user->getName()}. You have successfully logged in.";
            break;
          case 'preview':
            echo 'You are in preview mode.';
            require_once 'partials/_post-preview-controls.php';
            break;
          case 'comment-error':
            echo 'An error occurred. We were unable to add your comment.';
            break;
        }
      ?>
      </strong>
      <?php if ($_SESSION['flash_message'] !== 'preview'): ?>
        <button type="button" aria-label="close message" id="close-flash"
          class="close-btn" title="Close message">X</button>
      <?php endif; ?>
    </aside>
  <?php
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
  endif;
  ?>
</div>
