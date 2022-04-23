<?php
  class Permalink {
    private const UNIQUE_SQL = 'SELECT * FROM %s WHERE permalink = ?;';

    static function toPermalink(string $text) : string {
      $text = strtolower(trim($text));
      $text = preg_replace('/\s+/', '-', $text);
      $text = preg_replace('/[^a-z0-9-]/', '', $text);
      $text = urlencode($text);

      return $text;
    }

    static function uniqueIn(string $text, Database $db, string $table_name)
                            : string {
      $permalink = self::toPermalink($text);
      $suffix = '';
      $index = 1;

      while(self::isTakenIn($permalink . $suffix, $db, $table_name)) {
        $suffix = '-' . ++$index;
      }

      return $permalink . $suffix;
    }

    static function isTakenIn(string $permalink, Database $db,
                              string $table_name): bool {
      return count($db->query(
        sprintf(self::UNIQUE_SQL, $table_name), 's', $permalink)) > 0;
    }
  }
?>
