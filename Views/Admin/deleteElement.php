<?php
require_once root."/DB/db.php";
$db = db::get();

if (isset($_GET["user_id"]) && isset($_GET["product_id"]) && isset($_GET["reservation_id"])){
    $productId = $_GET["product_id"];
    $reservationId =$_GET["reservation_id"];
    $userId = $_GET["user_id"];

    $deleteProductString="DELETE FROM extraproductorder WHERE product_id=$productId AND reservation_id=$reservationId";
    $db->query($deleteProductString);
    header("location: /edit-user/?user_id=$userId");
}