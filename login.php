<?php
  require 'classes/Validation.class.php';
  require_once 'scripts/load-user.php';

  if (isset($_SESSION['id'])) {
    header("Location: /");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <title>Dawid Lachowicz - Log in</title>
</head>
<body>
  <?php
    require 'partials/_header.php';
  ?>

  <main class="login section sub-page">
    <img src="/assets/icons/circuit.svg" alt="" class="circuit-icon">
    <div class="container">

      <div class="form-wrapper">
        <form action="scripts/login.php" method="post" class="box-form">
          <h1>Log in</h1>

          <?php require_once 'partials/_form-error.php'; ?>

          <div class="field">
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" placeholder="Email"
              required
              <?= Validation::fillValue('email') ?>
            >
          </div>

          <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"
              placeholder="Password" required minlength="8">
          </div>

          <button type="submit" class="login-btn">Log in</button>
        </form>
      </div>

    </div>
  </main>
</body>
</html>
<?php
  unset($_SESSION['email']);
?>
