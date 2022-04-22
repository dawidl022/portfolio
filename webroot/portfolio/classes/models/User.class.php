<?php
  class User {
    private int $id;
    private string $name;
    private bool $admin;
    private bool $author;
    private mysqli $conn;

    private const CREATE_SQL =
      "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?);";
    private const GET_SQL =
      "SELECT name, admin, author FROM users WHERE id = ?;";
    private const AUTHENTICATE_SQL =
      "SELECT id, password_hash FROM users WHERE email = ?;";

    function __construct(int $id, Database $db) {
      $this->id = $id;
      $this->db = $db;
      $this->fetchData();
    }

    static function create($name, $email, $password, Database $db) : self {
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $db->command(self::CREATE_SQL, "sss", $name, $email, $password_hash);

      return new self($db->getConn()->insert_id, $db);
    }

    static function authenticate($email, $password) : ?int {
      return null;
    }

    function getName() : string {
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

    private function fetchData() {
      $this->name = "";
      $this->admin = "";
      $this->author = "";
    }
  }
?>
