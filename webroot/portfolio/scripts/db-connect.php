<?php
  $env = getenv('ENVIRONMENT');

  if ($env === 'DEV') {
    define('ROOT', '/home/phenda10/Learning/uni/sem1B/web-dev/labs/production/webroot/portfolio/');
  } else if ($env = 'TEST') {
    define('ROOT', '/portfolio/');
  } else {
    define('ROOT', '/');
  }

  require_once 'show-errors.php';
  require_once ROOT . 'config/credentials.php';
  require_once ROOT . 'classes/Database.class.php';

  function connect() : Database {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      // TODO more user friendly error handling
    }

    return new Database($conn);
  }

  $db = connect();
?>
