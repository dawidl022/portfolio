<?php
  if (!isset($_GET['month'])) {
    header('Location: /blog');
  }

  require_once 'scripts/blog-index-setup.php';
  require_once 'partials/_posts.php';
?>
