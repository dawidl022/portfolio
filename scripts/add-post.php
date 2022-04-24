<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/Author.class.php';
  require_once 'classes/models/Post.class.php';
  require_once 'classes/Validation.class.php';

  define('ALL_PARAMS', ['title', 'content']);

  function redirect_to_add_post() {
    header("Location: /add-post");
    exit();
  }

  // TODO extract duplication
  function save_all_input_to_session() {
    Validation::savePostToSession(...ALL_PARAMS);
  }

  function convertNewlineToBr(string $text) : string {
    return preg_replace('/\R/', "<br>\n", $text);
  }

  if ($_SERVER['REQUEST_METHOD'] !== 'POST'
  || !Validation::arePostSet(...ALL_PARAMS)) {
    redirect_to_add_post();
  }

  session_start();

  // allow user to continue where they left off after signing in
  if (!isset($_SESSION['id'])) {
    $_SESSION['redirect_to'] = 'add-post';
    $_SESSION['error'] = 'Please log in to add a post';

    save_all_input_to_session();
    header("Location: /login");
  }

  $author = new Author($_SESSION['id'], $db);

  if (!$author->isAuthor()) {
    header('Location: /');
  }

  $post = Post::create($_POST['title'], convertNewlineToBr($_POST['content']),
                       $author, $db);
  if ($post->isValid()) {
    try {
      $post->save();
      // TODO add flash message
      unset($_SESSION['title']);
      unset($_SESSION['content']);
      header("Location: /blog/{$post->getPermalink()}");
      exit();
    } catch (QueryFailedException $e) {
      $_SESSION['error'] = 'Server was unable to add your post';
    }
  } else {
    $_SESSION['error'] = 'Please fill in all fields';
  }

  save_all_input_to_session();
  redirect_to_add_post();
?>
