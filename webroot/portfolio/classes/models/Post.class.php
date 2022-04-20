<?php
  class Post extends Statement {
    private string $title;
    private int $numberOfVotes;

    function __construct(?int $id = null, ?int $authorId = null, ?string $title,
                         ?string $content = null, ?int $timeCreated = null,
                         ?int $timeModified = null, ?int $numberOfVotes = 0) {
      parent::__construct($content, $id, $authorId, $timeCreated, $timeModified);
      $this->title = $title;
      $this->numberOfVotes = $numberOfVotes;
    }

    function save() : void {
      // TODO
    }

    function delete() : void {
      // TODO
    }

    function isValid(): bool {
      // TODO
      return false;
    }
  }
?>
