<?php
  require_once 'classes/Util.class.php';
  require_once 'classes/models/Post.class.php';

  class PostList {
    private const GET_ALL_SQL = "SELECT * FROM posts;";

    static function getAll(Database $db) : array {
      $raw_posts = $db->queryIndexed(self::GET_ALL_SQL, null);
      $posts = array();

      foreach ($raw_posts as $raw_post) {
        $raw_post[5] = strtotime($raw_post[5]);
        $raw_post[6] = strtotime($raw_post[6]);
        $posts[] = new Post($db, ...$raw_post);
      }

      return $posts;
    }

    static function getAllOrderedByMostRecent(Database $db) {
      $posts = self::getAll($db);
      Util::quickSort($posts, true, 'getTimeCreated');

      return $posts;
    }
  }
?>
