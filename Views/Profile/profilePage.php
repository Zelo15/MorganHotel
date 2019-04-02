<?php

require_once root."/DB/db.php";
$db = db::get();

require_once root . "/Views/Frame/header.php";

if (isset($_SESSION["cart"])){
    unset($_SESSION["cart"]);
}


if (isset($_SESSION["id"])):

//check the roles
    $selectRoleString = 'SELECT userrole.role_id FROM `users`  LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.user_id = "' . $_SESSION["id"] . '"';
    $userrole = $db->getRow($selectRoleString);

    $selectReservationString = "SELECT users.user_id,users.name,users.email,guests.post_code,guests.city,guests.address,reservation.PIN,reservation.reservation_id,reservation.reservation_date,reservation.check_in,reservation.check_out,reservation.members,reservation.description,rooms.room_id,rooms.room_name,rooms.price FROM reservation LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON guests.user_id = users.user_id LEFT JOIN rooms ON rooms.room_id = reservation.room_id WHERE users.user_id=" . $_SESSION["id"];
    $reservations = $db->getArray($selectReservationString);

    $userData = "SELECT * FROM users LEFT JOIN guests ON users.user_id = guests.user_id WHERE users.user_id=" . $_SESSION["id"];
    $data = $db->getRow($userData);

    $now = time();
    $date = strtotime($data["joined"]);
    $datediff = $now - $date;
    ?>



    <div class="container " style="margin-top: 175px;">
        <div class="row mb-5">
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Felhasználói adatok</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="text-left card-title">Adatok</h5>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <p class="card-text text-left">Név : <?php echo $data["name"]; ?></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="card-text text-left">Email : <?php echo $data["email"]; ?></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="card-text text-left">Cím
                                    : <?php echo $data["post_code"] . " " . $data["city"] . " " . $data["address"]; ?></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="card-text text-left">Telefonszám
                                    : <?php echo $data["phone"]; ?></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="card-text text-left">A fiók aktív
                                    : <?php echo round($datediff / (60 * 60 * 24)); ?> napja</p>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer text-muted text-left">
                        <div class="col-12">
                            <a href="/edit-profile" class="btn palatin-btn-mini"><i
                                        class="fa fa-edit mt-10"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-5">
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Szolgáltatások</a>
                            </li>
                        </ul>
                    </div>
                    <?php if (isset($_POST["scannPinButton"])) {
                        if (isset($_POST["PIN"]) && $_POST["PIN"] != "") {
                            $reservationString = "SELECT reservation.PIN,reservation.reservation_id,reservation.check_in,reservation.check_out FROM reservation LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON users.user_id = guests.user_id WHERE users.user_id =" . $_SESSION["id"];
                            $s = $db->getArray($reservationString);

                            foreach ($s as $pin) {
                                if ($pin["check_in"] <= date("Y-m-d") && $pin["check_out"] >= date("Y-m-d")) {
                                    if ($pin["PIN"] === $_POST["PIN"]) {

                                        $correctPIN = $_POST["PIN"];
                                        $reservationPIN = "SELECT reservation.reservation_id FROM reservation WHERE reservation.PIN=" . $correctPIN;
                                        $p = $db->getRow($reservationPIN);
                                        $_SESSION["reservation_id"] = $p["reservation_id"];
                                        //header("location: /room-services")
                                        ?>
                                        <script>
                                            window.location.href = "/room-services";
                                        </script>
                                        <?php
                                    } else {
                                        $errorMsg = "Helytelen PIN kód!";
                                    }
                                } else {
                                    $errorMsg = "Helytelen PIN kód!";
                                }
                            }
                        } else {
                            $errorMsg = "A mező kitöltése kötelező!";

                        }
                    }
                    ?>
                    <div class="card-body">

                        <div id="pin">
                            <form method="post" action="">
                                <div class="form-group row">
                                    <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                                    <label for="PIN" class="col-3 col-lg-2 col-form-label">PIN</label>
                                    <div class="col-6 col-lg-4">
                                        <input type="password" name="PIN" class="form-control" id="PIN"
                                               placeholder="****">
                                    </div>
                                    <div class="col-3 col-lg-1">
                                        <button class="btn palatin-btn-mini" type="submit" name="scannPinButton">OK
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Foglalások</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Szoba</th>
                                <th scope="col">Érkezés</th>
                                <th scope="col">Távozás</th>
                                <th scope="col">Státusz</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $counter = 1;
                            if (count($reservations) > 0):
                            foreach ($reservations as $reservation):
                                ?>
                                <tr <?php if ($reservation["check_out"] < date("Y-m-d")): ?>
                                    style="background-color: rgba(209, 183, 177,0.2)"
                                <?php else: ?>
                                    style="background-color: rgba(177, 209, 193,0.2)"
                                <?php endif; ?>>
                                    <th scope="row"><?php echo $counter; ?></th>
                                    <td><?php echo $reservation["room_name"]; ?></td>
                                    <td><?php echo $reservation["check_in"]; ?></td>
                                    <td><?php echo $reservation["check_out"]; ?></td>
                                    <td <?php if ($reservation["check_out"] < date("Y-m-d")): ?>
                                        style="color: red"
                                    <?php else: ?>
                                        style="color: #00ad5f;"
                                    <?php endif; ?> ><?php if ($reservation["check_out"] < date("Y-m-d")): ?>
                                            Inaktív
                                        <?php else: ?>
                                            Aktív
                                        <?php endif; $counter++;?></td>
                                </tr>
                            <?php  endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fa fa-warning"> Jelenleg nincs egyetlen aktív foglalásod sem!</i>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php

    include root . "/Views/Frame/footer.php";

else:
    ?>
    <script>
        window.location.href = "/login";
    </script>
<?php
endif;
?>


