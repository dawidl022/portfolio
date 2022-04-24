<?php
  require_once 'classes/exceptions/NotValidException.php';
  require_once 'classes/models/Statement.class.php';
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

    private function __construct(Database $db, ?string $title = null, ?string $content = null,
                     ?int $authorId = null, ?int $id = null,
                     ?int $timeCreated = null, ?int $timeModified = null,
                     ?int $numberOfVotes = 0) {
      parent::__construct($db, $content, $id, $authorId, $timeCreated, $timeModified);
      $this->title = $title;
      $this->numberOfVotes = $numberOfVotes;
    }

    static function create($title, $content, Author $author, Database $db) : self {
      return new self($db, $title, $content, $author->getId());
    }

    static function fromId($id, $db) {

    }

    static function fromPermalink(string $permalink, $db) : self {
      $post = new self($db);
      $post->permalink = $permalink;

      $post->setId($db->querySingle(self::GET_ID_SQL, 's', $permalink)['id']);
      $post->fetchData();
      return $post;
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
