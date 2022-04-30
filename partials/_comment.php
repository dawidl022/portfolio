<div class="comment">
  <div class="info-bar">
    <span class="name"><?= $comment->getAuthorName() ?></span>
    <span class="info">commented on <?= Util::formatTime($comment->getTimeCreated()) ?></span>
  </div>
  <div class="comment-content">
    <?= $comment->getContent() ?>
  </div>
</div>
