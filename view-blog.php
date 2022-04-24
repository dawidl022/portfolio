<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/Post.class.php';

  // TODO display author's name too

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

  date_default_timezone_set('UTC');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <title><?= $post->getTitle() ?>  | Dawid Lachowicz</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="sub-page">
    <section class="section blog single-post">
      <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
      <h1><?= $post->getTitle() ?></h1>

      <div class="container">
        <article class="post content" id="post2">
          <header>
            <div class="info">
              Posted on:
              <?php // TODO make sure times are saved to db in UTC ?>
              <time datetime="<?= date('c', $post->getTimeCreated()) ?>">
                <?= date('j', $post->getTimeCreated()) ?><sup><?= date('S', $post->getTimeCreated()) ?></sup>
                <?= date('F Y, H:i e', $post->getTimeCreated()) ?>
              </time>
            </div>
            <?php // TODO add edited on info ?>
          </header>

          <div class="body">
            <?= $post->getContent() ?>
          </div>
        </article>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
