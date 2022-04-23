<?php
  session_start();
  session_destroy();

  if ($_SERVER["HTTP_REFERER"]) {
    $redirect_to = $_SERVER["HTTP_REFERER"];
  } else {
    $redirect_to = "."; // redirect to index in current folder
  }

  header("Location: $redirect_to")
?>
