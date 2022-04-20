<?php
  class User {
    private int $id;
    private string $name;
    private bool $admin;
    private bool $author;
    private mysqli $conn;

    function __construct(int $id, string $name, bool $admin, bool $author,
                         mysqli $conn) {
      $this->id = $id;
      $this->name = $name;
      $this->admin = $admin;
      $this->author = $author;
      $this->conn = $conn;
    }

    function getName() {
      return $this->name;
    }

    function getId() {
      return $this->id;
    }

    function isAdmin() {
      return $this->admin;
    }

    function isAuthor() {
      return $this->author || $this->admin;
    }

    protected function getConn() {
      return $this->conn;
    }
  }
?>
