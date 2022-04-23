<?php
  require_once 'db-connect.php';

  if ($db === null) {
    header('Location: /server-error');
    die();
  }
?>
