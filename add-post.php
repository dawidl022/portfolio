<?php
  require_once 'classes/Validation.class.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <title>Dawid Lachowicz - Add a blog post</title>
</head>
<body>
  <?php
    require 'partials/_header.php';

    if (!isset($_SESSION['id'])) {
      $_SESSION['redirect_to'] = 'add-post';
      $_SESSION['error'] = 'Please log in to add a post';
      header("Location: /login");
    }

    if (!$user->isAuthor()) {
      header("Location: /");
    }
  ?>

  <main class="add-post section sub-page">
    <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
    <div class="container">

      <div class="form-wrapper">
        <form action="scripts/add-post.php" method="post" class="box-form">
          <h1>Add blog post</h1>

          <?php require_once 'partials/_form-error.php'; ?>

          <div class="field">
            <label for="title">Title</label>
            <input type="title" name="title" id="title" placeholder="Title"
              required <?= Validation::fillValue('title') ?>>
          </div>

          <div class="field big-field">
            <label for="content">Content</label>
            <textarea name="content" id="content"
              placeholder="Your thoughts..." required
              rows="5"><?= Validation::fillRaw('content') ?></textarea>
          </div>

          <div class="buttons">
            <button type="submit" class="login-btn">Add post</button>
            <button type="reset" class="login-btn clear-btn">Clear</button>
          </div>
        </form>
      </div>

    </div>
  </main>
</body>
</html>
