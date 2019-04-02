<?php
require_once root . "/DB/db.php";
$db = db::get();
$selectRoleString = 'SELECT userrole.role_id FROM `users`  LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.user_id = "' . $_SESSION["id"] . '"';
$userrole = $db->getRow($selectRoleString);

$activeUsers = $db->numnrows("SELECT * FROM users");

$activeGuests = $db->numnrows("SELECT * FROM  guests");

$activeAccounts = $db->numnrows("SELECT * FROM sessions WHERE date > DATE_SUB(NOW(), INTERVAL 5 MINUTE) ");

$bookingsNumber = $db->numnrows("SELECT * FROM reservation");

$roomsNumber = $db->numnrows("SELECT * FROM rooms");

$selectAllBookings = "SELECT users.name,users.email,rooms.room_name,payment.payment_status_id,payment.payment_date,reservation.status_id,reservation.check_in,reservation.check_out,reservation.reservation_id FROM reservation LEFT JOIN payment ON payment.reservation_id=reservation.reservation_id LEFT JOIN rooms ON rooms.room_id = reservation.room_id LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON users.user_id = guests.user_id ORDER BY reservation_date";
$allBookings = $db->getArray($selectAllBookings);

$selectAllUsers = "SELECT users.user_id, users.name AS u_name ,users.email,role.name AS r_name FROM users LEFT JOIN userrole ON users.user_id = userrole.user_id LEFT JOIN role ON role.role_id = userrole.role_id";

$selectOpinion = "SELECT * FROM opinions WHERE status = 1";
$opinions = $db->getArray($selectOpinion);


if (isset($_POST["searchButton"])) {
    if (!empty($_POST["searchInput"])) {
        $sInput = $db->escape($_POST["searchInput"]);
        $selectAllUsers = "SELECT users.user_id, users.name AS u_name ,users.email,role.name AS r_name FROM users LEFT JOIN userrole ON users.user_id = userrole.user_id LEFT JOIN role ON role.role_id = userrole.role_id WHERE users.name LIKE '%" . $sInput . "%' OR users.email LIKE '%" . $sInput . "%'";
    }
} elseif (isset($_POST["reset"])) {
    header("location: /dashboard");
}
$allUsers = $db->getArray($selectAllUsers);

if (isset($_POST["allowOpinionButton"])) {
    $sql = "UPDATE opinions SET status =2 WHERE opinion_id=" . $_POST["oId"];
    $db->query($sql);
    header("location: /dashboard");
} elseif (isset($_POST["deniedOpinionButton"])) {
    $sql = "UPDATE opinions SET status =3 WHERE opinion_id=" . $_POST["oId"];
    $db->query($sql);
    header("location: /dashboard");
}

if (isset($_POST["logOutButton"])) {
    session_start();
    session_destroy();
    header('Location: /admin');
    exit();

}

