<?php
  // Verify that user is allowed to delete post and delete it.
  if (!isset($_POST['post-id'])) {
    header('Location /blog');
  }

  require_once 'scripts/load-user.php';
  require_once 'classes/models/Post.class.php';

  if ($user->isAdmin()) {
    Post::delete($db, $_POST['post-id']);

    if (isset($_POST['async'])) {
      http_response_code(204);
      exit();
    }
  }

  header("Location: /blog");
?>
