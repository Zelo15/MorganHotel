<?php

require_once root . "/DB/db.php";
$db = db::get();
$selectRoleString = 'SELECT userrole.role_id FROM `users`  LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.user_id = "' . $_SESSION["id"] . '"';
$userrole = $db->getRow($selectRoleString);

if ($userrole["role_id"] == 1):

    $b = "SELECT users.user_id,users.name,users.email,reservation.status_id, reservation.reservation_id,reservation.reservation_date,reservation.check_in,reservation.check_out,reservation.members,reservation.description,rooms.room_id,rooms.room_name,rooms.price FROM `reservation` LEFT JOIN rooms ON rooms.room_id = reservation.room_id LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON users.user_id = guests.user_id WHERE reservation.reservation_id =" . $_GET["reservation_id"];
    $allBookings = $db->getRow($b);

    $selectReservationPayment = "SELECT * FROM payment LEFT JOIN reservation ON reservation.reservation_id = payment.reservation_id  LEFT JOIN rooms ON rooms.room_id = reservation.room_id WHERE payment.reservation_id=" . $_GET["reservation_id"];
    $payment = $db->getRow($selectReservationPayment);

    $selectReservationOrder = "SELECT *,extraproductorder.quantity AS oQuantity FROM extraproductorder LEFT JOIN extraproduct ON extraproduct.product_id = extraproductorder.product_id WHERE reservation_id=" . $_GET["reservation_id"];
    $orders = $db->getArray($selectReservationOrder);


    if (isset($_POST["editBookingButton"])):
        if (isset($_GET["reservation_id"])):
            if ($_POST["checkIn"] !== "" && $_POST["checkOut"] !== "" && $_POST["members"] !== "" && $_POST["roomName"] !== 0) :
                $updateString = "UPDATE reservation SET `check_in`='" . $_POST["checkIn"] . "',`check_out`='" . $_POST["checkOut"] . "',`members`='" . $_POST["members"] . "',`room_id`='" . $_POST["roomName"] . "',`description`='" . $_POST["description"] . "',`status_id`='" . $_POST["statusId"] . "' WHERE reservation_id=" . $allBookings["reservation_id"];
                //$updateStringRole = "UPDATE userrole SET `role_id`='" . $_POST["roleId"] . "' WHERE user_id=" . $allBookings["user_id"];
                $db->query($updateString);
                //$DB->query($updateStringRole);
                $successMsg = "Sikeres módosítás!";
                header('Refresh: 2; /dashboard');
            else:
                $errorMsg = "Minden mező kitöltése kötelező!";
            endif;
        endif;
    endif;

    if (isset($_POST["deniedPayment"])) {
        $updateString = "UPDATE payment SET payment_status_id=1 WHERE reservation_id=" . $_GET["reservation_id"];
        $db->query($updateString);
        header("refresh:0");
    } elseif (isset($_POST["successPayment"])) {
        $updateString = "UPDATE payment SET payment_status_id=2 WHERE reservation_id=" . $_GET["reservation_id"];
        $db->query($updateString);
        header("refresh:0");
    }

    if (isset($_POST["deleteBookingButton"])):
        if (isset($_GET["reservation_id"])) :
            $deleteReservationString = "DELETE FROM reservation WHERE reservation_id=" . $_GET["reservation_id"];

            $db->query($deleteReservationString);
            $successMsg = "Sikeres törlés";
            header('Refresh: 2; /dashboard');
        endif;
    endif;

    if (isset($_POST["logOutButton"])) {
        session_start();
        session_destroy();
        header('Location: /admin');
        exit();
    }

    require_once root . "/Views/Admin/header.php";
    ?>

    <div class="row">
        <div class="col-12">

            <div class="card bg-light mb-3">
                <div class="card-header">Adatok</div>
                <div class="card-body">
                    <section id="add_new_room" class="contact-form-area mb-100">
                        <div class="testimonial-content-comment">
                            <div class="section-heading text-center">
                                <h2>Foglalás szerkeztése</h2>
                                <hr role="tournament1">
                            </div>
                            <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                            <?php require_once root . "/Views/Alerts/successMessage.php"; ?>
                            <?php if (isset($_GET["reservation_id"])): ?>
                                <form action="" method="POST">
                                    <div class="form-row">
                                        <div class="form-group col-12 col-md-4">
                                            <label for="name">Név</label>
                                            <input type="text" id="name" class="form-control rounded-0"
                                                   disabled
                                                   name="name"
                                                   placeholder="Név"
                                                   value="<?php echo $allBookings["name"]; ?>">
                                        </div>
                                        <div class="form-group col-12 col-md-4">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email"
                                                   disabled
                                                   class="form-control rounded-0"
                                                   placeholder="Email cím"
                                                   value="<?php echo $allBookings["email"]; ?>">
                                        </div>
                                        <div class="form-group col-12 col-md-4">
                                            <label for="reservationTime">Foglalás időpontja</label>
                                            <input type="text" id="reservationTime"
                                                   class="form-control rounded-0"
                                                   disabled
                                                   name="reservationTime"
                                                   placeholder="Érkezés"
                                                   value="<?php echo $allBookings["reservation_date"]; ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-12 col-md-4">
                                            <label for="checkIn">Érkezés</label>
                                            <input type="date" id="checkIn" class="form-control rounded-0"
                                                   name="checkIn"
                                                   placeholder="Érkezés"
                                                   value="<?php echo $allBookings["check_in"]; ?>">
                                        </div>
                                        <div class="form-group col-12 col-md-4">
                                            <label for="checkOut">Távozás</label>
                                            <input type="date" id="checkOut" name="checkOut"
                                                   class="form-control rounded-0"
                                                   placeholder="Távozás"
                                                   value="<?php echo $allBookings["check_out"]; ?>">
                                        </div>
                                        <div class="form-group col-12 col-md-4">
                                            <label for="statusId">Státusz</label>
                                            <select name="statusId" id="statusId" class="form-control">
                                                <option value="1"
                                                        <?php if ($allBookings["status_id"] == 1): ?>selected<?php endif; ?>>
                                                    Nyitott
                                                </option>
                                                <option value="2"
                                                        <?php if ($allBookings["status_id"] == 2): ?>selected<?php endif; ?>>
                                                    Lezárt
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-12 col-md-4">
                                            <label for="members">Fő</label>
                                            <input type="number" id="members" class="form-control rounded-0"
                                                   name="members"
                                                   placeholder="Tagok"
                                                   value="<?php echo $allBookings["members"]; ?>">
                                        </div>

                                        <?php
                                        $rN = "SELECT * FROM rooms";
                                        $allRooms = $db->getArray($rN);
                                        ?>
                                        <div class="form-group col-12 col-md-4">
                                            <label for="roomName">Szoba</label>
                                            <select class="form-control rounded-0" name="roomName"
                                                    id="roomName">
                                                <option value="0">Válasszon...</option>
                                                <?php foreach ($allRooms as $room) : ?>
                                                    <option <?php if ($room["room_id"] == $allBookings["room_id"]): ?> selected <?php endif; ?>
                                                            value="<?php echo $room["room_id"]; ?>"><?php echo $room["room_name"]; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-12 col-md-4">
                                            <label for="price">Ár</label>
                                            <input type="number" id="price" name="price"
                                                   class="form-control rounded-0"
                                                   placeholder="Ár"
                                                   value="<?php echo $allBookings["price"]; ?>">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-12 ">
                                            <label for="description">Megjegyzés</label>
                                            <textarea class="form-control rounded-0" name="description"
                                                      id="description" cols="12" rows="5">
                                                            <?php if ($allBookings["description"] != ""): echo $allBookings["description"]; ?>
                                                            <?php endif; ?>
                                                        </textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="float-left">
                                                <button type="submit" id="editBookingButton"
                                                        name="editBookingButton"
                                                        class="btn palatin-btn">Mentés
                                                </button>
                                                <a href="/dashboard" class="btn palatin-btn">Mégse
                                                </a>
                                            </div>
                                            <div class="float-right">
                                                <button type="submit" name="deleteBookingButton"
                                                        class="btn palatin-btn"
                                                        style="background-color:red ">Foglalás törlése
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            </div>


        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Számla</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Név</th>
                                <th scope="col">Mennyiség</th>
                                <th scope="col">Ár</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $array = 0;
                            ?>
                            <tr>
                                <td><?php echo $payment["room_name"]; ?></td>
                                <td>1</td>
                                <td><?php echo $payment["price"]; ?>.-HUF</td>
                                <?php $array = $payment["price"]; ?>
                            </tr>
                            <?php if (count($orders) != 0): foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo $order["name"]; ?></td>
                                    <td><?php echo $order["oQuantity"]; ?></td>
                                    <td><?php echo $order["price"] * $order["oQuantity"]; ?>.-HUF</td>
                                    <?php $array = $array + (int)$order["price"] * (int)$order["oQuantity"]; ?>
                                </tr>
                            <?php endforeach; endif; ?>
                            <tr>
                                <td><h5>Státusz: </h5>
                                    <p <?php if ($payment["payment_status_id"] == 1): ?>style="color: green"
                                       <?php else: ?>style="color: red"<?php endif; ?>>
                                        <?php if ($payment["payment_status_id"] == 1): echo "Nyitott"; else: echo "Lezárt"; endif; ?></p>
                                </td>
                                <td></td>
                                <td>
                                    <h5>Összesen: </h5>
                                    <?php echo $array; ?>.-HUF
                                </td>
                            </tr>
                            <tr>
                                <form action="" method="post">
                                <td>
                                    <button type="submit" name="successPayment" class="btn palatin-btn"
                                            style="background-color: #00ad5f">Fizetve
                                    </button>
                                </td>
                                <td>
                                    <button type="submit" name="deniedPayment" class="btn palatin-btn"
                                            style="background-color: #9b6161">Nincs
                                        fizetve
                                    </button>
                                </td>
                                </form>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once root . "/Views/Admin/footer.php"; ?>

<?php else: header("location: /admin");
    $errorMsg = "Nincs jogosultságod a belépéshez! Ezt a jogot az Admin-tól tudod beszerezni!" ?>
<?php endif; ?>
