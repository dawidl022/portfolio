<?php
  require_once 'classes/models/User.class.php';
  require_once 'classes/models/Post.class.php';

  class Author extends User {
    private const GET_POSTS_SQL = "SELECT * FROM posts WHERE author_id = ?;";
    private const GET_POST_COUNT_SQL =
      "SELECT COUNT(*) AS post_count FROM posts WHERE author_id = ?;";

    /**
     * @return array of User objects
     */
    function getPosts() : array {
      $raw_posts = $this->getDb()->query(self::GET_POSTS_SQL, 'i', $this->getId());

      $posts = array();
      foreach ($raw_posts as $raw_post) {
        $posts[] = new Post(...$raw_post);
      }

      return $posts;
    }

    function getPostCount() : int {
      return $this->getDb()
        ->querySingle(self::GET_POST_COUNT_SQL, 'i', $this->getId())
        ['post_count'];
    }
  }
?>
