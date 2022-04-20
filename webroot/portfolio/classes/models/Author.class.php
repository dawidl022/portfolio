<?php
  require_once 'User.class.php';
  require_once 'Post.class.php';

  class Author extends User {
    private const GET_POSTS_SQL = "SELECT * FROM posts WHERE author_id = ?;";

    function createPost(Post $post) {
      $post->setAuthor($this);
      $post->save();
    }

    /**
     * @return array of User objects
     */
    function getPosts() : array {
      $conn = parent::getConn();

      $query = $conn->prepare(self::GET_POSTS_SQL);
      $query->bind_param('i', parent::getId());
      $query->execute();

      $raw_posts =  $query->get_result()->fetch_all();

      $posts = array();
      foreach ($raw_posts as $raw_post) {
        $posts[] = new Post(...$raw_post);
      }

      return $posts;
    }
  }
?>
