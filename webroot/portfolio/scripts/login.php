<?php
  require_once 'show-errors.php';
  require_once '../classes/models/User.class.php';
  require_once '../classes/Validation.class.php';

  function redirect_to_login() {
    header("Location: ../login");
    exit();
  }

  if ($_SERVER['REQUEST_METHOD'] !== 'POST'
  || !Validation::arePostSet('email', 'password')) {
    redirect_to_login();
  }

  session_start();

  if (!Validation::areNonEmpty($_POST['email'], $_POST['password'])) {
    $_SESSION['error'] = 'Please enter your email and password';
    redirect_to_login();
  }

  require_once 'db-connect-or-die.php';

  $id = User::authenticate($_POST['email'], $_POST['password'], $db);

  if ($id !== null) {
    $_SESSION['id'] = $id;

    header("Location: ../");
  } else {
    $_SESSION['error'] = 'Invalid email address or password';
    $_SESSION['email'] = $_POST['email'];

    header("Location: ../login");
  }
?>
