<?php
  require_once 'classes/Validation.class.php';

  // TODO redirect is user already logged in
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php require 'partials/_head.php'; ?>

  <title>Dawid Lachowicz - Sign up</title>
</head>
<body>
  <?php require 'partials/_header.php'; ?>

  <main class="login section sub-page">
    <img src="assets/icons/circuit.svg" alt="" class="circuit-icon">
    <div class="container">

      <div class="form-wrapper">
        <form action="scripts/register.php" method="post" class="box-form">
          <h1>Sign up</h1>

          <?php require_once 'partials/_form-error.php'; ?>

          <div class="field">
            <label for="name">Full name</label>
            <input type="text" name="name" id="name" placeholder="Name"
              required <?= Validation::fillValue('name') ?>>
          </div>

          <div class="field">
            <label for="email">Email address</label>
            <input type="email" name="email" id="email" placeholder="Email"
              required <?= Validation::fillValue('email') ?>>
          </div>

          <div class="field">
            <label for="password">Password</label>
            <input type="password" name="password" id="password"
              placeholder="Password" required minlength="8"
              <?= Validation::fillValue('password') ?>
            >
          </div>

          <div class="field">
            <label for="password-repeat">Confirm password</label>
            <input type="password" name="password-repeat" id="password-repeat"
              placeholder="Password" required minlength="8"
              <?= Validation::fillValue('password-repeat') ?>
            >
          </div>

          <button type="submit" class="login-btn">Sign up</button>
        </form>
      </div>

    </div>
  </main>
</body>
</html>
