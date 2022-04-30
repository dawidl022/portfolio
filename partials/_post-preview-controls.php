<a href="/add-post.php" class="login-btn">Back to editor</a>
<form action="/scripts/add-post.php" method="post">
  <input type="hidden" name="title" value="<?= $_POST['title'] ?>">
  <input type="hidden" name="content" value="<?= $_POST['content'] ?>">
  <button type="submit" class="login-btn submit-btn">Publish post</button>
</form>
