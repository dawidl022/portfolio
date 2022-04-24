<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/User.class.php';
  require_once 'classes/PostList.class.php';

  date_default_timezone_set('UTC');
  define('EXCERPT_LENGTH', 500);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <title>Dawid Lachowicz - Blog</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="sub-page">
    <section class="section blog blog-index">
      <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
      <h1>Blog</h1>

      <div class="container">
        <?php if ($logged_in && $user->isAuthor()): ?>
          <aside class="blog-aside">
            <h2><?= $user->getUserType() ?> Dashboard</h2>
            <div>
              <div><em>Your posts: 2</em></div>
              <?php if ($user->isAdmin()): ?>
                <div><em>Total number of posts: 2</em></div>
              <?php endif; ?>
            </div>
            <a href="add-post" class="login-btn read-btn add-btn">New post</a>
          </aside>
        <?php endif; ?>
        <div class="content">

          <?php foreach (PostList::getAllOrderedByMostRecent($db) as $post):
            $author = new User($post->getAuthorId(), $db);
          ?>

          <article class="post" id="post-<?= $post->getPermalink() ?>">
            <header>
              <h2>
                <a href="blog/<?= $post->getPermalink() ?>">
                  <?= $post->getTitle() ?>
                </a>
              </h2>

              <div class="info">
                Posted on:
                <?= Util::formatTime($post->getTimeCreated()) ?>
                by <?= $author->getName() ?>
              </div>
            </header>

            <div class="body">
              <?php $excerpt = preg_replace('/(<br>\n){3,}/' , "<br><br>\n",
                strip_tags($post->getContent(), ['<br>', '<a>'])) ?>
              <?= substr($excerpt, 0, EXCERPT_LENGTH) .
                  (strlen($excerpt) > EXCERPT_LENGTH ? '...' : '') ?>
            </div>
          </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
