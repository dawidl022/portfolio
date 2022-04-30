<div class="comment">
  <div class="info-bar">
    <span class="name"><?= $comment->getAuthorName() ?></span>
    <span class="info">commented on <?= Util::formatTime($comment->getTimeCreated()) ?></span>

    <?php if ($logged_in && ($comment->getAuthorId() == $user->getId() || $user->isAdmin())): ?>
      <form action="/scripts/delete-comment.php" method="post"
        class="delete-comment">
        <input type="hidden" name="comment-id" value="<?= $comment->getId() ?>">
        <button type="submit" class="login-btn clear-btn">Delete</button>
      </form>
    <?php endif; ?>
  </div>
  <div class="comment-content">
    <?= $comment->getContent() ?>
  </div>
</div>
