<?php
require_once root . "/DB/db.php";


class opinion
{
    private static $table = "opinions";

    public $id;
    public $name;
    public $body;
    public $type;
    public $createdAt;
    public $status;


    public function __construct($id = null, $name, $body, $type, $createdAt,$status)
    {
        $this->opinion_id = $id;
        $this->name = $name;
        $this->body = $body;
        $this->type = $type;
        $this->created_at = $createdAt;
        $this->status = $status;
    }

    public static function allOpinionList()
    {
        $selectString = "SELECT * FROM " . self::$table;
        $db = db::get();
        $allElements = $db->getArray($selectString);
        $finalElements = array();
        foreach ($allElements as $element) {
            $finalElements[] = new opinion(
                $element["opinion_id"],
                $element["name"],
                $element["body"],
                $element["type"],
                $element["created_at"],
                $element["status"]
            );
        }
        return $finalElements;
    }

    public static function addNewOpinion($body, $type)
    {
        $db = db::get();
        $date = date("Y-m-d H:i:s");
        $insertString = "INSERT INTO " . self::$table . " (name,body,type,created_at,status) VALUES ('" . $_SESSION["name"] . "', '" . $body . "','" . $type . "','" . $date . "','1')";
        $db->query($insertString);

    }


}
