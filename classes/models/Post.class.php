<?php
  require_once 'classes/exceptions/NotValidException.php';
  require_once 'classes/models/Statement.class.php';
  require_once 'classes/models/Comment.class.php';
  require_once 'classes/Permalink.class.php';

  class Post extends Statement {
    private ?string $title;
    private ?int $numberOfVotes;
    private ?string $permalink;

    private const INSERT_NEW_SQL =
      "INSERT INTO posts (author_id, title, content, permalink) VALUES(?, ?, ?, ?);";

    private const DELETE_SQL =
      "DELETE FROM posts WHERE id = ?;";

    private const GET_SQL =
      "SELECT * FROM posts WHERE id = ?;";

    private const GET_ID_SQL =
      "SELECT id FROM posts WHERE permalink = ?;";

    private const GET_COMMENTS_SQL =
      "SELECT * FROM comments WHERE post_id = ?;";

    private const LOCK_SQL = "LOCK TABLES posts WRITE;";
    private const GET_VOTES = "SELECT votes FROM posts WHERE id = ?;";
    private const SET_VOTES = "UPDATE posts SET votes = ? WHERE id = ?;";
    private const UNLOCK_SQL = "UNLOCK TABLES;";

    function __construct(Database $db, ?int $id = null, ?int $authorId = null,
                         ?string $title = null, ?string $permalink = null,
                         ?string $content = null, ?int $timeCreated = null,
                         ?int $timeModified = null, ?int $numberOfVotes = 0) {
      parent::__construct($db, $content, $id, $authorId, $timeCreated, $timeModified);
      $this->title = $title;
      $this->numberOfVotes = $numberOfVotes;
      $this->permalink = $permalink;
    }

    static function create($title, $content, Author $author, Database $db) : self {
      return new self($db, null, $author->getId(), $title, null, $content);
    }

    static function fromId($id, $db) {
      $post = new self($db, $id);
      $post->fetchData();

      return $post;
    }

    static function fromPermalink(string $permalink, $db) : self {
      $post = new self($db);
      $post->permalink = $permalink;

      $post->setId($db->querySingle(self::GET_ID_SQL, 's', $permalink)['id']);
      $post->fetchData();
      return $post;
    }

    static function upvote(Database $db, int $id) : void {
      $db->getConn()->begin_transaction();

      try {
        while (!$db->getConn()->query(self::LOCK_SQL));

        $voteCount = $db->querySingle(self::GET_VOTES, 's', $id)['votes'];
        $db->command(self::SET_VOTES, 'ii', $voteCount + 1, $id);

        $db->getConn()->query(self::UNLOCK_SQL);

        $db->getConn()->commit();
      } catch (mysqli_sql_exception | RecordNotFoundException $exception) {
        $db->getConn()->rollback();
        throw $exception;
      }
    }

    function save() : void {
      if (!$this->isValid()) {
        throw new NotValidException(
          "Title and content must be non-empty before saving to database");
      }

      if ($this->getId() === null) {
        $this->insert();
      } else {
        $this->update();
      }
      $this->fetchData();
    }

    function delete() : void {
      $this->getDb()->command(self::DELETE_SQL, 'i', $this->getId());
    }

    function isValid(): bool {
      return $this->title !== null && strlen($this->title) > 0
        && $this->getContent() !== null && strlen($this->getContent()) > 0;
    }

    function getPermalink() : string {
      return $this->permalink;
    }

    function getTitle() : string {
      return $this->title;
    }

    function getNumberOfVotes() : int {
      return $this->numberOfVotes;
    }

    function getComments() : array {
      $raw_comments =
        $this->getDb()->query(self::GET_COMMENTS_SQL, 'i', $this->getId());

      $comments = array();

      foreach ($raw_comments as $raw) {
        $comment = new Comment($this->getDb(), $raw['content'], $raw['id'],
                   $raw['user_id'], strtotime($raw['date_created']), strtotime($raw['date_modified']));

        if ($raw['in_reply_to'] == null) {
          $comments[$raw['id']] = $comment;
        } else {
          $comment[$raw['in_reply_to']]->addReply($comment);
        }
      }

      return $comments;
    }

    private function insert() : void {
      $db = $this->getDb();
      $this->permalink = Permalink::uniqueIn($this->title, $this->getDb(), 'posts');

      $db->command(
        self::INSERT_NEW_SQL, 'isss', $this->getAuthorId(), $this->title,
        $this->getContent(),$this->permalink
      );

      $this->setId($db->getConn()->insert_id);
    }

    private function update() : void {

    }

    private function fetchData() {
      $post_data = $this->getDb()->querySingle(self::GET_SQL, 'i', $this->getId());

      $this->title = $post_data['title'];
      $this->numberOfVotes = $post_data['votes'];
      $this->setAuthorId($post_data['author_id']);
      $this->setContent($post_data['content']);
      $this->setTimeCreated(strtotime($post_data['date_created']));
      $this->setTimeModified(strtotime($post_data['date_modified']));
    }
  }
?>
