<?php
require_once root . "/Views/Frame/header.php";

require_once root . "/Views/Frame/reservationBlock.php";
?>

    <section class="about-us-area" id="about-us-area">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-12 col-lg-6">
                    <div class="about-text text-center mb-100">
                        <div class="section-heading text-center">
                            <h2>Felejthetetlen élmény és rettegés</h2>
                            <hr role="tournament1">
                        </div>
                        <p>Biztosíthatunk benne hogy ha eltöltesz itt minimum egy éjszakát életed végéig emlékezni fogsz
                            erre az éjszakára</p>
                        <div class="about-key-text">
                            <h6><span class="fa fa-battery-full"></span>Maximális luxus egy horror kastélyban.</h6>
                            <h6><span class="fa fa-battery-full"></span>All inkluzív ellátás.</h6>
                        </div>
                        <a href="/about" class="btn palatin-btn mt-50">Több</a>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="about-thumbnail homepage mb-100">

                        <div class="first-img wow fadeInUp" data-wow-delay="100ms">
                            <img src="/Assets/Img/bg-img/luxury_room2.jpg" alt="Luxus Szoba">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="pool-area section-padding-100 bg-img bg-fixed"
             style="background-image: url(/Assets/Img/bg-img/nightBath2.jpg);">

        <div class="container">
            <div class="row justify-content-end">
                <div class="col-12 col-lg-7">
                    <div class="pool-content text-center wow fadeInUp" data-wow-delay="300ms">
                        <div class="section-heading text-center white">
                            <h2>Éjszakai fürdőzés</h2>
                            <hr class="style-five">
                            <h4 style="color: #856404">
                                Kapcsolódjon ki a Morgan éjszakai fürdőzésén!
                                Minden nap 20.00 – 03:30 óra között!
                            </h4>

                            <p>Szauna park is rendelkezésre áll az éjszakai fürdőzés ideje alatt.
                                A szauna belépő egységesen 1000 Ft/fő (fürdőbelépőjegy mellé vásárolható).
                                A szauna belépőjegy megváltásával ingyenesen vehet részt a szauna szeánszokon, melyek
                                előzetes regisztrációhoz kötöttek. Regisztráció az info@barlangfurdo.hu e-mail címen
                                vagy +36 46 560-030 telefonszámon. A szauna szeánszok időpontjai:
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rooms-area section-padding-100-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6">
                    <div class="section-heading text-center">
                        <h2>Fedezze fel szobáinkat</h2>
                        <p>Minden szobánk garantálja a megfelelő kastély élményt a luxus és a rettegés mellett.</p>
                        <hr role="tournament1">
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <?php if (count($roomsWithLimit) > 0): foreach ($roomsWithLimit as $room): ?>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="single-rooms-area wow fadeInUp" data-wow-delay="100ms">
                            <div class="bg-thumbnail bg-img"
                                 style="background-image: url(<?php echo$room->room_picture ?>);"></div>
                            <p class="price-from"><?php echo $room->price; ?>Ft/Éj-től</p>
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
                                <h4><?php echo $room->room_name ?> </h4>
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
                                <p><?php echo$room->description ?> </p>

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

<?php require_once root . "/Views/Frame/footer.php";  ?>