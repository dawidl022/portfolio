<?php
  require_once 'classes/models/Statement.class.php';

  class Comment extends Statement {
    private array $replies = [];

    function addReply(Comment $reply) : void {
      $this->replies[] = $reply;
    }

    function getReplies() : array {
      return $this->replies;
    }

    function save() : void{
      // TODO
    }

    function delete() : void {
      // TODO
    }

    function isValid(): bool {
      return $this->getContent() !== null && $this->getContent() !== '';
    }
  }
?>
