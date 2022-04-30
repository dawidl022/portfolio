<div class="comment">
  <div class="info-bar">
    <span class="name"><?= $comment->getAuthorName() ?></span>
    <span class="info">commented on <?= Util::formatTime($comment->getTimeCreated()) ?></span>
    <button type="button" class="login-btn clear-btn">Delete</button>
  </div>
  <div class="comment-content">
    <?= $comment->getContent() ?>
  </div>
</div>
