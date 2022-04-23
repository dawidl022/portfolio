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
    <section class="section blog">
      <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
      <h1><?= $post->getTitle() ?></h1>

      <div class="container">
          <article class="post" id="post2">
            <header>
              <div class="info">
                Posted on:
                <time datetime="2022-03-16">3<sup>rd</sup> March 2022, 11:12 UTC</time>
              </div>
              <?php // TODO add edited on info ?>
            </header>

            <div class="body">
              <?= $post->getContent() ?>
            </div>
          </article>
        </div>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
