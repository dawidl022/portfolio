<?php if (count($all_posts) === 0):
  echo '<em>No posts to display</em>';
endif;

foreach ($all_posts as $post):
  if ($post->getAuthorId() !== null) {
    $author = new User($post->getAuthorId(), $db);
  } else {
    $author = null;
  }
?>

<article class="post" id="post-<?= $post->getPermalink() ?>">
  <header>
    <h2>
      <a href="/blog/<?= $post->getPermalink() ?>">
        <?= $post->getTitle() ?>
      </a>
    </h2>

    <div class="info">
      Posted on:
      <?= Util::formatTime($post->getTimeCreated()) ?>
      by <?= $author !== null ? $author->getName() : '(deleted user)' ?>

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
    <?= Util::makeExcerpt($post->getContent(), EXCERPT_LENGTH)  ?>
  </div>
</article>
<?php endforeach; ?>
