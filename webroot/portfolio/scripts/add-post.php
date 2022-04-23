<?php
  require_once 'db-connect-or-die.php';
  require_once '../classes/models/Author.class.php';
  require_once '../classes/models/Post.class.php';

  session_start();

  // TODO check if user is logged in and is an author
  $author = new Author($_SESSION['id'], $db);

  if (!$author->isAuthor()) {
    // TODO user cannot post
    header('Location: ../');
  }

  $post = Post::create($_POST['title'], $_POST['content'], $author, $db);
  if ($post->isValid()) {
    $post->save();
  } else {
    // TODO handle errors, save input and redirect back to form
  }
?>
