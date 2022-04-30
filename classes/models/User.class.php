<?php
  class User {
    private int $id;
    private string $name;
    private bool $admin;
    private bool $author;
    private mysqli $conn;
    private Database $db;

    private const CREATE_SQL =
      "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?);";

    private const GET_SQL =
      "SELECT name, admin, author FROM users WHERE id = ?;";

    private const AUTHENTICATE_SQL =
      "SELECT id, password_hash FROM users WHERE email = ?;";

    private const EMAIL_SQL = 'SELECT id FROM users WHERE email = ?;';

    private const OWNS_COMMENT_SQL =
      'SELECT COUNT(*) AS owns FROM comments WHERE id = ? AND user_id = ?;';

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

    static function authenticate($email, $password, Database $db) : ?int {
      $result = $db->query(self::AUTHENTICATE_SQL, 's', $email);
      if (count($result) === 1) {
        $password_hash = $result[0]['password_hash'];

        if (password_verify($password, $password_hash)) {
          return $result[0]['id'];
        }
      }

      return null;
    }

    static function isEmailTaken($email, Database $db) : bool {
      $result = $db->query(self::EMAIL_SQL, 's', $email);
      return count($result) === 1;
    }

    function getName() : string {
      return $this->name;
    }

    function getFirstName() : string {
      return explode(" ", $this->name)[0];
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

    function getUserType() : string {
      return $this->isAdmin() ? 'Admin' : 'Author';
    }

    function ownsComment(int $commentId) : bool {
      return $this->db
        ->querySingle(self::OWNS_COMMENT_SQL, 'ii', $commentId, $this->id)
        ['owns'] === 1;
    }

    protected function getConn() {
      return $this->conn;
    }

    private function fetchData() {
      $user_data = $this->db->querySingle(self::GET_SQL, 'i', $this->id);

      $this->name = $user_data['name'];
      $this->admin = $user_data['admin'];
      $this->author = $user_data['author'];
    }
  }
?>
