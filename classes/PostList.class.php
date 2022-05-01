<?php
  require_once 'classes/Util.class.php';
  require_once 'classes/models/Post.class.php';

  class PostList {
    private const GET_ALL_SQL = "SELECT * FROM posts;";
    private const GET_BY_MONTH_SQL =
      "SELECT * FROM posts WHERE date_created >= ? AND date_created < ?";

    private const GET_MONTHS_SQL =
      "SELECT DISTINCT CONCAT(YEAR(date_created), '-', " .
      "RIGHT(CONCAT('0', MONTH(date_created)), 2)) AS month_stamp FROM posts " .
      "ORDER BY month_stamp DESC;";


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

    static function getByMonth(Database $db, string $mm_yyyy) : array {
      date_default_timezone_set('UTC');

      $first = DateTime::createFromFormat('Y-m-d', $mm_yyyy . '-01');
      $aMonth = DateInterval::createFromDateString('1 month');
      $last = $first->add($aMonth);

      $posts = $db->queryIndexed(self::GET_BY_MONTH_SQL, 'ii',
        $first->getTimestamp(), $last->getTimestamp());

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
  }
?>
