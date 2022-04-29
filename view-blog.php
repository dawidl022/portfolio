<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/Post.class.php';
  require_once 'classes/models/User.class.php';
  require_once 'classes/Util.class.php';

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

  $author = new User($post->getAuthorId(), $db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <script src="/scripts/js/vote.js" defer></script>
  <title><?= $post->getTitle() ?>  | Dawid Lachowicz</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="sub-page">
    <section class="section blog single-post">
      <div>
        <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
        <h1><?= $post->getTitle() ?></h1>
        <a href="/blog" class="login-btn">Back to all posts</a>
      </div>

      <div class="container">
        <article class="post content">
          <header class="post-head">

            <div class="info">
              Posted on:
              <?= Util::formatTime($post->getTimeCreated()) ?>
              by <?= $author->getName() ?>
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

          <footer>
            <noscript>
              Please enable JavaScript to vote on this post
            </noscript>

            <form id="vote-form">
              <input type="hidden" name="post-id" value="<?= $post->getId() ?>">
              <button disabled type="submit" class='vote-btn'>
                <span class="heart"></span>
                <span class="sr-only">Vote up. Current number of votes:</span>
                <span class="counter"><?= $post->getNumberOfVotes() ?></span>
              </button>
            </form>
          </footer>
        </article>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
