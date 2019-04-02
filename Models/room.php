<?php
require_once root . "/DB/db.php";


class room
{
    private static $table = "rooms";

    public $roomId;
    public $roomTypeId;
    public $roomStatusId;
    public $price;
    public $roomName;
    public $qualification;
    public $description;
    public $roomPicture;


    public function __construct($roomId = null, $roomTypeId, $roomStatusId, $price, $roomName, $qualification, $description, $roomPicture)
    {
        $this->room_id = $roomId;
        $this->room_type_id = $roomTypeId;
        $this->room_status_id = $roomStatusId;
        $this->price = $price;
        $this->room_name = $roomName;
        $this->qualification = $qualification;
        $this->description = $description;
        $this->room_picture = $roomPicture;
    }

    public static function roomsWithLimitThree()
    {
        $selectString = "SELECT * FROM " . self::$table . " LIMIT 3";
        $db = db::get();
        $allElements = $db->getArray($selectString);
        $finalElements = array();
        foreach ($allElements as $element) {
            $finalElements[] = new room(
                $element["room_id"],
                $element["room_type_id"],
                $element["room_status_id"],
                $element["price"],
                $element["room_name"],
                $element["qualification"],
                $element["description"],
                $element["room_picture"]
            );
        }
        return $finalElements;
    }

    public static function allRooms()
    {
        $selectString = "SELECT * FROM " . self::$table;
        $db = db::get();
        $allElements = $db->getArray($selectString);
        $finalElements = array();
        foreach ($allElements as $element) {
            $finalElements[] = new room(
                $element["room_id"],
                $element["room_type_id"],
                $element["room_status_id"],
                $element["price"],
                $element["room_name"],
                $element["qualification"],
                $element["description"],
                $element["room_picture"]
            );
        }
        return $finalElements;
    }

    public static function addNewRoom($roomTypeId, $price, $roomName, $qualification, $description)
    {
        $db = db::get();

        $file = $_FILES["picture"];
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
                if ($fileSize < 5242880) { //max 5mb
                    $fileNewName = "RoomPicture" . $pictureid . "." . $fileExpAct;
                    $fileDestination = "Assets/Img/uploads/rooms/" . $fileNewName;
                    $one = 1;
                    //$insertString = "INSERT INTO rooms (room_type_id,room_status_id,price,room_name,qualification,description,room_picture) VALUES ('" . $type . "','". $one ."', '" . $price . "','" . $name . "','" . $qualification . "','" . $description . "','" . $fileDestinationForDB . "')";
                    $insertString = "INSERT INTO " . self::$table . " (room_type_id,room_status_id,price,room_name,qualification,description,room_picture) VALUES ('" . $roomTypeId . "','" . $one . "', '" . $price . "','" . $roomName . "','" . $qualification . "','" . $description . "','" . $fileDestination . "')";

                    $db->query($insertString);

                    move_uploaded_file($fileTMP, $fileDestination);

                    $successMsg = "Sikeres szoba felvétel!";

                    header("location: /rooms");
                } else {
                    $errorMsg = "A kép mérete mximum 5mb lehet!";
                }
            } else {
                header("location: /error");
            }
        } else {
            header("location: /error");
        }
    }

    public static function editRoom($roomTypeId, $price, $roomName, $qualification, $description, $roomStatusId)
    {
        $db = db::get();
        $updateString = "UPDATE " . self::$table . " SET room_status_id='" . $roomStatusId . "',price='" . $price . "',room_name='" . $roomName . "',qualification='" . $qualification . "',description='" . $description . "',room_type_id='" . $roomTypeId . "' WHERE room_id =" . $_GET["room_id"];
        var_dump($updateString);
        $db->query($updateString);
        $successMessage = "Sikeres frissítés";
        header("Refresh: 3; /rooms");
    }


    public static function selectEditRoom()
    {
        $db = db::get();
        $selectString = "SELECT * FROM ".self::$table." WHERE room_id =" . $_GET["room_id"];

        $allElements = $db->getArray($selectString);
        $finalElements = array();
        foreach ($allElements as $element) {
            $finalElements[] = new room(
                $element["room_id"],
                $element["room_type_id"],
                $element["room_status_id"],
                $element["price"],
                $element["room_name"],
                $element["qualification"],
                $element["description"],
                $element["room_picture"]
            );
        }
        return $finalElements;
    }

    public static function deleteRoom()
    {
        $db = db::get();
        $deleteString = "DELETE FROM ".self::$table." WHERE room_id=" . $_GET["room_id"];
        $db->query($deleteString);
        header("location: /rooms");
    }

}
