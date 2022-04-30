<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/Comment.class.php';
  require_once 'classes/models/Post.class.php';
  require_once 'classes/models/User.class.php';
  require_once 'classes/Validation.class.php';

  function redirect_to_post($permalink) {
    header("Location: /blog/$permalink");
    exit();
  }

  function save_input_to_session() {
    Validation::savePostToSession('comment', 'in-reply-to');
  }

  if (!isset($_POST['post-id'])) {
    header('Location: /blog');
  }

  $post = Post::fromId($_POST['post-id'], $db);

  // TODO trim input from all other forms
  $_POST['comment'] = trim($_POST['comment']);

  if (!Validation::arePostSet('comment')) {
    redirect_to_post($post->getPermalink());
  }

  session_start();

  // allow user to continue where they left off after signing in
  if (!isset($_SESSION['id'])) {
    $_SESSION['error'] = 'Please log in to comment on a post';

    save_input_to_session();
    redirect_to_post($post->getPermalink());
  }

  $user = new User($_SESSION['id'], $db);

  $in_reply_to = null;

  if (isset($_POST['in-reply-to'])) {
    $in_reply_to = $_POST['in-reply-to'];
  }

  $comment = Comment::create($db, $_POST['post-id'], $user->getId(),
                      htmlspecialchars($_POST['comment'], ENT_QUOTES),
                      $in_reply_to);

  if (!$comment->isValid()) {
    $_SESSION['error'] = 'Comment cannot be blank';
    redirect_to_post($post->getPermalink());
  } else if (!$comment->isValidReply()) {
    $_SESSION['error'] = 'Cannot reply to selected comment';
    redirect_to_post($post->getPermalink());
  }

  try {
    $comment->save();
    unset($_SESSION['content']);
    unset($_SESSION['in-reply-to']);
  } catch (QueryFailedException $e) {
    $_SESSION['error'] = 'Server was unable to add your comment';
  }

  if (isset($_POST['async'])) {
    require_once 'partials/_comment.php';
  } else {
    redirect_to_post($post->getPermalink());
  }
?>
