<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'scripts/load-user.php';
  require_once 'classes/models/Post.class.php';
  require_once 'classes/models/User.class.php';
  require_once 'classes/Util.class.php';

  date_default_timezone_set('UTC');

  if (isset($_POST['title']) && isset($_POST['content'])) {
    // PREVIEW LOGIC
    $preview = true;
    $_SESSION['title'] = $_POST['title'];
    $_SESSION['content'] = $_POST['content'];

    if ($logged_in) {
      $author = $user;
      $current_time = time();
      $post = new Post($db, null, $user->getId(), $_POST['title'], null,
                       $_POST['content'], $current_time, $current_time);

      $_SESSION['flash_type'] = 'info';
      $_SESSION['flash_message'] = 'preview';
    } else {
      $_SESSION['redirect_to'] = 'add-post';
      $_SESSION['error'] = 'Please log in to add and preview a post';
      header("Location: /login");
      exit();
    }

  } else {
      // NORMAL VIEW LOGIC
      $preview = false;

      if (!isset($_GET['permalink'])) {
        header("Location: /blog");
        exit();
      }

      try {
        $post = Post::fromPermalink($_GET['permalink'], $db);
      } catch (RecordNotFoundException $e) {
        header("Location: /blog");
        exit();
      }

      if ($post->getAuthorId() !== null) {
        $author = new User($post->getAuthorId(), $db);
      } else {
        $author = null;
      }

  }

  $comments = $post->getComments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <script src="/scripts/js/vote.js" defer></script>
  <script src="/scripts/js/comments.js" defer></script>
  <title><?= $post->getTitle() ?>  | Dawid Lachowicz</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="sub-page">
    <section class="section blog single-post">
      <div>
        <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
        <h1><?= $post->getTitle() ?></h1>
        <?php if (!$preview): ?>
          <a href="/blog" class="login-btn read-btn">Back to all posts</a>
        <?php endif; ?>
      </div>

      <div class="container">
        <article class="post content">
          <header class="post-head">

            <div class="info">
              Posted on:
              <?= Util::formatTime($post->getTimeCreated()) ?>
              by <?= $author !== null ? $author->getName() : '(deleted user)' ?>
            </div>

            <?php if ($post->getTimeModified() !== $post->getTimeCreated()): ?>
              <div class="info">
                Updated on:
                <?= Util::formatTime($post->getTimeModified()) ?>
              </div>
            <?php endif ?>
          </header>

          <div class="body">
            <?= $post->getContent() ?>
          </div>

          <footer class="post-footer">
            <noscript>
              Please enable JavaScript to vote on this post
            </noscript>

            <div class="footer-icons">
              <form id="vote-form">
                <input type="hidden" name="post-id" value="<?= $post->getId() ?>">
                <button disabled type="submit" class='vote-btn heart-btn'>
                  <span class="heart circle"></span>
                  <span class="sr-only">Vote up. Current number of votes:</span>
                  <span class="counter"><?= $post->getNumberOfVotes() ?></span>
                </button>
              </form>

              <a class="comment-count vote-btn" href="#comments">
                <span class="comment-icon circle"></span>
                <span class="sr-only">Number of comments:</span>
                <div class="counter"><?= $post->getCommentCount() ?></div>
              </a>
            </div>
          </footer>
        </article>
        <section class="comments content" id="comments">
          <h2>Comments</h2>

          <?php if (!$preview && $logged_in): ?>
            <form action="/scripts/add-comment.php" method="post" id="comment-form"
              class="comment-form">
              <input type="hidden" name="post-id" value="<?= $post->getId() ?>">

              <div class="field">
                <strong class="error <?= isset($_SESSION['error']) ? 'visible' : '' ?>">
                  <?= isset($_SESSION['error']) ? $_SESSION['error'] : '' ?>
                </strong>
                <label for="comment">Your comment:</label>
                <textarea name="comment" id="comment" rows="3" required
                  placeholder="What you think about this post..."></textarea>
              </div>

              <button type="submit" class="login-btn read-btn">Add comment</button>
            </form>
          <?php endif; ?>

          <?php
            if (count($comments) == 0):
              echo '<em id="no-comments">No comments to display</em>';
            else:
          ?>
              <ol id="comment-list">
                <?php foreach ($comments as $comment):
                  echo '<li>';
                  require 'partials/_comment.php';
                  echo '</li>';
                endforeach; ?>
              </ol>
          <?php endif; ?>
        </section>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>

<?php
  unset($_SESSION['error']);
?>
