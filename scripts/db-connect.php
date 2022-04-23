<?php
  require_once 'scripts/show-errors.php';
  require_once 'config/credentials.php';
  require_once 'classes/Database.class.php';

  function connect() : ?Database {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
      // caller is responsible for checking the returned value
      return null;
    }

    return new Database($conn);
  }

  $db = connect();
?>
