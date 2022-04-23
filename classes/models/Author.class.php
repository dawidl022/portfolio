<?php
  require_once 'classes/models/User.class.php';
  require_once 'classes/models/Post.class.php';

  class Author extends User {
    private const GET_POSTS_SQL = "SELECT * FROM posts WHERE author_id = ?;";

    /**
     * @return array of User objects
     */
    function getPosts() : array {
      $conn = parent::getConn();

      $query = $conn->prepare(self::GET_POSTS_SQL);
      $query->bind_param('i', parent::getId());
      $query->execute();

      $raw_posts =  $query->get_result()->fetch_all(MYSQLI_BOTH);

      $posts = array();
      foreach ($raw_posts as $raw_post) {
        $posts[] = new Post(...$raw_post);
      }

      return $posts;
    }
  }
?>
