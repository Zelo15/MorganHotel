<?php
require_once root . "/Views/Frame/header.php";

require_once root . "/Views/Frame/reservationBlock.php";

require_once root . "/DB/db.php";

?>

    <section class="about-us-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="about-text mb-100">
                        <div class="section-heading">
                            <div class="line-"></div>
                            <h2>A Hotel története</h2>
                        </div>
                        <p>A Fekete-kastély, mely valójában két épületből, a felső, illetve az alsó kastélyból áll,
                            Balatonederics külterületén található. Tulajdonosa egykor a híres Nedeczky család volt, akik
                            a 18. században szereztek itt birtokot. Eredetileg az alsó, kevésbé impozáns kastélyt
                            lakták, egészen addig, míg Nedeczky Jenő meg nem tervezte, illetve meg nem építtette a felső
                            kastélyt is, ahová unokahúgával, Emmával kötött házassága után be is költözött.

                            Bár hivatalosan egykori fekete színe - vannak, akik szerint a feketére festett ajtók és
                            ablakok - miatt nevezték el Fekete-kastélynak az épületet, ma a többség a hozzá kapcsolódó
                            sötét történetekhez köti mindezt.

                            Nedeczky Jenőt kora erőteljes jellemként és igazi lázadóként emlegette, aki ellenezte az
                            abszolutizmust és a császári hatalmat, mely miatt Habsburg-ellenes összeesküvés vádjával le
                            is tartóztatták, csak úgy, mint testvérét. Bár mindkettejüket felmentették, Jenő büszkesége
                            későbbi súlyos betegségével már nem tudott megbirkózni, 1914-ben, 74. születésnapján a
                            kastélyban követett el öngyilkosságot.
                        </p>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="about-thumbnail mb-100">
                        <img src="/Assets/Img/bg-img/nightview.jpg" alt="A szellemkastély tava">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-milestones section-padding-100-0 bg-img bg-overlay bg-fixed"
             style="background: url(/Assets/Img/bg-img/nightview.jpg) center bottom;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="section-heading text-center white">
                        <h2>Amire büszkék vagyunk</h2>
                        <hr class="stars">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris
                            sceleri sque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus
                            finibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem
                            maximus mauris sceleri sque, at rutrum nulla dictum.</p>
                    </div>
                </div>
            </div>


            <div class="row">

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="300ms">
                        <div class="scf-text">
                            <i class="fa fa-users"></i>
                            <h2><span class="counter"><?php echo $db->numnrows("SELECT * FROM guests"); ?></span></h2>
                            <p>Elégedett vengég</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="700ms">
                        <div class="scf-text">
                            <i class="fa fa-birthday-cake"></i>
                            <h2><span class="counter"><?php echo $db->numnrows("SELECT * FROM events"); ?></span></h2>
                            <p>Esemény</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="900ms">
                        <div class="scf-text">
                            <i class="fa fa-bed"></i>
                            <h2><span class="counter"><?php echo $db->numnrows("SELECT * FROM rooms"); ?></span></h2>
                            <p>Szoba</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-cool-fact mb-100 wow fadeInUp" data-wow-delay="500ms">
                        <div class="scf-text">
                            <i class="fa fa-heart"></i>
                            <h2><span class="counter">4.9</span></h2>
                            <p>Átlag Értékelés</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="testimonial-area section-padding-100 bg-img"
             style="background-image: url(/Assets/Img/core-img/pattern.png);">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="testimonial-content">
                        <div class="section-heading text-center">
                            <div class="line-"></div>
                            <h2>Rólunk mondták</h2>
                        </div>


                        <div class="testimonial-slides owl-carousel">
                            <?php if (count($allOpinions) > 0):
                                foreach ($allOpinions as $opinion):
                                    if ($opinion->status == 2):
                                    ?>

                                    <div class="single-testimonial">
                                        <p><?php echo $opinion->body; ?></p>
                                        <h6><?php echo $opinion->name; ?>,
                                            <span><?php echo $opinion->type; ?></span></h6>
                                        <p><?php echo $opinion->created_at; ?></p>
                                        <img src="/Assets/Img/core-img/trip.png" alt="">
                                        <?php
                                        if (isset($_SESSION["id"])): if ($userrole["role_id"] == 1): ?>
                                        <div class="float-right">
                                            <a href="/events/?opinion_id=<?php echo $opinion->opinion_id; ?>"
                                               title="Törlés">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                        <?php endif; endif; ?>
                                    </div>
                                        <?php
                                    endif;
                                endforeach;
                            else: ?>
                                <div class="alert alert-warning text-center">
                                    <i class="fa fa-warning"></i> Jelenleg nincs egy vélemény sem!
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <!-- comment-->
                    <div class="testimonial-content-comment" style="margin-top: 50px; ">
                        <div class="section-heading text-left">
                            <h2>Vélemény írása</h2>

                            <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                            <?php require_once root . "/Views/Alerts/successMessage.php"; ?>


                            <form action="" method="post">

                                <div class="from-group ">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input name="type" type="hidden" class="form-control" id="type"
                                                   <?php if (isset($_SESSION["id"]) && $userrole["role_id"] == 1): ?>value="Admin"
                                                   <?php else: ?>value="Vendég"<?php endif; ?>>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <textarea type="text" cols="6" rows="3" name="body" class="form-control"
                                              placeholder="Ide írhatsz véleményt..."></textarea>
                                </div>

                                <div class="form-group">
                                    <button name="addNewOpinionButton" type="submit" class="btn palatin-btn"
                                        <?php if (!isset($_SESSION["id"])) : ?>
                                            disabled
                                        <?php endif; ?>
                                    >Küldés
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

<?php require_once root . "/Views/Frame/footer.php"; ?>