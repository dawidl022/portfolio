<?php
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

    // TODO add error checking and raise exceptions appropriately
    private function execute(string $sql, string $param_types, ...$params)
                             : mysqli_stmt {
      $query = $this->conn->prepare($sql);
      $query->bind_param($param_types, ...$params);
      $query->execute();

      return $query;
    }
  }
?>
