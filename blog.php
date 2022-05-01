<?php
  require_once 'scripts/db-connect-or-die.php';
  require_once 'classes/models/User.class.php';
  require_once 'classes/models/Author.class.php';
  require_once 'classes/PostList.class.php';

  define('EXCERPT_LENGTH', 500);
  date_default_timezone_set('UTC');

  if (isset($_GET['month']) && $_GET['month'] !== 'any') {
    $all_posts = PostList::getByMonth($db, $_GET['month']);
  } else {
    $all_posts = PostList::getAllOrderedByMostRecent($db);
  }
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
            <?php if (count($all_posts) === 0):
              echo '<em>No posts to display</em>';
            endif;

            foreach ($all_posts as $post):
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

                  <?php if ($logged_in && $user->isAdmin()): ?>
                    <form action="/scripts/delete-post.php" method="post"
                      class="delete-post">
                      <input type="hidden" name="post-id" value="<?= $post->getId() ?>">
                      <button type="submit" class="login-btn clear-btn">Delete</button>
                    </form>
                  <?php endif; ?>
                </div>
              </header>

              <div class="body">
                <?php $excerpt = preg_replace('/(<br>\n){3,}/' , "<br><br>\n",
                  strip_tags($post->getContent(), ['<br>', '<a>', '<strong>', '<em>'])) ?>
                <?= substr($excerpt, 0, EXCERPT_LENGTH) .
                    (strlen($excerpt) > EXCERPT_LENGTH ? '...' : '') ?>
              </div>
            </article>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php require 'partials/_footer.html'; ?>
</body>
</html>
