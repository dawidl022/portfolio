<?php
  require_once 'classes/exceptions/ImmutablePropertyException.php';

  abstract class Statement {
    private ?int $id;
    private ?int $authorId;
    private ?string $content;
    private ?int $timeCreated;
    private ?int $timeModified;

    private const GET_AUTHOR_SQL = "SELECT name FROM users WHERE id = ?;";

    function __construct(Database $db, ?string $content, ?int $id,
                         ?int $authorId, ?int $timeCreated, ?int $timeModified) {
      $this->id = $id;
      $this->authorId = $authorId;
      $this->content = $content;
      $this->timeCreated = $timeCreated;
      $this->timeModified = $timeModified;
      $this->db = $db;
    }

    abstract function save() : void;

    abstract static function delete(Database $db, int $id) : void;

    abstract function isValid() : bool;

    function getAuthorId() : ?int {
      return $this->authorId;
    }

    protected function setAuthorId(int $id) {
      $this->authorId = $id;
    }

    function getAuthorName() : ?string {
      $result = $this->db->query(self::GET_AUTHOR_SQL, 'i', $this->authorId);

      if (count($result) === 0) {
        return null;
      } else {
        return $result[0]['name'];
      }
    }

    function setAuthor(User $author) : void {
      if ($this->getAuthorId() !== null) {
        throw new ImmutablePropertyException("Cannot change author once set.");
      }

      $this->authorId = $author->getId();
    }

    function getContent() : ?string {
      return $this->content;
    }

    function setContent(string $content) : void {
      $this->content = $content;
    }

    protected function getDb() : Database {
      return $this->db;
    }

    function getId() {
      return $this->id;
    }

    protected function setId(int $id) : void {
      $this->id = $id;
    }

    function getTimeCreated() : ?int {
      return $this->timeCreated;
    }

    protected function setTimeCreated(int $timeCreated) : void {
      if ($this->getTimeCreated() !== null) {
        throw new ImmutablePropertyException(
          "Cannot change created time once set.");
      }

      $this->timeCreated = $timeCreated;

      if ($this->timeModified === null) {
        $this->timeModified = $timeCreated;
      }
    }

    function getTimeModified() : ?int {
      return $this->timeModified;
    }

    protected function setTimeModified(int $timeModified) : void {
      if ($this->timeCreated === null) {
        // no need to keep track of modifications until object is persisted
        return;
      }

      if ($this->timeModified !== null && $timeModified < $this->timeModified) {
        throw new InvalidArgumentException(
          "Modified time cannot be set to before the last modified time.");
      }

      $this->timeModified = $timeModified;
    }
  }
?>
