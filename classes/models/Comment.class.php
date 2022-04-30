<?php
  require_once 'classes/models/Statement.class.php';

  class Comment extends Statement {
    private array $replies;
    private int $postId;
    private ?int $inReplyTo;

    private const INSERT_NEW_SQL =
      "INSERT INTO comments (user_id, post_id, in_reply_to, content) VALUES(?, ?, ?, ?);";

    private const GET_IN_REPLY_TO_SQL =
      "SELECT in_reply_to FROM comments WHERE id = ?;";

    function __construct(Database $db, string $content, ?int $id, ?int $userId,
                         int $postId, ?int $inReplyTo, ?int $timeCreated = null,
                         ?int $timeModified = null) {
      parent::__construct($db, $content, $id, $userId, $timeCreated, $timeModified);
      $this->replies = [];
      $this->postId = $postId;
      $this->inReplyTo = $inReplyTo;
    }

    static function create($db, $postId, $userId, $content, $inReplyTo = null) {
      return new self($db, $content, null, $userId, $postId, $inReplyTo);
    }

    function addReply(Comment $reply) : void {
      $this->replies[] = $reply;
    }

    function getReplies() : array {
      return $this->replies;
    }

    function save() : void{
      if (!$this->isValid() || !$this->isValidReply()) {
        throw new NotValidException(
          "Comment is invalid and cannot be saved to database");
      }

      if ($this->getId() === null) {
        $this->insert();
      } else {
        $this->update();
      }

      $this->fetchDates();
    }

    function delete() : void {
      // TODO
    }

    function isValid(): bool {
      return $this->getContent() !== null && $this->getContent() !== '';
    }

    function isValidReply() : bool {
      if ($this->inReplyTo === null) {
        return true;
      }

      try {
        $parent = $this->getDb()
          ->querySingle(self::GET_IN_REPLY_TO_SQL, 'i', $this->inReplyTo);
      } catch (RecordNotFoundException $e) {
        return false;
      }

      return $parent['in_reply_to'] === null;
    }

    private function insert() : void {
      $this->getDb()->command(self::INSERT_NEW_SQL, 'iiis',
        $this->getAuthorId(), $this->postId, $this->inReplyTo, $this->getContent());

        $this->setId($this->getDb()->getConn()->insert_id);
    }

    private function update() : void {

    }

    private function fetchDates() : void {

    }
  }
?>
