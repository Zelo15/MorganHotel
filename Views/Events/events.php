<?php

require_once root . "/Views/Frame/header.php";

//user roles
$selectRoleString = 'SELECT userrole.role_id FROM `users`  LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.user_id = "' . $_SESSION["id"] . '"';
$userrole = $db->getRow($selectRoleString);


require_once root . "/Views/Frame/reservationBlock.php";
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

<div class="blog-area section-padding-0-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="palatin-blog-posts">

                    <?php if ($userrole["role_id"] == 1) : ?>

                    <div class="single-blog-post mb-100 mt-175 wow fadeInUp " data-wow-delay="100ms">
                        <div class="post-content">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="text-center mb-5"><h1>Új esemény felvétele</h1></div>
                                <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                                <?php require_once root . "/Views/Alerts/successMessage.php"; ?>
                                <div class="form-row text-left">
                                    <div class="form-group col-lg-6 col-12">
                                        <label>Esemény időpontja</label>
                                        <input type="date" class="form-control" name="eventDate">
                                    </div>
                                    <div class="form-group col-lg-6 col-12">
                                        <label>Cím</label>
                                        <input type="text" class="form-control" name="eventTitle">
                                    </div>
                                </div>
                                <div class="form-row text-left">
                                    <div class="form-group col-12">
                                        <label for="eventDescription">Leírás</label>
                                        <textarea name="eventDescription" id="eventDescription" rows="5"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="form-group col-12">
                                        <input type="file" class="form-control" id="eventPicture"
                                               name="eventPicture">
                                        <label for="eventPicture">Válasszon egy
                                            háttérképet...</label>
                                    </div>

                                </div>

                                <div class="from-row mt-3">
                                    <div class="form-group col-12">
                                        <button name="addNewEventButton" class="btn palatin-btn" type="submit">
                                            Felvétel
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?>


                    <?php

                    if (count($allEvent) > 0) : foreach ($allEvent as $events):

                        $selectString = "SELECT * FROM comment WHERE comment.event_id =" . $events->event_id;
                        $allComment = $db->getArray($selectString);
                        ?>

                        <div class="single-blog-post mb-100 wow fadeInUp" data-wow-delay="100ms">
                            <div class="blog-post-thumb">
                                <?php if ($userrole["role_id"] == 1) : ?>
                                <form action="" method="post">
                                    <input type="hidden" name="eventId" value="<?php echo $events->event_id; ?>">
                                    <button class="btn palatin-btn float-right" type="submit"
                                            name="deleteEventButton" style="background: #916a6a"><?php echo $events->title;?> Esemény törlése</button>
                                </form>
                                <?php endif; ?>
                                <img src="<?php echo $events->picture; ?>">
                            </div>
                            <div class="post-content">
                                <a class="post-date btn palatin-btn"
                                   style="color:white;"><?php echo $events->event_date; ?></a>
                                <a class="post-title"><?php echo $events->title ?></a>
                                <p><?php echo $events->description; ?></p>
                                <div class="post-meta d-flex justify-content-center">
                                    <a href="/about" class="post-catagory">Hotel Morgan</a>

                                    <a class="post-comments"><?php echo $db->numnrows("SELECT * FROM comment WHERE comment.event_id =" . $events->event_id) ?>
                                        hozzászólás</a>
                                </div>

                                <?php
                                if (count($allComment) > 0): foreach ($allComment as $comment): ?>
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <a class="float-left">
                                                <h5>
                                                    <?php echo $comment['name']; ?>
                                                </h5>
                                            </a>
                                            <?php
                                            $now = time();
                                            $date = strtotime($comment["created_at"]);
                                            $datediff = $now - $date;
                                            ?>
                                            <small class="float-left" style="margin-left: 10px;margin-top: 5px;">
                                                <?php $count = round($datediff / (60 * 60 * 24));
                                                if ($count == 0) {
                                                    echo "Kevesebb mint egy ";
                                                } else {
                                                    echo $count;
                                                }

                                                ?> napja
                                            </small>

                                            <div class="float-right">
                                                <form action="" method="POST">
                                                    <input type="hidden" name="commentId" value="<?php echo $comment["comment_id"]; ?>">

                                                    <?php if (isset($_SESSION["id"])) : ?>
                                                        <?php if (($comment["user_id"] == $_SESSION["id"]) || ($userrole["role_id"] == 1)) : ?>
                                                            <a class="btn palatin-btn-mini" href="edit-comment/?comment_id=<?php echo $comment["comment_id"]; ?>"
                                                               title="Szerkeztés">
                                                                <i class="fa fa-edit" style="margin-top: 10px;"></i>
                                                            </a>

                                                            <button title="Törlés" type="submit" name="deleteCommentButton" class="btn palatin-btn-mini" style="background:#916a6a"><i class="fa fa-trash"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                </form>
                                            </div>

                                        </div>
                                        <div class="card-body text-left">
                                            <?php
                                            echo $comment["description"];
                                            ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="alert alert-warning w-100">
                                        <i class="fa fa-warning"></i>Jelenleg nincs egy hozzászólás sem!
                                    </div>
                                <?php endif; ?>

                                <div class="card mt-2">
                                    <div class="card-body">
                                        <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                                        <?php require_once root . "/Views/Alerts/successMessage.php"; ?>
                                        <form action="" method="POST">
                                            <div class="form-group">
                                                <input type="hidden" name="eventId"
                                                       value="<?php echo $events->event_id; ?>">
                                                <textarea name="description" id="description" rows="2"
                                                          class="form-control"
                                                          placeholder="Ide írhat hozzászólást"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button name="saveCommentButton" class="btn palatin-btn" type="submit"
                                                    <?php if (!isset($_SESSION["id"])) : ?>
                                                        disabled
                                                    <?php endif; ?>
                                                >
                                                    Hozzászólok
                                                </button>
                                                <?php if (!isset($_SESSION["id"])) : ?>
                                                    <small>Hozzászólás írásához be kell jelentkezned!</small>
                                                <?php endif; ?>

                                            </div>
                                        </form>
                                    </div>
                                </div>


                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <div class="alert alert-warning w-100">
                            <i class="fa fa-warning"></i>Jelenleg nincs egy esemény sem!
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>
<?php require_once root . "/Views/Frame/footer.php"; ?>
