<?php

require_once root."/DB/db.php";
$db = db::get();

require_once root."/Views/Frame/header.php";

if (isset($_SESSION["id"])):
    $userData = "SELECT * FROM users LEFT JOIN guests ON users.user_id = guests.user_id WHERE users.user_id=" . $_SESSION["id"];
    $data = $db->getRow($userData);

    if (isset($_POST["editUserDataButton"])) {
        $name = $db->escape($_POST["name"]);
        $email = $db->escape($_POST["email"]);
        $postCode = $db->escape($_POST["postCode"]);
        $city = $db->escape($_POST["city"]);
        $address = $db->escape($_POST["address"]);
        $phone = $db->escape($_POST["phone"]);

        if (isset($name) && isset($email) && isset($postCode) && isset($city) && isset($address) && isset($phone)) {
            if ($name != "" && $email != "" && $postCode != "" && $city != "" && $address != "" && $phone != "") {
                $updateUserString = "UPDATE users SET `name`='" . $name . "',`email`='" . $email . "' WHERE user_id=" . $_SESSION["id"];
                $updateGuestString = "UPDATE guests SET `post_code`='" . $postCode . "',`city`='" . $city . "',`address`='" . $address . "',`phone`='" . $phone . "' WHERE user_id=" . $_SESSION["id"];
                $db->query($updateUserString);
                $db->query($updateGuestString);
                $successMsg = "Sikeres módosítás!";
                ?>
                <script>
                    setTimeout(function () {
                        window.location.href = '/profile';
                    }, 2000);

                </script>
                <?php
            } else {
                $errorMsg = "Minden mező kitöltése kötelező!";
            }
        }
    }

    ?>


    <div class="container " style="margin-top: 200px;">
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
                    <div class="card-body text-left">
                        <h5 class="text-left card-title">Adatok</h5>
                        <form action="" method="post">
                            <div class="form-row">
                                <?php require_once root . "/Views/Alerts/successMessage.php";?>
                                <?php require_once root . "/Views/Alerts/errorMessage.php";?>
                                <div class="form-group col-md-4">
                                    <label for="name">Név</label>
                                    <input type="text" class="form-control" id="name"  name="name" placeholder="Név..." value="<?php if ($data["name"] != ""): echo $data["name"]; endif; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"  placeholder="Email" value="<?php if ($data["email"] != ""): echo $data["email"]; endif; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="phone">Telefonszám</label>
                                    <input type="text" class="form-control" id="phone"  name="phone" placeholder="phone" value="<?php if ($data["phone"] != ""): echo $data["phone"]; endif; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="postCode">Irányítószám</label>
                                    <input type="number" class="form-control" id="postCode" name="postCode" placeholder="Irányítószám..." value="<?php if ($data["post_code"] != ""): echo $data["post_code"]; endif; ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">Város</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Város..." value="<?php if ($data["city"] != ""): echo $data["city"]; endif; ?>">
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="address">Cím</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Cím..." value="<?php if ($data["address"] != ""): echo $data["address"]; endif; ?>">
                                </div>

                            </div>
                            <button name="editUserDataButton" type="submit" class="btn palatin-btn">Mentés</button>
                            <a href="/profile" class="btn palatin-btn" style="background-color: #917e38">Vissza</a>
                        </form>
                    </div>
                    <div class="card-footer text-muted text-left">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require_once root."/Views/Frame/footer.php";
else:
    header("location: /login");
endif;
?>


