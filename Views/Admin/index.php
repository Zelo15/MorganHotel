<?php
if (isset($_POST["loginButton"])) {

    include_once root."/DB/db.php";
    $db = db::get();

    $name = $db->escape($_POST["name"]);
    $password = $db->escape($_POST["password"]);

    if (empty($_POST["name"]) || empty($_POST["password"])) {
        $errorMsg = "Minden mező kitöltése kötelező!";
    } else {
        $selectString = "SELECT * FROM users WHERE name='" . $name . "' && password = '" . md5($password) . "'";
        $query = $db->numnrows($selectString);
        if ($query != 1) {
            $errorMsg = "Hibás email vagy jelszó";
        } else {
            $selectUserData = "SELECT * FROM users LEFT JOIN userrole ON userrole.user_id = users.user_id LEFT JOIN role ON userrole.role_id = role.role_id WHERE users.name='" . $name . "' && users.password = '" . md5($password) . "'";
            $loginUser = $db->getRow($selectUserData);
            if ($loginUser["role_id"]==1 || $loginUser["role_id"]==4){
                session_start();
                $_SESSION["id"] = $loginUser["user_id"];
                $_SESSION["name"] = $loginUser["name"];
                header("Location: /dashboard");
            }else{
                $errorMsg="Nincs jogosultságod a belépéshez!";
                header("Location: /admin");
            }
            exit();
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/Assets/Css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/Css/style.css">
    <title>Hotel Morgan***** - Admin</title>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center" style="height:100vh">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <?php require_once root . "/Views/Alerts/errorMessage.php"; ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Username">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Password">
                        </div>
                        <button type="submit" id="loginButton" name="loginButton" class="btn palatin-btn">
                            Bejelentkezés
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
