<?php

require_once root . "/DB/db.php";


class indexController
{

    public static function index()
    {
        require_once root . "/Models/room.php";

        $roomsWithLimit = room::roomsWithLimitThree();

        require_once root . "/Views/Index/index.php";
    }

    public static function about()
    {
        require_once root . "/Models/opinion.php";

        $allOpinions = opinion::allOpinionList();

        if (isset($_POST["addNewOpinionButton"])) {
            if ($_POST["body"] !== "") {
                opinion::addNewOpinion($_POST["body"], $_POST["type"]);
                $successMsg = "Sikeres vélemény írás!";
            } else {
                $errorMsg = "Minden mező kitöltése kötelező!";
            }
        }
        require_once root . "/Views/AboutUs/aboutUs.php";
    }

    public static function room($posts)
    {
        require_once root . "/Models/room.php";
        $db = db::get();

        $allRooms = room::allRooms();

        if (isset($_POST["addNewRoomButton"])) {
            if (isset($_POST["name"]) && isset($_POST["price"]) && isset($_POST["qualification"]) && isset($_POST["type"]) && isset($_POST["description"])) {

                $name = $db->escape($posts["name"]);
                $price = $db->escape($posts["price"]);
                $qualification = $db->escape($posts["qualification"]);
                $type = $db->escape($posts["type"]);
                $description = $db->escape($posts["description"]);

                if ($name !== "" && $price !== "" && $qualification !== 0 && $description !== "" && $type !== 0) {
                    //room::addNewRoom($_POST["type"],$_POST["price"],$_POST["name"],$_POST["qualification"],$_POST["description"]);
                    room::addNewRoom($name,$price,$name,$qualification,$description);
                } else {
                    $errorMsg = "Minden mező kitöltése kötelező!";
                }
            } else {
                $errorMsg = "Minden mező kitöltése kötelező!";
            }
        }
        require_once root . "/Views/Rooms/rooms.php";
    }


    public static function editRoom($posts)
    {
        require_once root . "/Models/room.php";
        $db = db::get();

        if (isset($_GET["room_id"])) {
            $selectedRoom = room::selectEditRoom();
        }
        if (isset($_POST["editRoomBtn"])) {
            if (isset($posts["name"]) && isset($posts["price"]) && isset($posts["qualification"]) && isset($posts["description"]) && isset($posts["type"])) {
                if ($posts["name"] !== "" &$posts["price"] !== "" && $posts["qualification"] !== 0 && $posts["description"] !== "" && $posts["type"] !== 0 && $posts["status"] !== 0) {

                    $name = $db->escape($posts["name"]);
                    $price = $db->escape($posts["price"]);
                    $qualification = $db->escape($posts["qualification"]);
                    $type = $db->escape($posts["type"]);
                    $description = $db->escape($posts["description"]);
                    $roomStatus = $db->escape($posts["status"]);

                    room::editRoom($type,$price,$name,$qualification,$description,$roomStatus);

                } else {
                    $errorMessage = "Minden mező kitöltése kötelező!";
                }
            }
        }

        if (isset($_POST["deleteRoomButton"])) {
            room::deleteRoom();
        }
        require_once root . "/Views/Rooms/editRoom.php";
    }

    public static function event($posts)
    {
        require_once root . "/Models/events.php";
        require_once root . "/Models/comment.php";
        $db = db::get();

        $allEvent = events::allEvent();
        //$allComment = comment::allComment();

        if (isset($_POST["saveCommentButton"])) {
            if (isset($_POST["description"]) && isset($_POST["eventId"])) {
                $description = $db->escape($posts["description"]);
                if ($_POST["description"] !== "") {
                    events::addNewComment();
                } else {
                    $errorMsg = "Ez a mező nem maradhat üresen!";
                }
            }
        }

        if (isset($_POST["addNewEventButton"])) {
            if (isset($_POST["eventTitle"]) &&isset($_POST["eventDate"]) && isset($_POST["eventDescription"])) {
                $eventTitle = $db->escape($posts["eventTitle"]);
                $eventDate = $db->escape($posts["eventDate"]);
                $eventDescription = $db->escape($posts["status"]);
                if ($eventTitle != "" && $eventDate  != "" && $eventDescription  != "") {
                    events::addNewEvent();
                } else {
                    $errorMsg = "Minden mező kitöltése kötelező";
                }
            }else{
                $errorMsg = "Minden mező kitöltése kötelező";
            }
        }
        if (isset($_POST["deleteEventButton"])) {
            events::deleteEvent();
            header("location: /events");
        }

        if (isset($_POST["deleteCommentButton"])) {
            comment::deleteComment();
            header("location: /events");
        }
        require_once root . "/Views/Events/events.php";
    }

    public static function comment($posts)
    {
        require_once root . "/Models/comment.php";
        $db = db::get();

        if (isset($_GET["comment_id"])){
            if (isset($_POST["saveCommentButton"])) {
                if (isset($_POST["description"])) {
                    $description = $db->escape($posts["description"]);
                    if ($description !== "") {
                        comment::editComment($description);
                        $successMsg="Sikeres módosítás!";
                        header("Refresh:3; /events");

                    } else {
                        $errorMsg = "Minden mező kitöltése kötelező!";
                    }
                }
            }
        }

        require_once root . "/Views/Events/editComment.php";
    }

    public static function profile()
    {

    }

}