<?php
  require_once 'show-errors.php';
  require_once '../classes/models/User.class.php';

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../login");
  }
  // TODO handle missing values
  // TODO check if email address is already taken
  // TODO check that passwords match

  require_once 'db-connect-or-die.php';

  $id = User::authenticate($_POST['email'], $_POST['password'], $db);
  // TODO add link back to session variable and to blog index
  // TODO only redirect to success if creation succeeded
  if ($id !== null) {
    session_start();
    $_SESSION['id'] = $id;
  } else {
    // TODO set error message and redirect back to login with entered values saved
  }
  header("Location: ../");
?>
