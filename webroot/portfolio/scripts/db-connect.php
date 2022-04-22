<?php
  require_once '../config/credentials.php';
  require_once '../classes/Database.class.php';

  function connect() : Database {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      // TODO more user friendly error handling
    }

    return new Database($conn);
  }
?>
