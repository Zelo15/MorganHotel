<?php
require_once root . "/DB/db.php";


class comment
{
    private static $table = "comment";

    public $id;
    public $eventId;
    public $userId;
    public $name;
    public $picture;
    public $description;
    public $createdAt;
    public $udpatedAt;

    public function __construct($id = null, $eventId, $userId, $name, $picture, $description, $createdAt, $udpatedAt)
    {
        $this->comment_id = $id;
        $this->event_id = $eventId;
        $this->user_id = $description;
        $this->name = $name;
        $this->picture = $picture;
        $this->description = $description;
        $this->created_at = $createdAt;
        $this->updated_at = $udpatedAt;
    }

    public static function allComment()
    {
        $selectString = "SELECT * FROM " . self::$table . " WHERE comment.event_id =" . $events->event_id;
        $db = db::get();
        $allElements = $db->getArray($selectString);
        $finalElements = array();
        foreach ($allElements as $element) {
            $finalElements[] = new comment(
                $element["comment_id"],
                $element["event_id"],
                $element["user_id"],
                $element["name"],
                $element["picture"],
                $element["description"],
                $element["created_at"],
                $element["updated_at"]
            );
        }
        return $finalElements;
    }

    public static function deleteComment()
    {
        $db = db::get();

        $deleteString = "DELETE FROM  " . self::$table . " WHERE comment_id=" . $_POST["commentId"];
        $db->query($deleteString);
    }

    public static function editComment($description)
    {
        $db = db::get();
        $updateString = "UPDATE " . self::$table . " SET description='" . $description . "' WHERE comment_id=" . $_GET["comment_id"];
        $db->query($updateString);
    }

    public static function selectComment()
    {
        $selectString = "SELECT * FROM " . self::$table . " WHERE comment_id=" . $_GET["comment_id"];
        //$comment = $db->getRow($sql);
        $db = db::get();
        $comment = $db->getRow($selectString);

    }
}