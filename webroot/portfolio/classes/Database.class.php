<?php
  require_once 'exceptions/QueryFailedException.php';

  class Database {
    private mysqli $conn;

    function __construct(mysqli $conn) {
      $this->conn = $conn;
    }

    function query(string $sql, string $param_types, ...$params) : array {
      $query = $this->execute(...func_get_args());
      return $query->get_result()->fetch_all(MYSQLI_BOTH);
    }

    function command(string $sql, string $param_types, ...$params) : void {
      $this->execute(...func_get_args());
    }

    function getConn() : mysqli {
      return $this->conn;
    }

    private function execute(string $sql, string $param_types, ...$params)
                             : mysqli_stmt {
      $query = $this->conn->prepare($sql);

      if (!$query) {
        throw new QueryFailedException();
      }

      $query->bind_param($param_types, ...$params);
      $success = $query->execute();

      if (!$success) {
        throw new QueryFailedException();
      }

      return $query;
    }
  }
?>
