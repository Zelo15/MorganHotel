<?php
require_once root . "/DB/db.php";


class events
{
    private static $table = "events";

    public $eventId;
    public $title;
    public $description;
    public $eventDate;
    public $eventPicture;

    public function __construct($eventId = null, $title, $description, $eventDate, $eventPicture)
    {
        $this->event_id = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->event_date = $eventDate;
        $this->picture = $eventPicture;
    }

    public static function allEvent()
    {
        $selectString = "SELECT * FROM " . self::$table;
        $db = db::get();
        $allElements = $db->getArray($selectString);
        $finalElements = array();
        foreach ($allElements as $element) {
            $finalElements[] = new events(
                $element["event_id"],
                $element["title"],
                $element["description"],
                $element["event_date"],
                $element["picture"]
            );
        }
        return $finalElements;
    }


    public static function addNewComment()
    {
        $db = db::get();
        $date = Date("Y-m-d H:i:s");
        $description = $_POST["description"];
        $eId = $_POST["eventId"];
        $insertString = "INSERT INTO comment (`event_id`,`user_id`,`name`,`description`,`created_at`,`updated_at`) VALUES ('" . $eId . "','" . $_SESSION["id"] . "','" . $_SESSION["name"] . "', '" . $description . "','" . $date . "','" . $date . "')";
        $db->query($insertString);
    }

    public static function deleteEvent()
    {
        $db = db::get();
        $deleteQueryStringComment = 'DELETE FROM comment WHERE event_id=' . $_POST["eventId"];
        $deleteQueryStringEvent = 'DELETE FROM '.self::$table.' WHERE event_id=' . $_POST["eventId"];
        $db->query($deleteQueryStringComment);
        $db->query($deleteQueryStringEvent);
    }

    public static function addNewEvent()
    {
        $db = db::get();

        if ($_FILES['eventPicture']['size'] == 0 && $_FILES['eventPicture']['error'] == 0) {

            //default background
            $fileDestination = "Assets/Img/uploads/events/default.jpg";

            $insertString = "INSERT INTO ".self::$table." (`title`,`description`,`event_date`,`picture`) VALUES ('" . $_POST["eventTitle"] . "','" . $_POST["eventDescription"] . "','" . $_POST["eventDate"] . "', '" . $fileDestination . "')";
            $db->query($insertString);

            $successMsg = "Sikeres esemény felvétel";

            header("location: /events/?success");
        } else {

            $file = $_FILES["eventPicture"];
            $pictureid = mt_rand(0, 999999);
            $fileName = $file["name"];
            $fileTMP = $file["tmp_name"];
            $fileSize = $file["size"];
            $fileType = $file["type"];
            $fileError = $file["error"];

            $fileExp = explode(".", $fileName);
            $fileExpAct = strtolower(end($fileExp));
            $allowed = array("jpg", "jpeg", "png");
            if (in_array($fileExpAct, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 100000000) {
                        $fileNewName = "eventPicture" . $pictureid . "." . $fileExpAct;
                        $fileDestinationForDB = "/Assets/Img/uploads/events/" . $fileNewName;
                        $fileDestination = "Assets/Img/uploads/events/" . $fileNewName;

                        $insertString = "INSERT INTO events (`title`,`description`,`event_date`,`picture`) VALUES ('" . $_POST["eventTitle"] . "','" . $_POST["eventDescription"] . "','" . $_POST["eventDate"] . "', '" . $fileDestinationForDB . "')";
                        $db->query($insertString);

                        move_uploaded_file($fileTMP, $fileDestination);

                        $successMsg = "Sikeres esemény felvétel";
                        header("location: /events");

                    } else {
                        $errorMsg = "A kép nem lehet nagyobb mint 5mb!";
                    }
                } else {
                    header("location: /errors");
                }
            }
        }
    }

}