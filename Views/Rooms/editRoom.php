<?php

foreach ($selectedRoom as $item) :
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="/Assets/Css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/Css/style.css">
    <title>Morgan Hotel***** - Edit - <?php echo $item->room_name;?></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="btn palatin-btn mr-1" href="/rooms">Vissza</a>
    <span class="navbar-text text-right">Szerkeztő: <?php echo $_SESSION["name"]; ?> </span>
</nav>
<div class="container">

    <div class="jumbotron">
        <h4 class="text-center">
            <?php echo $item->room_name; ?> adatainak szerkeztése
        </h4>
    </div>

    <div class="row  justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 col-lg-6 ">
            <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
            <?php require_once root . "/Views/Alerts/successMessage.php"; ?>
        </div>
    </div>

    <form action="" method="POST">
        <div class="row  justify-content-center">

            <div class="col-12 col-sm-12 col-md-10 col-lg-6 ">
                <div class="single-rooms-area-edit wow fadeInUp" data-wow-delay="100ms">
                    <div class="bg-thumbnail bg-img"
                         style="background-image: url(<?php echo $item->room_picture; ?>);"></div>
                    <p class="price-from"><input type="number" id="price" name="price" class="form-control"
                                                 value="<?php echo (isset($item)) ? $item->price : ""; ?>">
                    </p>
                    <div class="rooms-text">
                        <div class="line"></div>
                        <h4><input type="text" id="name" name="name" class="form-control "
                                   value="<?php echo (isset($item)) ? $item->room_name: ""; ?>"></h4>
                        <div class="rating">
                            <select name="qualification" id="qualification" class="form-control">
                                <option value="0" disabled selected>Minősítés</option>
                                <option value="1"<?php echo (isset($item) && $item->qualification === "1") ? "selected" : ""; ?>>
                                    1 csillag
                                </option>
                                <option value="2"<?php echo (isset($item) && $item->qualification == "2") ? "selected" : ""; ?>>
                                    2 csillag
                                </option>
                                <option value="3"<?php echo (isset($item) && $item->qualification == "3") ? "selected" : ""; ?>>
                                    3 csillag
                                </option>
                                <option value="4"<?php echo (isset($item) && $item->qualification == "4") ? "selected" : ""; ?>>
                                    4 csillag
                                </option>
                                <option value="5"<?php echo (isset($item) && $item->qualification == "5") ? "selected" : ""; ?>>
                                    5 csillag
                                </option>
                            </select>
                        </div>
                        <p class="mt-2">
                        <textarea id="description" class="form-control" name="description"
                                  rows="5"><?php print (isset($item)) ? $item->description : ""; ?>
                        </textarea>
                        </p>
                        <div class="mt-2">
                            <select name="type" id="type" class="form-control">
                                <option value="0" disabled selected>Minősítés</option>
                                <option value="1"<?php echo (isset($item) && $item->room_type_id == "1") ? "selected" : ""; ?>>
                                    Standard
                                </option>
                                <option value="2"<?php echo (isset($item) && $item->room_type_id == "2") ? "selected" : ""; ?>>
                                    Premium
                                </option>
                                <option value="3"<?php echo (isset($item) && $item->room_type_id == "3") ? "selected" : ""; ?>>
                                    Luxury
                                </option>
                                <option value="4"<?php echo (isset($item) && $item->room_type_id == "4") ? "selected" : ""; ?>>
                                    Balcony
                                </option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <select name="status" id="status" class="form-control">
                                <option value="0" disabled selected>Státusz...</option>
                                <option value="1"<?php echo (isset($item) && $item->room_status_id == "1") ? "selected" : ""; ?>>
                                    Elérhető
                                </option>
                                <option value="2"<?php echo (isset($item) && $item->room_status_id == "2") ? "selected" : ""; ?>>
                                    Nem elérhető
                                </option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" name="editRoomBtn" class="book-room-btn btn palatin-btn">Mentés</button>

                </div>
                <button type="submit" name="deleteRoomButton" class="w-100 book-room-btn btn palatin-btn mb-5" style="background-color: #ba7373;">A szoba végleges törlése</button>
            </div>
        </div>
    </form>

</div>


</body>
</html>
<?php
endforeach;