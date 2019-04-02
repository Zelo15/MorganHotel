<?php
//session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION["id"])):

    require_once root . "/DB/db.php";
    $db = db::get();

    $selectSrtingRooms = "SELECT * FROM rooms";
    $allRooms = $db->getArray($selectSrtingRooms);

    if (isset($_GET["room_id"])) {
        $getRoomId = $_GET["room_id"];
    }

//create guest from user
    if (isset($_POST["addBooking"])) {

        if (isset($_SESSION["name"]) && isset($_SESSION["email"]) && isset($_POST["phone"]) && isset($_POST["postCode"]) && isset($_POST["city"]) && isset($_POST["address"]) && isset($_POST["members"]) && isset($_POST["checkIn"]) && isset($_POST["checkOut"]) && isset($_POST["roomId"])) {

            $phone = $db->escape($_POST["phone"]);
            $postCode = $db->escape($_POST["postCode"]);
            $city = $db->escape($_POST["city"]);
            $address = $db->escape($_POST["address"]);
            $members = $db->escape($_POST["members"]);
            $checkIn = $db->escape($_POST["checkIn"]);
            $checkOut = $db->escape($_POST["checkOut"]);
            $roomId = $db->escape($_POST["roomId"]);
            if (isset($_POST["description"])) {
                $description = $db->escape($_POST["description"]);
            }
            if (!empty($phone) && !empty($postCode) && !empty($city) && !empty($address) && !empty($members) && !empty($checkIn) && !empty($checkOut) && $roomId != 0) {
                if ($checkIn >= date("Y-m-d") && $checkOut > date("Y-m-d")) {

                    $selectRooms = "SELECT * FROM rooms LEFT JOIN reservation ON rooms.room_id = reservation.room_id WHERE(('" . $checkIn . "' NOT BETWEEN reservation.check_in AND DATE_SUB(reservation.check_out,INTERVAL 1 DAY)) AND ('" . $checkOut . "' NOT BETWEEN reservation.check_in AND DATE_SUB(reservation.check_out, INTERVAL 1 DAY))) AND rooms.room_id='" . $roomId . "' OR reservation.reservation_id IS NULL AND rooms.room_id='" . $roomId . "'";
                    $enableRooms = $db->getRow($selectRooms);

                    if ($enableRooms == null) {
                        //ha az adott szoba jelenleg levan foglalva
                        $errorMsg = "Sajnos ez a szoba erre az időpontra már foglalva van!";
                    } else {
                        $date = date("Y:m:d H:i:s");
                        $PIN = rand(1000, 9999);
                        $selectGuestId = "SELECT guest_id FROM guests LEFT JOIN users ON users.user_id = guests.user_id WHERE users.user_id =" . $_SESSION["id"];
                        $guestId = $db->getRow($selectGuestId);
                        $selectPIN = "SELECT reservation.PIN FROM reservation LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON guests.user_id = users.user_id ORDER BY reservation.reservation_date DESC LIMIT 1";
                        $stat = false;
                        if ($guestId == "") {
                            $selectStringGuest = "INSERT INTO guests (user_id,address,post_code,city,phone) VALUES ('" . $_SESSION["id"] . "','" . $address . "','" . $postCode . "','" . $city . "','" . $phone . "')";
                            $db->query($selectStringGuest);
                            $guestId = $db->getRow($selectGuestId);
                            $selectStringBooking = "INSERT INTO reservation (guest_id, room_id, reservation_date, check_in, check_out, members, description,PIN,status_id) VALUES ('" . $guestId["guest_id"] . "', '" . $roomId . "', '" . $date . "', '" . $checkIn . "', '" . $checkOut . "', '" . $members . "', '" . $description . "','" . $PIN . "',1)";
                            $db->query($selectStringBooking);
                            //$selectPIN = "SELECT reservation.PIN FROM reservation LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON guests.user_id = users.user_id ORDER BY reservation.reservation_date DESC LIMIT 1";
                            $readPIN = $db->getRow($selectPIN);
                            $stat = true;
                            $successMsg = "Sikeres foglalás! A további részleteket elküldtük email-ben!";
                        } else {
                            $selectStringBooking = "INSERT INTO reservation (guest_id, room_id, reservation_date, check_in, check_out, members, description,PIN,status_id) VALUES ('" . $guestId["guest_id"] . "', '" . $_POST["roomId"] . "', '" . $date . "', '" . $_POST["checkIn"] . "', '" . $_POST["checkOut"] . "', '" . $_POST["members"] . "', '" . $_POST["description"] . "','" . $PIN . "',1)";
                            $db->query($selectStringBooking);
                            //$selectPIN = "SELECT reservation.PIN FROM reservation LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON guests.user_id = users.user_id ORDER BY reservation.reservation_date DESC LIMIT 1";
                            $readPIN = $db->getRow($selectPIN);
                            $stat = true;
                            $successMsg = "Sikeres foglalás! A további részleteket elküldtük email-ben!";
                        }

                        if ($stat == true) {
                            $selectReservation = "SELECT * FROM reservation LEFT JOIN rooms ON rooms.room_id = reservation.room_id WHERE guest_id=" . $guestId["guest_id"] . " ORDER BY reservation_date DESC LIMIT 1";
                            //var_dump($selectReservation);
                            //exit();
                            $reservationId = $db->getRow($selectReservation);
                            $rId = $reservationId["reservation_id"];
                            $roomPrice = $reservationId["price"];
                            $roomName = $reservationId["room_name"];
                            $roomQuality = $reservationId["qualification"];
                            $status = 1; //OPEN
                            $payment = $reservationId["check_out"];
                            $checkIn = $reservationId["check_in"];
                            $checkOut = $reservationId["check_out"];
                            $pin = $reservationId["PIN"];

                            require root . '/Mailer/src/Exception.php';
                            require root . '/Mailer/src/PHPMailer.php';
                            require root . '/Mailer/src/SMTP.php';
                            $mail = new PHPMailer(true);
                            $mail = new PHPMailer();
                            $mail->IsSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->Port = 465;
                            $mail->SMTPSecure = "ssl";
                            $mail->SMTPOptions = array(
                                'ssl' => array(
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true
                                )
                            );
                            $mail->SMTPAuth = true;
                            $mail->Username = 'hotelmorganinfo@gmail.com';
                            $mail->Password = 'morgan1998';
                            $mail->From = 'hotelmorganinfo@gmail.com';
                            $mail->FromName = 'Hotel Morgan*****';
                            $mail->AddAddress($_SESSION["email"]);
                            $mail->AddReplyTo('hotelmorganinfo@gmail.com', 'Information');
                            $mail->WordWrap = 80;
                            $mail->IsHTML(true);
                            $mail->CharSet = 'UTF-8';
                            $mail->Subject = 'Hotel Morgan***** - Sikeres Foglalás';
                            $mail->Body = '
                            <h1>Sikeres Szoba Foglalás!</h1>
                            <br>
                            <br>
                            <h3>Kedves ' . $_SESSION["name"] . '!</h3>
                            <br>
                            <p>Rendszerünkben rögzítettük az ön foglalását.</p>
                            <br>
                            <table style="text-align: left;">
                              <tr>
                                <th>Név: </th>
                                <td>'.$_SESSION["name"].'</td>
                              </tr>
                               <tr>
                                <th>Szoba: </th>
                                <td>'.$roomName.'</td>
                              </tr>
                              <tr>
                                <th style="color: red;">PIN kód: </th>
                                <td>'.$pin.'</td>
                              </tr>
                               <tr>
                                <th>Ár: </th>
                                <td>'.$roomPrice.'.-Ft/Éj</td>
                              </tr>
                              <tr>
                                <th>Minősítés: </th>
                                <td>'.$roomQuality.' Csillag</td>
                              </tr> 
                              <tr>
                                <th>Érkezés: </th>
                                <th>Távozás: </th>
                              </tr>
                              <tr>
                              <td>'.$checkIn.' - </td>
                                <td>'.$checkOut.'</td>
                              </tr>
                             
                            </table>
                            
                           <br>
                           <p style="color: red;">--INFORMÁCIÓ--</p>
                           <p>A szoba PIN-kódját jegyezze meg mert ezzel tud majd belépni a felhasználói oldalán a szobájába ahhoz hogy rendeléseket tudjn leadni!</p>
                           
                           <br>
                           <p>Üdvözlettel: <b>Hotel Morgan *****</b></p>
                            ';

                            if (!$mail->Send()) {
                                $errorMsg = "Hiba lépett fel a foglalás során, kérjük próbálja meg később!";
                            }

                            $hours_to_add = 10;
                            $time = new DateTime($payment);
                            $time->add(new DateInterval('PT' . $hours_to_add . 'H'));
                            $paymentDeadline = $time->format('Y-m-d H:i:s');

                            $insertPayment = "INSERT INTO payment (guest_id,reservation_id,name,price,payment_status_id,payment_date) VALUES ('" . $guestId["guest_id"] . "','" . $rId . "','" . $_SESSION["name"] . "','" . $roomPrice . "','" . $status . "','" . $paymentDeadline . "')";
                            $db->query($insertPayment);
                        }
                    }

                } else {
                    $errorMsg = "Az érkezési dátum nem lehett kissebb a mai dátumnál, vagy a távozási dátum nem lehet kissebb a mai-nál!";
                }
            } else {
                $errorMsg = "A megjegyzésen kívül minden mező kitöltése kötelező!";
            }
        } else {
            $errorMsg = "A megjegyzésen kívül minden mező kitöltése kötelező!";
        }

    }

    if (isset($_POST["approvalButton"])) {
        header("location: /booking");
    }

    if (isset($_SESSION["id"])) {
        $selectUsers = "SELECT * FROM users LEFT JOIN guests ON guests.user_id = users.user_id WHERE users.user_id=" . $_SESSION["id"];
        $u = $db->getRow($selectUsers);
    }
    ?>


    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <link rel="icon" href="/Assets/Img/core-img/manisonico.ico">
        <link rel="stylesheet" href="/Assets/Css/bootstrap.min.css">
        <link rel="stylesheet" href="/Assets/Css/style.css">
        <link rel="stylesheet" type="text/css" href="/Assets/Css/logo.css">

        <title>Hotel Morgan***** - Booking</title>
    </head>
    <body>

    <section class="contact-form-area mb-100 mt-5">
        <div class="container">
            <div class="testimonial-content-comment">
                <div class="row">

                    <div class="col-12">
                        <div class="section-heading text-center mt-1">
                            <div class=" footer_logo" style="">
                                <a href="#" class="text-center">
                                    <div class="footer_logo_subtitle">HOTEL</div>
                                    <div class="footer_logo_title">MORGAN</div>
                                    <div class="footer_logo_stars">
                                        <ul class="d-flex flex-row align-items-start justfy-content-start">
                                            <li><i class="fa fa-star" aria-hidden="true"></i>
                                            </li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i>
                                            </li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i>
                                            </li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i>
                                            </li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i>
                                            </li>
                                        </ul>
                                    </div>
                                </a>
                            </div>
                            <h1 class="mt-2 h1style">Foglalás</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <form action="" method="post">
                            <div class="row">
                                <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                                <?php require_once root . "/Views/Alerts/successMessage.php"; ?>
                                <?php if (isset($infoPinMsg) && !empty($infoPinMsg)) : ?>
                                    <div class="alert alert-info w-100">
                                        <div class="float-left">
                                            <i class="fa fa-info-circle"></i>
                                            <b><?php echo $infoPinMsg; ?></b>
                                        </div>
                                        <div class="float-right">
                                            <a href="booking.php" class="okBtn">OK</a>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Email cím</label></small>
                                    <input type="email" class="form-control" name="email"
                                           placeholder="Email"
                                           value="<?php echo isset($_SESSION["email"]) ? $_SESSION["email"] : "" ?>"
                                        <?php if (isset($_SESSION["id"])) : ?>
                                            disabled
                                        <?php endif; ?>
                                    >
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Telefonszám</label></small>
                                    <input type="text" class="form-control" name="phone"
                                           placeholder="Telefonszám"
                                        <?php if (isset($_SESSION["id"])): ?>
                                            <?php if (isset($u["phone"]) && $u["phone"] != null || $u["phone"] != ""): ?>
                                                value="<?php echo $u["phone"]; ?> "
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    >
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Irányítószám</label></small>
                                    <input type="text" class="form-control" name="postCode"
                                           placeholder="Irányítószám"
                                        <?php if (isset($_SESSION["id"])): ?>
                                            <?php if (isset($u["post_code"]) && $u["post_code"] != null || $u["post_code"] != ""): ?>
                                                value="<?php echo $u["post_code"]; ?> "
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    >
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Város</label></small>
                                    <input type="text" class="form-control" name="city"
                                           placeholder="Város"
                                        <?php if (isset($_SESSION["id"])): ?>
                                            <?php if (isset($u["city"]) && $u["city"] != null || $u["city"] != ""): ?>
                                                value="<?php echo $u["city"]; ?> "
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    >
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Cím</label></small>
                                    <input type="text" class="form-control" name="address"
                                           id="address" placeholder="Cím"
                                        <?php if (isset($_SESSION["id"])): ?>
                                            <?php if (isset($u["address"]) && $u["address"] != null || $u["address"] != ""): ?>
                                                value="<?php echo $u["address"]; ?> "
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    >
                                </div>


                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Szoba</label></small>
                                    <select name="roomId" id="roomId" class="form-control">
                                        <option value="0" selected disabled>Válasszon
                                            szobát...
                                        </option>
                                        <?php
                                        if (count($allRooms) > 0):
                                            foreach ($allRooms as $room):
                                                ?>
                                                <option
                                                    <?php if (isset($_GET["room_id"])): if ($getRoomId == $room["room_id"]): ?>
                                                        selected
                                                    <?php endif; endif; ?>
                                                        value="<?php echo $room["room_id"]; ?>"><?php echo $room["room_name"]; ?></option>
                                            <?php
                                            endforeach;
                                        else:
                                            ?>
                                            <option value="0" selected disabled>Jelenleg nincs
                                                elérhető szoba..
                                            </option>
                                        <?php endif; ?>

                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Személyek száma</label></small>
                                    <input type="number" name="members" class="form-control"
                                           placeholder="Személyek száma"
                                           max="4" min="1" value="1">
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Érkezés</label></small>
                                    <input type="date" name="checkIn" class="form-control"
                                           value="<?php echo date("Y-m-d"); ?>">
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <small><label for="">Távozás</label></small>
                                    <input type="date" name="checkOut" class="form-control"
                                           value="<?php echo date('Y-m-d', strtotime(' +1 day')); ?>">
                                </div>
                                <div class="col-lg-12">
                                <textarea name="description" id="" class="form-control" cols="30" rows="10"
                                          placeholder="Egyéb megjegyzés"></textarea>
                                </div>


                                <div class="col-12 text-center">
                                    <button type="submit" class="btn palatin-btn mt-50"
                                            name="addBooking"
                                            style="width: 250px">Foglalás
                                    </button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <a class="mt-2  btn palatin-btn" href="/rooms">Vissza</a>

            </div>
    </section>


    <script src="/Assets/Js/jquery/jquery-2.2.4.min.js"></script>
    <script src="/Assets/Js/bootstrap/popper.min.js"></script>
    <script src="/Assets/Js/bootstrap/bootstrap.min.js"></script>
    <script>

    </script>
    </body>
    </html>
<?php else:
    header("location: /login");
endif;