<?php
  class Validation {

    static function arePostSet(string ...$params) : bool {
      foreach ($params as $param) {
        if (!isset($_POST[$param])) {
          return false;
        }
      }

      return true;
    }

    static function filterEmpty(string ...$params) : array {
      $empty = array();

      foreach ($params as $param) {
        if (strlen($param) === 0) {
          $empty[] = $param;
        }
      }

      return $empty;
    }

    static function areNonEmpty(string ...$params) : bool {
      return count(self::filterEmpty(...$params)) === 0;
    }
  }
?>
