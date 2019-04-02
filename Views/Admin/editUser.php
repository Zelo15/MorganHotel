<?php
require_once root . "/DB/db.php";
$db = db::get();
if (isset($_GET["user_id"])) :
    $selectRoleString = 'SELECT userrole.role_id FROM `users`  LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.user_id = "' . $_SESSION["id"] . '"';
    $userrole = $db->getRow($selectRoleString);

    if ($userrole["role_id"] == 1):

        $u = "SELECT *,users.name AS u_name ,users.email,role.name AS r_name,role.slug FROM users LEFT JOIN userrole ON users.user_id = userrole.user_id LEFT JOIN role ON role.role_id = userrole.role_id WHERE users.user_id =" . $_GET["user_id"];
        $editedUsers = $db->getRow($u);

//javítandó
        if (isset($_POST["editUserButton"])) {
            if (isset($_GET["user_id"])) {
                if (isset($_POST["uName"]) && isset($_POST["email"]) && isset($_POST["roleId"])) {
                    $uName = $db->escape($_POST["uName"]);
                    $email = $db->escape($_POST["email"]);
                    if ($uName != "" && $email != "" && $_POST["roleId"] != 0) {
                        $updateString = "UPDATE users SET `name`='" . $_POST["uName"] . "',`email`='" . $_POST["email"] . "' WHERE user_id=" . $_GET["user_id"];
                        $updateStringRole = "UPDATE userrole SET `role_id`='" . $_POST["roleId"] . "' WHERE user_id=" . $_GET["user_id"];
                        $db->query($updateString);
                        $db->query($updateStringRole);
                        $successMsg = "Sikeres módosítás!";
                        header("Refresh:3; /dashboard");
                    } else {
                        $errorMsg = "Minden mező kitöltése kötelező!";
                    }
                }
            }
        }

        if (isset($_POST["inactiveUserButton"])) {
            $updateString = "UPDATE users SET status='2' WHERE user_id=" . $_GET["user_id"];
            $db->query($updateString);
            $successMsg = "Sikeres inaktívizálás!";
            header('Refresh: 2; /dashboard');
        } else if (isset($_POST["activeUserButton"])):
            $updateString = "UPDATE users SET status='1' WHERE user_id=" . $_GET["user_id"];
            $db->query($updateString);
            $successMsg = "Sikeres aktívizálás!";
            header('Refresh: 2; /dashboard');
        endif;

