<?php
require_once root . "/Views/Frame/header.php";
require_once root . "/Views/Frame/reservationBlock.php";
require_once root . "/DB/db.php";
?>
<?php
$db = db::get();

$sql = "SELECT * FROM rooms WHERE room_id=".$_GET["room_id"];
$room = $db->getRow($sql);
?>
    <section class="about-us-area" id="about-us-area">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-12">
                    <div class="about-text mb-50">
                        <div class="section-heading text-center">
                            <h2>Szoba adatok</h2>
                            <hr role="tournament1">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $room["room_name"]?></h5>
                            <h5 class="card-title" style="color:#f4d142; font-size: 20px;">
                                <?php if ($room["qualification"] == 5): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room["qualification"] == 4): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room["qualification"] == 3): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room["qualification"] == 2): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room["qualification"] == 1): ?>
                                    <span>&#9734;</span>
                                <?php endif; ?>
                            </h5>
                            <p class="card-text"><?php echo $room["price"]?>.-Ft/Éj</p>
                            <p class="card-text"><?php echo $room["description"]?></p>
                            <p class="card-text">Férőhelyek száma: 1 - 4</p>
                            <a href="/booking/?room_id=<?php echo $_GET["room_id"]?>" class="btn palatin-btn">Most Foglalok</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <img src="<?php echo $room["room_picture"];?>" alt="room">
                </div>

            </div>
            <a href="/rooms" class="mt-3 btn palatin-btn"><i class="fa fa-arrow-left"></i> Vissza</a>
        </div>
    </section>

<?php
require_once root . "/Views/Frame/footer.php";
?>