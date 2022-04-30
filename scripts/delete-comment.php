<?php
  // Verify that user is allowed to delete comment and delete it.
  if (!isset($_POST['comment-id'])) {
    header('Location /blog');
  }

  require_once 'scripts/load-user.php';
  require_once 'classes/models/Comment.class.php';

  if ($user->isAdmin() || $user->ownsComment($_POST['comment-id'])) {
    Comment::delete($db, $_POST['comment-id']);
  }

  if (isset($_POST['async'])) {
    http_response_code(204);
    exit();
  }

  if ($_SERVER["HTTP_REFERER"]) {
    $redirect_to = $_SERVER["HTTP_REFERER"];
  } else {
    $redirect_to = "/blog";
  }

  header("Location: $redirect_to")
?>
