<?php
//session_start();
require_once root . "/Views/Frame/header.php"; // ez miatt van a header hibaüzenet
if (isset($_SESSION["id"])):

    require_once root."/DB/db.php";
    $db = db::get();
    $resId = $_SESSION["reservation_id"];

    $selectProducts = "SELECT * FROM extraproduct";

    if (isset($_POST["submitForm"]) && $_POST["submitForm"] == "reset") {
        header("location: /room-services");

    } else if (isset($_POST["search"])) {
        $search = $db->escape($_POST["search"]);
        $selectProducts .= " WHERE name LIKE '%" . $search . "%'";
    }

    $products = $db->getArray($selectProducts);

    if (isset($_POST["saveCartButton"])) {

        foreach ($_SESSION["cart"] as $values) {
            $sql = "SELECT * FROM extraproductorder WHERE product_id =" . $values["product_id"] . " AND reservation_id=$resId";
            $s = $db->getRow($sql);
            if ($s == 0) {
                $insertString = "INSERT INTO extraproductorder (product_id,reservation_id,quantity) VALUES ('" . $values["product_id"] . "','" . $resId . "','" . $values["quantity"] . "')";
                $s = $db->query($insertString);
                $successMsg = "Sikeres mentés!";
            } else {
                $quantity = $db->getRow($sql);
                $updateString = "UPDATE extraproductorder SET quantity=" . ($quantity["quantity"] + $values["quantity"]) . " WHERE product_id=" . $values["product_id"] . " AND reservation_id=$resId";
                $db->query($updateString);
                $successMsg = "Sikeres mentés!";
            }
        }

        unset($_SESSION["cart"]);
        ?>
        <script>
            setTimeout(function () {
                window.location.href = "/room-services";
            }, 2000);
        </script>
        <?php
    }


    $selectAllProducts = "SELECT *,extraproductorder.quantity AS oQuantity,extraproduct.quantity AS pQuantity FROM extraproductorder LEFT JOIN extraproduct ON extraproduct.product_id = extraproductorder.product_id WHERE extraproductorder.reservation_id =$resId";
    $allProducts = $db->getArray($selectAllProducts);


    ?>
    <div class="container">
        <div class="mt-175"></div>
        <?php if (count($allProducts) != 0): ?>
        <div class="row">
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
                                    <th scope="col">Termék</th>
                                    <th scope="col">Mennyiség</th>
                                    <th scope="col">Egységár</th>
                                    <th scope="col">Összeg</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($allProducts as $product): ?>

                                    <tr>
                                        <td><?php echo $product["name"]; ?></td>
                                        <td><?php echo $product["oQuantity"]; ?></td>
                                        <td><?php echo $product["price"]; ?>.-HUF</td>
                                        <td><?php echo $product["price"] * $product["oQuantity"]; ?>.-HUF</td>
                                    </tr>

                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="row mt-5">
            <?php require_once root . "/Views/Alerts/successMessage.php"; ?>

            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Szolgáltatások</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="input-group">
                                <div class="col-lg-6 offset-lg-3 col-12 form-group ">
                                    <input placeholder="Írja be a keresni kívánt termék nevét" type="text"
                                           class="form-control mb-3" name="search" id="search">

                                    <!-- <select name="searchType" id="searchType" class="form-control mb-3">
                                         <option selected disabled value="0">Válasszon egy típust</option>
                                         <option value="1">Ital</option>
                                         <option value="2">Étel</option>
                                     </select>-->

                                    <button class="btn palatin-btn mb-2" name="submitForm" value="go">Szűrés</button>
                                    <button type="submit" class="btn palatin-btn mb-2" style="background-color: #9b6161"
                                            name="submitForm" value="reset">
                                        Szűrés törlése
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped mt-5">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Termék</th>
                                    <th scope="col">Leírás</th>
                                    <th scope="col">Egységár</th>
                                    <th scope="col">Menniység</th>
                                    <th scope="col">Hozzáadás</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                if (count($products) > 0): foreach ($products as $product):
                                    ?>
                                    <form method="post"
                                          action="/shop/?action=add&id=<?php echo $product["product_id"]; ?>">
                                        <tr>

                                            <th scope="row"><?php echo $product["product_id"]; ?></th>
                                            <td><?php echo $product["name"]; ?></td>
                                            <td><?php echo $product["description"]; ?></td>
                                            <td><?php echo $product["price"]; ?>.-HUF</td>
                                            <td><input type="text" name="quantity" class="form-control" value="1"></td>
                                            <input type="hidden" name="hidden_name"
                                                   value="<?php echo $product["name"]; ?>">
                                            <input type="hidden" name="hidden_price"
                                                   value="<?php echo $product["price"]; ?>">
                                            <td>
                                                <button type="submit" name="addToCartButton"
                                                        class="btn palatin-btn-mini" value="Hozzáadás">+
                                                </button>
                                            </td>
                                        </tr>
                                    </form>
                                <?php
                                endforeach;
                                else: ?>
                                    <div class="alert alert-warning">
                                        <i class="fa fa-warning"></i> Jelenleg nincs elérhető termék!
                                    </div>
                                <?php
                                endif;
                                ?>

                                </tbody>
                            </table>
                        </div>
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
                                <a class="nav-link active" href="#">Bevásárlókosár</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($_SESSION["cart"])) : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="25%">Termék neve</th>
                                        <th width="5%">Mennyiség</th>
                                        <th width="25%">Egységár</th>
                                        <th width="25%">Összeg</th>
                                        <th width="5%">Törlés</th>

                                    </tr>
                                    <?php
                                    //var_dump($_SESSION["cart"]);

                                    $total = 0;

                                    foreach ($_SESSION["cart"] as $keys => $values) {
                                        ?>
                                        <tr>
                                            <td><?php echo $values["product_id"]; ?></td>
                                            <td><?php echo $values["name"]; ?></td>
                                            <td><?php echo $values["quantity"]; ?></td>
                                            <td><?php echo $values["price"]; ?>.-HUF</td>
                                            <?php $numb = number_format($values["quantity"] * $values["price"], 2); ?>
                                            <td><?php echo $numb; ?>
                                                .-HUF
                                            </td>
                                            <td>
                                                <a class="btn palatin-btn-mini"
                                                   href="shop.php?action=delete&id=<?php echo $values["product_id"]; ?>"><i
                                                            class="fa fa-trash mt-10"></i></a></td>
                                        </tr>
                                        <?php
                                        $total = $total + ($values["quantity"] * $values["price"]);
                                        $numf = number_format($total, 2);

                                    }


                                    ?>
                                    <tr>
                                        <td colspan="4" align="right">Összesen:</td>
                                        <td align="right"><?php echo $numf ?>.-HUF</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <form method="post" action="/shop">
                                <button type="submit" class="btn palatin-btn float-right"
                                        style="background-color: #9b6161"
                                        name="gomb">Kosár ürítés
                                </button>
                            </form>
                            <form method="post" action="">
                                <button type="submit" class="btn palatin-btn float-left" name="saveCartButton">
                                    Megrendelés
                                </button>
                            </form>
                        <?php
                        else:
                            $warningMsg = "Jelenleg a kosár üres!";
                        endif;
                        ?>
                        <?php if (isset($warningMsg) && $warningMsg != ""): ?>
                            <div class="alert alert-warning">
                                <i class="fa fa-warning"></i> <?php echo $warningMsg; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>


            </div>
        </div>

        <a href="/profile" class="btn palatin-btn mt-5"><i class="fa fa-arrow-left"></i> Vissza</a>
    </div>
    <?php
    require_once root . "/Views/Frame/footer.php";
else:
    ?>
    <script>
        window.location.href = "/login";
    </script>
<?php
endif;





