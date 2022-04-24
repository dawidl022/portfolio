<?php
  require_once 'classes/Util.class.php';

  class PostList {
    private const GET_ALL_SQL = "SELECT * FROM posts;";

    static function getAll(Database $db) : array {
      $raw_posts = $db->query(self::GET_ALL_SQL, '');
      $posts = array();

      foreach ($raw_posts as $raw_post) {
        $posts[] = new Post($db, ...$raw_post);
      }

      return $posts;
    }

    static function getAllOrderedByMostRecent(Database $db) {
      $posts = self::getAll($db);
      Util::quickSort($posts, 'getTimeCreated');

      return $posts;
    }
  }
?>
