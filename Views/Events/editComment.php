<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/Assets/Css/style.css">
    <link rel="stylesheet" href="/Assets/Css/contact.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
          integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <title>Edit - Comment</title>
</head>
<body>
<div class="container">
    <div class="jumbotron" style="border-radius: 0">
        <h4 class="text-center">Szerkeztés</h4>
    </div>

    <div class="row mt-3">
        <div class="col-12">

        </div>
    </div>
    <div class="card mt-3">
        <div class="card-body">
            <?php
            if (isset($_GET["comment_id"])):
                $sql = "SELECT * FROM comment WHERE comment_id=" . $_GET["comment_id"];
                $comment = $db->getRow($sql);
                ?>
                <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                <?php require_once root . "/Views/Alerts/successMessage.php"; ?>

                <form action="" method="POST">
                    <div class="form-group">
                        <label for="description">Komment</label>
                        <textarea name="description" id="description" rows="2"
                                  class="form-control"><?php echo $comment["description"]; ?></textarea>
                    </div>
                    <div class="form-group">
                        <div class="float-left">
                            <a href="/events" class="btn palatin-btn" title="Vissza"><i class="fas fa-arrow-left"></i>
                                Vissza</a href="/events">
                        </div>
                        <div class="float-right">
                            <button class="palatin-btn" type="submit" name="saveCommentButton">Mentés</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="/Assets/Js/jquery/jquery-2.2.4.min.js"></script>
<script src="/Assets/Js/bootstrap/popper.min.js"></script>
<script src="/Assets/Js/bootstrap/bootstrap.min.js"></script>
</body>
</html>
