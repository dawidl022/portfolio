<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/User.class.php';
  require_once 'classes/models/Author.class.php';
  require_once 'classes/PostList.class.php';
  require_once 'scripts/load-user.php';

  define('EXCERPT_LENGTH', 500);
  date_default_timezone_set('UTC');

  if (isset($_GET['month']) && $_GET['month'] !== 'any') {
    $all_posts = PostList::getByMonth($db, $_GET['month']);
  } else {
    $all_posts = PostList::getAllOrderedByMostRecent($db);
  }
?>
