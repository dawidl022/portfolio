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

    static function arePostNonEmpty(string ...$params) : bool {
      return self::areNonEmpty(...array_map(
        function($x) { return $_POST[$x]; }, $params
      ));
    }

    static function savePostToSession(string ...$params) : void {
      foreach ($params as $param) {
        $_SESSION[$param] = $_POST[$param];
      }
    }

    static function fillValue(string $name) {
      return isset($_SESSION[$name]) ? 'value="' . $_SESSION[$name] . '"' : '';
    }
  }
?>
