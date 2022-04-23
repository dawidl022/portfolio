<?php
  require_once 'show-errors.php';
  require_once '../classes/models/User.class.php';
  require_once '../classes/Validation.class.php';

  define('ALL_PARAMS', ['name', 'email', 'password', 'password-repeat']);

  function redirect_to_register() {
    header("Location: /register");
    exit();
  }

  function save_all_input_to_session() {
    Validation::savePostToSession(...ALL_PARAMS);
  }

  if ($_SERVER['REQUEST_METHOD'] !== 'POST'
  || !Validation::arePostSet(...ALL_PARAMS)) {
    redirect_to_register();
  }

  session_start();

  if (!Validation::arePostNonEmpty(...ALL_PARAMS)) {
    $_SESSION['error'] = 'Please fill in all fields';
    save_all_input_to_session();
    redirect_to_register();
  }

  require_once 'db-connect-or-die.php';

  if (User::isEmailTaken($_POST['email'], $db)) {
    $_SESSION['error'] = 'Email address is already taken';
    save_all_input_to_session();
    redirect_to_register();
  }

  if ($_POST['password'] !== $_POST['password-repeat']) {
    $_SESSION['error'] = 'Passwords do not match';
    Validation::savePostToSession('name', 'email', 'password');
    redirect_to_register();
  }

  try {
    $user = User::create($_POST['name'], $_POST['email'], $_POST['password'], $db);

    // TODO add link back through query param or referer to blog post
    $_SESSION['id'] = $user->getId();
    header("Location: /register-success");

  } catch (QueryFailedException $e) {
    $_SESSION['error'] = 'Server was unable to register your account';
    save_all_input_to_session();
    redirect_to_register();
  }
?>