//logout
        if (isset($_POST["logOutButton"])) {
            session_start();
            session_destroy();
            header('Location: /admin');
            exit();

        }

        $selectGuestId = "SELECT * FROM guests LEFT JOIN users ON users.user_id = guests.user_id WHERE users.user_id=" . $_GET["user_id"];
        $guestId = $db->getRow($selectGuestId);
        $gId = $guestId["guest_id"];


        ?>

        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="/Assets/Img/core-img/manisonico.ico">
            <link rel="stylesheet" type="text/css" href="/Assets/Css/font-awesome.min.css">
            <link rel="stylesheet" href="/Assets/Css/bootstrap.min.css">
            <link rel="stylesheet" href="/Views/Admin/style.css">


            <title>Hotel Morgan***** - Admin</title>
        </head>
        <body>

        <div class="wrapper">
            <nav id="sidebar">
                <div class="sidebar-header">
            <span class="login100-form-title p-b-59">
                <div class="footer_logo">
                    <a href="#" class="text-center">
                        <div class="footer_logo_subtitle">HOTEL</div>
                        <div class="footer_logo_title">MORGAN</div>
                        <div class="footer_logo_stars">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
            </span>
                </div>
                <ul class="list-unstyled components">
                    <p>Lehetőségek</p>
                    <li class="active">
                        <a href="/dashboard">Főoldal</a>
                    </li>

                    <?php if ($userrole["role_id"] == 1): ?>
                        <li>
                            <a href="/inservice">Termékek</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul>
                    <button type="button" style="width: 80%" onclick="reloadFunction()"
                            class="btn btn-outline-secondary">
                        Frissítés
                    </button>
                    <script>
                        function reloadFunction() {
                            location.reload();
                        }
                    </script>
                </ul>
            </nav>

            <div id="content">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="navbar-btn">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button"
                                data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fas fa-align-justify"></i>

                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <?php if ($userrole["role_id"] == 1): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/index">Főoldal(felhasználói nézet) </a>
                                    </li>
                                <?php endif; ?>
                                <form action="" method="POST">
                                    <li class="nav-item">
                                        <button type="submit" name="logOutButton" class="nav-link logOutBtn">
                                            Kijelentkezés
                                        </button>
                                    </li>
                                </form>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="row">
                    <div class="col-12">

                        <div class="card bg-light mb-3">
                            <div class="card-header">Adatok</div>
                            <div class="card-body">
                                <section id="add_new_room" class="contact-form-area mb-100">

                                        <div class="testimonial-content-comment">
                                            <div class="section-heading text-center">
                                                <h2>Felhasználó szerkeztése</h2>
                                                <hr role="tournament1">
                                            </div>
                                            <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                                            <?php require_once root . "/Views/Alerts/successMessage.php"; ?>
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <div class="form-row">
                                                        <div class="form-group col-12 col-md-6">
                                                            <label for="uName">Név</label>
                                                            <input type="text" id="uName" class="form-control rounded-0"
                                                                   name="uName"
                                                                   placeholder="Név"
                                                                   value="<?php echo $editedUsers["u_name"]; ?>">
                                                        </div>
                                                        <div class="form-group col-12 col-md-6">
                                                            <label for="email">Email</label>
                                                            <input type="email" id="email" name="email"
                                                                   class="form-control rounded-0"
                                                                   placeholder="Email cím"
                                                                   value="<?php echo $editedUsers["email"]; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-12 col-md-6">
                                                            <label for="rName">Jelenlegi jogosultság</label>
                                                            <input type="text" disabled id="rName"
                                                                   class="form-control rounded-0" name="rName"
                                                                   placeholder="Jogosultás"
                                                                   value="<?php echo $editedUsers["r_name"]; ?>">
                                                        </div>

                                                        <div class="form-group col-12 col-md-6">
                                                            <?php
                                                            $allRolesString = "SELECT * FROM role";
                                                            $allRoles = $db->getArray($allRolesString);
                                                            ?>
                                                            <label for="roleId">Új jogosultág</label>
                                                            <select name="roleId" id="roleId" class="rounded-0 form-control">
                                                                <option value="0" disabled selected>Válasszon...
                                                                </option>
                                                                <?php foreach ($allRoles as $role): ?>
                                                                    <option value="<?php echo $role["role_id"]; ?>"
                                                                            <?php if ($role["role_id"] == 1): ?>disabled<?php endif; ?>
                                                                    ><?php echo $role["name"]; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-row">
                                                        <div class="col-12">
                                                            <div class="float-left">
                                                                <button type="submit" id="editUserButton"
                                                                        name="editUserButton"
                                                                        class="btn palatin-btn">Szerkeztés
                                                                </button>
                                                                <a href="/dashboard" class="btn palatin-btn">Mégse
                                                                </a>
                                                            </div>
                                                            <div class="float-right">

                                                                <?php if ($editedUsers["status"] == 1): ?>
                                                                    <button type="submit" name="inactiveUserButton"
                                                                            class="btn palatin-btn"
                                                                            style="background-color:red ">Felhasználó
                                                                        inaktívizálás
                                                                    </button>
                                                                <?php else: ?>
                                                                    <button type="submit" name="activeUserButton"
                                                                            class="btn palatin-btn"
                                                                            style="background-color:green ">Felhasználó
                                                                        aktivizálása
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </form>
                                            <?php endif; ?>
                                        </div>

                                </section>
                            </div>
                        </div>
                        <?php
                        if ($gId != null):
                            $selectUserPayment = "SELECT * FROM payment WHERE guest_id=$gId";
                            $payment = $db->getArray($selectUserPayment);


                            if (count($payment) != 0): ?>
                                <div class="row mt-5">
                                    <div class="col-12">
                                        <div class="card text-center">
                                            <div class="card-header">
                                                <ul class="nav nav-tabs card-header-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" href="#">Eddigi vásárlások</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Név</th>
                                                            <th scope="col">Ár</th>
                                                            <th scope="col">Státusz</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php $counter = 1;
                                                        foreach ($payment as $item): ?>

                                                            <tr>
                                                                <td><?php echo $counter; ?></td>
                                                                <td><?php echo $item["name"]; ?></td>
                                                                <td><?php echo $item["price"]; ?>.-HUF</td>
                                                                <td
                                                                    <?php if ($item["payment_status_id"] == 1): ?>style="color: green"
                                                                    <?php else: ?>style="color: red"<?php endif; ?>
                                                                ><?php if ($item["payment_status_id"] == 1): echo "Nyitott"; else: echo "Lezárt"; endif; ?></td>
                                                            </tr>

                                                            <?php $counter++; endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            <?php endif; endif; ?>

                    </div>
                </div>
                <?php
                $sql = "SELECT *,extraproduct.name AS pName,extraproductorder.quantity AS pQuantity FROM extraproductorder LEFT JOIN extraproduct ON extraproduct.product_id = extraproductorder.product_id LEFT JOIN reservation ON reservation.reservation_id = extraproductorder.reservation_id LEFT JOIN guests ON guests.guest_id = reservation.guest_id LEFT JOIN users ON users.user_id = guests.user_id WHERE users.user_id =" . $_GET["user_id"];
                $allItems = $db->getArray($sql);
                $counter = 1;
                ?>

                <?php if (count($allItems) != 0): ?>
                    <div class="row mt-5">
                        <div class="col-12">

                            <div class="card bg-light mb-3">
                                <div class="card-header">Eddigi rendelések</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Termék neve</th>
                                                <th scope="col">Mennyiség</th>
                                                <th scope="col">Összesen</th>
                                                <th scope="col">Törlés</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($allItems as $item): ?>
                                                <tr>
                                                    <th scope="row"><?php echo $counter; ?></th>
                                                    <td><?php echo $item["pName"]; ?></td>
                                                    <td><?php echo $item["pQuantity"]; ?></td>
                                                    <td><?php echo $item["pQuantity"] * $item["price"]; ?></td>
                                                    <td>
                                                        <a href="/delete-element/?user_id=<?php echo $_GET["user_id"]; ?>&reservation_id=<?php echo $item["reservation_id"]; ?>&product_id=<?php echo $item["product_id"]; ?>"
                                                           class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                                <?php $counter++; endforeach; ?>
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
        ?>
    <?php else: header("location: /admin");
        $errorMsg = "Nincs jogosultságod a belépéshez! Ezt a jogot az Admin-tól tudod beszerezni!" ?>
    <?php endif; ?>
