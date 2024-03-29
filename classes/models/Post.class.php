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
    private const INSERT_NEW_VOTES_SQL = "INSERT INTO votes (post_id) VALUES(?);";

    private const DELETE_SQL =
      "DELETE FROM posts WHERE id = ?;";

    private const GET_SQL =
      "SELECT * FROM posts INNER JOIN votes ON votes.post_id = posts.id WHERE id = ?;";

    private const GET_ID_SQL =
      "SELECT id FROM posts WHERE permalink = ?;";

    private const GET_COMMENTS_SQL =
      "SELECT * FROM comments WHERE post_id = ?;";

    private const GET_COMMENT_COUNT_SQL =
      "SELECT COUNT(*) AS comment_count FROM comments WHERE post_id = ?;";

    private const LOCK_SQL = "LOCK TABLES votes WRITE;";
    private const GET_VOTES = "SELECT vote_count FROM votes WHERE post_id = ?;";
    private const SET_VOTES = "UPDATE votes SET vote_count = ? WHERE post_id = ?;";
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

        $voteCount = $db->querySingle(self::GET_VOTES, 'i', $id)['vote_count'];
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

    static function delete(Database $db, int $id) : void {
      $db->command(self::DELETE_SQL, 'i', $id);
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
                   $raw['user_id'], $raw['post_id'], $raw['in_reply_to'],
                   strtotime($raw['date_created']), strtotime($raw['date_modified']));

        if ($raw['in_reply_to'] == null) {
          $comments[$raw['id']] = $comment;
        } else {
          $comment[$raw['in_reply_to']]->addReply($comment);
        }
      }

      return $comments;
    }

    function getCommentCount() : int {
      return $this->getDb()
        ->querySingle(self::GET_COMMENT_COUNT_SQL, 'i', $this->getId())
        ['comment_count'];
    }

    private function insert() : void {
      $db = $this->getDb();
      $this->permalink = Permalink::uniqueIn($this->title, $this->getDb(), 'posts');


      $db->command(
        self::INSERT_NEW_SQL, 'isss', $this->getAuthorId(), $this->title,
        $this->getContent(),$this->permalink
      );

      $id = $db->getConn()->insert_id;
      $this->setId($id);
      $db->command(self::INSERT_NEW_VOTES_SQL, 'i', $id);
    }

    private function update() : void {

    }

    private function fetchData() {
      $post_data = $this->getDb()->querySingle(self::GET_SQL, 'i', $this->getId());

      $this->title = $post_data['title'];
      $this->numberOfVotes = $post_data['vote_count'];
      $this->setAuthorId($post_data['author_id']);
      $this->setContent($post_data['content']);
      $this->setTimeCreated(strtotime($post_data['date_created']));
      $this->setTimeModified(strtotime($post_data['date_modified']));
      $this->permalink = $post_data['permalink'];
    }
  }
?>
