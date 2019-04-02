<?php
require_once root . "/Views/Frame/header.php";

require_once root . "/Views/Frame/reservationBlock.php";
?>

<section class="rooms-area section-padding-0-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-6">
                <div class="section-heading text-center">
                    <h2>Válassz a szobáink közül</h2>
                    <hr role="tournament1">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris
                        sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien.</p>
                </div>
            </div>
        </div>
        <div class="row">

            <?php if (count($allRooms) > 0): foreach ($allRooms as $room): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                        <div class="bg-thumbnail bg-img"
                             style="background-image: url(<?php echo $room->room_picture; ?>);"></div>
                        <p class="price-from"><?php echo $room->price?>Ft/Éj-től</p>
                        <a href="/view-room/?room_id=<?php echo $room->room_id;?>" class="rooms-text">
                            <div
                                <?php if ($room->room_status_id == 1): ?>
                                    style="color: green;"
                                <?php else: ?>
                                    style="color: red"
                                <?php endif; ?>
                            >
                                <?php if ($room->room_status_id == 1): ?>
                                    Jelenleg elérhető
                                <?php else: ?>
                                    Jelenleg foglalt
                                <?php endif; ?>
                            </div>
                            <h4><?php echo $room->room_name; ?> </h4>
                            <div class="rating">
                                <?php if ($room->qualification == 5): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room->qualification == 4): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room->qualification == 3): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room->qualification == 2): ?>
                                    <span>&#9734;</span>
                                    <span>&#9734;</span>
                                <?php elseif ($room->qualification == 1): ?>
                                    <span>&#9734;</span>
                                <?php endif; ?>
                            </div>

                            <p><?php echo $room->description ?> </p>

                            <?php if (isset($_SESSION["id"]) && $userrole["role_id"] == 1): ?>
                                <a title="Szerkeztés" style="color: white;margin-left: 3px; "
                                   href="/edit-room/?room_id=<?php echo $room->room_id; ?>"><i
                                            class="fa fa-edit"></i></a>
                            <?php endif; ?>
                        </a>

                        <a href="/booking/?room_id=<?php echo $room->room_id ?>"
                           class="book-room-btn btn palatin-btn">Foglalás</a>

                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="alert alert-warning text-center w-100">
                    <i class="fa fa-warning"></i> Jelenleg nincs elérhető szoba
                </div>
            <?php endif; ?>

        </div>

    </div>
</section>


<?php
if (isset($_SESSION["id"])):
    if ($userrole["role_id"] == 1):
        ?>
        <section id="add_new_room" class="contact-form-area mb-100">
            <div class="container">
                <div class="testimonial-content-comment">
                    <div class="section-heading text-center">
                        <h2>Új szoba felvétele</h2>
                        <hr role="tournament1">
                    </div>
                    <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                    <?php require_once root . "/Views/Alerts/successMessage.php"; ?>

                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <input type="text" id="name" class="form-control" name="name" placeholder="Szoba neve">
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <input type="number" id="price" name="price" class="form-control" placeholder="Ár">
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                                <select class="form-control add-new-room-select" id="qualification"
                                        name="qualification">
                                    <option value="0" selected disabled>Minősítés</option>
                                    <option value="1">1 csillag</option>
                                    <option value="2">2 csillag</option>
                                    <option value="3">3 csillag</option>
                                    <option value="4">4 csillag</option>
                                    <option value="5">5 csillag</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <select class="form-control add-new-room-select" id="type" name="type">
                                    <option value="0" selected disabled>Tipus</option>
                                    <option value="1">Standard</option>
                                    <option value="2">Premium</option>
                                    <option value="3">Luxury</option>
                                    <option value="4">Balcony</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <small><label for="">Háttérkép (A fálj mérete maximum 5mb lehet)</label></small>
                                <input type="file" id="picture" name="picture" class="form-control">
                            </div>
                        </div>

                        <div class="form-row">

                            <div class="form-group col-12 ">
                            <textarea id="description" class="form-control" name="description" rows="10"
                                      placeholder="Ide írhat leírást..."></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="add_new_room_btn" name="addNewRoomButton"
                                        class="btn palatin-btn">
                                    Felvétel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    <?php endif; endif; ?>

<?php require_once root . "/Views/Frame/footer.php"; ?>



