<?php
  if (!isset($_POST['id'])) {
    exit();
  }

  require_once 'scripts/db-connect.php';
  require_once 'classes/models/Post.class.php';

  try {
    Post::upvote($db, $_POST['id']);
    http_response_code(204);
  } catch (RecordNotFoundException $e) {
    http_response_code(400);
  } catch (Exception $e) {
    http_response_code(500);
  }
?>
