<?php
DEFINE('root', $_SERVER['DOCUMENT_ROOT']);
DEFINE("baseDir", dirname(__FILE__));
$uri = $_SERVER["REQUEST_URI"];
$partsOfUri = explode('/', $uri);
session_start();

if (empty($partsOfUri[1])) {
    header("location: /index");
} else {
    switch ($partsOfUri[1]) {

        case "index":
            require_once root . "Controllers/indexController.php";
            indexController::index();
            break;
        case "admin":
            require_once root . "/Views/Admin/index.php";
            break;
        case "dashboard":
            require_once root . "/Views/Admin/admin.php";
            break;
        case "signup":
            require_once root."/Controllers/userController.php";
            userController::signUp($_POST);
            break;
        case "room-services":
            require_once root . "Views/Profile/extraServices.php";
            break;
        case "edit-user":
            require_once root . "Views/Admin/editUser.php";
            break;
        case "edit-profile":
            require_once root . "Views/Profile/editProfile.php";
            break;
        case "delete-element":
            require_once root . "Views/Admin/deleteElement.php";
            break;
        case "edit-booking":
            require_once root . "Views/Admin/editBooking.php";
            break;
        case "shop":
            require_once root . "Views/Profile/shop.php";
            break;
        case "profile":
            require_once root . "Views/Profile/profilePage.php";
            break;
        case "login":
            require_once root."/Controllers/userController.php";
            userController::logIn($_POST);
            break;
        case "booking":
            require_once root . "Views/Booking/booking.php";
            break;
        case "events":
            require_once root . "Controllers/indexController.php";
            indexController::event();
            break;
        case "edit-comment":
            //require_once root . "Pages/Events/editComment.php";
            require_once root . "Controllers/indexController.php";
            indexController::comment();
            break;
        case "about":
            require_once root . "Controllers/indexController.php";
            indexController::about();
            break;
        case "rooms":
            require_once root . "Controllers/indexController.php";
            indexController::room();
            break;
        case "edit-room":
            require_once root . "Controllers/indexController.php";
            indexController::editRoom();
            break;
        case "view-room":
            require_once root . "Views/Rooms/viewRoom.php";
            break;
        case "inservice":
            require_once root . "Views/Inservice/inservice.html";
            break;
        case "logout":
            require_once root . "Views/Signup/logout.php";
            break;
        case "error":
            require_once root . "Views/Alerts/error.php";
            break;
        default:
            require_once root . "Views/Alerts/error.php";
            break;
    }
}
?>
