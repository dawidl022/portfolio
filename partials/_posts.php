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
