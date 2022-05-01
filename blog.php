<?php
  require_once 'scripts/blog-index-setup.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <script src="/scripts/js/posts.js" defer></script>
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
              <?php $author = new Author($_SESSION['id'], $db); ?>
              <div><em>Your posts: <?= $author->getPostCount() ?></em></div>
              <?php if ($user->isAdmin()): ?>
                <div><em>Total number of posts: <?= PostList::getPostCount($db) ?></em></div>
              <?php endif; ?>
            </div>
            <a href="add-post" class="login-btn read-btn add-btn">New post</a>
          </aside>
        <?php endif; ?>
        <div class="content">
          <?php require_once 'partials/_blog-filters.php'; ?>

          <div class="posts">
            <?php require_once 'partials/_posts.php'; ?>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
