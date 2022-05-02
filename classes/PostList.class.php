<?php
  require_once 'classes/Util.class.php';
  require_once 'classes/models/Post.class.php';

  class PostList {
    private const GET_ALL_SQL = "SELECT * FROM posts;";
    private const GET_BY_MONTH_SQL =
      "SELECT * FROM posts WHERE UNIX_TIMESTAMP(date_created) >= ? AND UNIX_TIMESTAMP(date_created) < ?";

    private const GET_N_MOST_RECENT_SQL =
      "SELECT * FROM posts ORDER BY date_created DESC LIMIT ?;";

    private const GET_MONTHS_SQL =
      "SELECT DISTINCT CONCAT(YEAR(date_created), '-', " .
      "RIGHT(CONCAT('0', MONTH(date_created)), 2)) AS month_stamp FROM posts " .
      "ORDER BY month_stamp DESC;";

    private const GET_POST_COUNT =
      "SELECT COUNT(*) AS post_count FROM posts;";

    static function getAll(Database $db) : array {
      $raw_posts = $db->queryIndexed(self::GET_ALL_SQL, null);
      return self::rawPostsToObjects($db, $raw_posts);
    }

    static function getByMonth(Database $db, string $yyyy_mm) : array {
      date_default_timezone_set('UTC');

      $first = new DateTime($yyyy_mm . '-01');
      $aMonth = DateInterval::createFromDateString('1 month');
      $last = $first->add($aMonth);

      $first = new DateTime($yyyy_mm . '-01');


      $raw_posts = $db->queryIndexed(self::GET_BY_MONTH_SQL, 'ii',
        $first->getTimestamp(), $last->getTimestamp());

      $posts = self::rawPostsToObjects($db, $raw_posts);

      Util::quickSort($posts, true, 'getTimeCreated');

      return $posts;
    }

    static function getMonths(Database $db) : array {
      $months = array();
      $raw_months = $db->query(self::GET_MONTHS_SQL, null);

      foreach ($raw_months as $raw_month) {
        $months[] = $raw_month['month_stamp'];
      }

      return $months;
    }

    static function getAllOrderedByMostRecent(Database $db) : array {
      $posts = self::getAll($db);
      Util::quickSort($posts, true, 'getTimeCreated');

      return $posts;
    }

    static function getNMostRecent(Database $db, int $n) {
      $raw_posts = $db->queryIndexed(self::GET_N_MOST_RECENT_SQL, 'i', $n);
      return self::rawPostsToObjects($db, $raw_posts);
    }

    static function getPostCount(Database $db) : int {
      return $db->querySingle(self::GET_POST_COUNT, null)['post_count'];
    }

    private static function rawPostsToObjects(Database $db, array $raw_posts) : array {
      $posts = array();

      foreach ($raw_posts as $raw_post) {
        $raw_post[5] = strtotime($raw_post[5]);
        $raw_post[6] = strtotime($raw_post[6]);
        $posts[] = new Post($db, ...$raw_post);
      }

      return $posts;
    }
  }
?>
