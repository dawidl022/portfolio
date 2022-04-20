<?php
  require_once '../exceptions/CannotChangeAuthorException.class.php';

  abstract class Statement {
    private int $id;
    private int $authorId;
    private string $content;
    private int $timeCreated;
    private int $timeModified;

    private const GET_AUTHOR_SQL = ""; // TODO

    function __construct(string $content, ?int $id = null, ?int $authorId = null,
                         ?int $timeCreated = null, ?int $timeModified = null) {
      $this->id = $id;
      $this->authorId = $authorId;
      $this->content = $content;
      $this->timeCreated = $timeCreated;
      $this->timeModified = $timeModified;
    }

    abstract function save() : void;

    abstract function delete() : void;

    abstract function isValid() : bool;

    function getAuthorId() : ?int {
      return $this->authorId;
    }

    function getAuthor() { // : Author {
      // TODO
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

      if ($this->$timeModified !== null && $timeModified < $this->$timeModified) {
        throw new InvalidArgumentException(
          "Modified time cannot be set to before the last modified time.");
      }

      $this->timeModified = $timeModified;
    }
  }
?>
