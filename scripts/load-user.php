<?php
  $logged_in = false;
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (isset($_SESSION['id'])) {
    require_once 'scripts/db-connect.php';
    require_once 'classes/models/User.class.php';

    if ($db !== null) {
      try {
        $user = new User($_SESSION['id'], $db);
        $logged_in = true;
      } catch (RecordNotFoundException $e) {
        // no need to keep the user id in the session if it is invalid
        unset($_SESSION['id']);
      }
    }
  }
?>