require_once root."/Views/Admin/header.php";
?>


        <?php if ($userrole["role_id"] == 1): ?>
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="card bg-light mb-3 rounded-0">
                        <div class="card-header">Aktív felhasználók</div>
                        <div class="card-body">
                            <section class="our-milestones section-padding-100-0 bg-img bg-overlay bg-fixed">
                                <div class="container">


                                    <div class="row">

                                        <div class="col">
                                            <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="300ms">
                                                <div class="scf-text">
                                                    <i class="fa fa-users"></i>
                                                    <h2
                                                        <?php if ($activeAccounts == 0) : ?>
                                                            style="color: red;"
                                                        <?php else: ?>
                                                            style="color: green;"
                                                        <?php endif; ?>
                                                    >
                                                        <span class="counter"><?php echo $activeAccounts; ?></span>
                                                    </h2>
                                                    <p>Elérhető felhasználók</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="300ms">
                                                <div class="scf-text">
                                                    <i class="fa fa-users"></i>
                                                    <h2
                                                        <?php if (($activeUsers - 1) == 0) : ?>
                                                            style="color: red;"
                                                        <?php else: ?>
                                                            style="color: green;"
                                                        <?php endif; ?>
                                                    >
                                                        <span class="counter"><?php echo $activeUsers - 1; ?></span>
                                                    </h2>
                                                    <p>Felhasználók</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="300ms">
                                                <div class="scf-text">
                                                    <i class="fa fa-users"></i>
                                                    <h2
                                                        <?php if ($activeGuests == 0) : ?>
                                                            style="color: red;"
                                                        <?php else: ?>
                                                            style="color: green;"
                                                        <?php endif; ?>
                                                    >
                                                        <span class="counter"><?php echo $activeGuests; ?></span>
                                                    </h2>
                                                    <p>Vendégek</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12">
                    <div class="card bg-light mb-3 rounded-0">
                        <div class="card-header">Foglalások száma</div>
                        <div class="card-body">
                            <section class="our-milestones section-padding-100-0 bg-img bg-overlay bg-fixed">
                                <div class="container">


                                    <div class="row">

                                        <div class="col">
                                            <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="300ms">
                                                <div class="scf-text">
                                                    <i class="fa fa-book"></i>
                                                    <h2
                                                        <?php if ($bookingsNumber == 0) : ?>
                                                            style="color: red;"
                                                        <?php else: ?>
                                                            style="color: green;"
                                                        <?php endif; ?>
                                                    >
                                                        <span class="counter"><?php echo $bookingsNumber; ?></span>
                                                    </h2>
                                                    <p>Foglalások száma</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="300ms">
                                                <div class="scf-text">
                                                    <i class="fa fa-bed"></i>
                                                    <h2
                                                        <?php if ($roomsNumber == 0) : ?>
                                                            style="color: red;"
                                                        <?php else: ?>
                                                            style="color: green;"
                                                        <?php endif; ?>
                                                    >
                                                        <span class="counter"><?php echo $roomsNumber ?></span>
                                                    </h2>
                                                    <p>Szobák</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card bg-light mb-3 rounded-0">
                        <div class="card-header">Eddigi Foglalások</div>
                        <div class="card-body">
                            <?php if (count($allBookings) > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Név</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Szoba</th>
                                            <th scope="col">Érkezés</th>
                                            <th scope="col">Távozás</th>
                                            <th scope="col">Státusz</th>
                                            <th scope="col">Részletek</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $counter = 1;
                                        foreach ($allBookings as $c): ?>

                                            <?php
                                            $hours_to_add = 10;
                                            $time = new DateTime($c["check_out"]);
                                            $time->add(new DateInterval('PT' . $hours_to_add . 'H'));
                                            $checkOutT = $time->format('Y-m-d H:i:s');

                                            if ($checkOutT < date("Y-m-d H:i:s")) {
                                                if ($c["status_id"] != 2) {
                                                    $db->query("UPDATE reservation SET status_id=2 WHERE reservation_id=" . $c["reservation_id"]);
                                                }
                                            } elseif ($c["payment_date"] < date("Y-m-d H:i:s")) {
                                                if ($c["payment_status_id"] != 2) {
                                                    $db->query("UPDATE payment SET payment_status_id=2 WHERE reservation_id=" . $c["reservation_id"]);
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $counter; ?></th>

                                                <td><?php echo $c["name"]; ?></td>
                                                <td><?php echo $c["email"]; ?></td>
                                                <td><?php echo $c["room_name"]; ?></td>
                                                <td><?php echo $c["check_in"]; ?></td>
                                                <td><?php echo $c["check_out"]; ?></td>
                                                <td
                                                    <?php if ($c["status_id"] == 1): ?>
                                                        style="color: green;"
                                                    <?php else : ?>
                                                        style="color:red;"
                                                    <?php endif; ?>
                                                >
                                                    <?php if ($c["status_id"] == 1):
                                                        echo "Nyitott";
                                                    else :

                                                        echo "Lezárt";
                                                    endif;
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="/edit-booking/?reservation_id=<?php echo $c["reservation_id"] ?>"
                                                       class="btn btn-info"><i class="fa fa-info-circle"></i></a></td>
                                            </tr>
                                            <?php $counter++; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <tr>
                                    <div class="alert alert-warning w-100"><i class="fa fa-warning"></i>Jelenleg
                                        nincs egyetlen foglalás sem!
                                    </div>
                                </tr>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card bg-light mb-3 rounded-0">
                        <div class="card-header">Felhasználók</div>
                        <div class="card-body">
                            <?php if (count($allUsers) > 0): ?>
                                <form action="" method="post">
                                    <div class="input-group mb-3">
                                        <input type="text" name="searchInput" class="form-control "
                                               style="border-radius: 0">
                                    </div>
                                    <div class="input-group mb-3">
                                        <button class="btn palatin-btn mr-2" type="submit" id="searchButton"
                                                name="searchButton">Keresés
                                        </button>
                                        <button name="reset" class="btn palatin-btn" type="submit"
                                                style="background-color: #9b6161">Szűrés törlése
                                        </button>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Név</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Részletek</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $counter = 1;
                                        foreach ($allUsers as $u): ?>
                                            <?php if ($u["user_id"] == 2): $counter--; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <th scope="row"><?php echo $counter; ?></th>
                                                    <td><?php echo $u["u_name"]; ?></td>
                                                    <td><?php echo $u["email"]; ?></td>
                                                    <td><?php echo $u["r_name"]; ?></td>
                                                    <td><a href="edit-user/?user_id=<?php echo $u["user_id"] ?>"
                                                           class="btn btn-info"><i class="fa fa-info-circle"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                            <?php $counter++; endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <tr>
                                    <th class="col row">
                                        <div class="alert alert-warning w-100"><i class="fa fa-warning"></i>Jelenleg
                                            nincs egyetlen felhasználó sem!
                                        </div>
                                    </th>
                                </tr>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($userrole["role_id"] == 4): ?>
            <div class="row">
                <div class="col-12">
                    <div class="card bg-light mb-3 rounded-0">
                        <div class="card-header">Vélemény várólista</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Név</th>
                                        <th scope="col">Leírás</th>
                                        <th scope="col">Tipus</th>
                                        <th scope="col">Dátum</th>
                                        <th scope="col">Státusz</th>
                                        <th scope="col">Szerkeztés</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php if (count($opinions) != 0): ?>
                                        <?php
                                        $counter = 1;
                                        foreach ($opinions as $opinion):
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $counter; ?></th>
                                                <td><?php echo $opinion["name"]; ?></td>
                                                <td><?php echo $opinion["body"]; ?></td>
                                                <td><?php echo $opinion["type"]; ?></td>
                                                <td><?php echo $opinion["created_at"]; ?></td>
                                                <td style="color: green;">Új</td>
                                                <td>
                                                    <form action="" method="POST">
                                                        <input type="hidden" name="oId"
                                                               value="<?php echo $opinion["opinion_id"]; ?>">
                                                        <button class="btn btn-success" name="allowOpinionButton"
                                                                type="submit" title="Rendben"><i
                                                                    class="fa fa-check"></i></button>
                                                        <button class="btn btn-danger" name="deniedOpinionButton"
                                                                type="submit" title="Elutasítás"><i
                                                                    class="fa fa-times"></i></button>
                                                    </form>

                                                </td>
                                            </tr>
                                            <?php $counter++;
                                        endforeach; ?>
                                    <?php else: $warningMsg = "Jelenleg nincs kiosztandó vélemény"; endif; ?>
                                    <?php if (isset($warningMsg)): ?>
                                        <div class="alert alert-warning">
                                            <i class="fa fa-warning"></i> <?php echo $warningMsg; ?>
                                        </div>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php
require_once root."/Views/Admin/footer.php";