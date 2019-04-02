<?php
require_once root . "/Models/register.php";
require_once root . "/Models/login.php";
require_once root . "/DB/db.php";


class userController
{

    public static function signUp($posts)
    {
        if (isset($_POST["registerButton"])) {
            $db = db::get();
            $name = $db->escape($posts["name"]);
            $email = $db->escape($posts["email"]);
            $password = $db->escape($posts["password"]);
            $rePassword = $db->escape($posts["rePassword"]);

            if (isset($name) && isset($email) && isset($password)) {
                if (empty($name) || empty($email) || empty($password) || empty($rePassword)) {
                    $errorMsg = "Minden mező kitöltöltése kötelező!";
                } else if ($_POST["password"] != $_POST["rePassword"]) {
                    $errorMsg = "A két jelszó nem egyezik!";
                } else if (strlen($_POST["password"]) < 6) {
                    $errorMsg = "A jelszónak minimum 6 karakternek kell lennie!";
                } else if ($db->numnrows("SELECT * FROM users WHERE email='" . $_POST["email"] . "'") != 0) {
                    $errorMsg = "Ez az email cím már regisztrálva van!";
                } else {
                    register::register($posts["name"], $posts["email"], $posts["password"]);
                    $_SESSION["success"] = "Sikeres regisztráció!";
                    header("location: /login");
                }
            }else {
                $errorMsg = "Minden mező kitöltése kötelező!";
            }
        }
        require_once root . "/Views/Signup/register.php";
    }


    public static function logIn($posts)
    {
        if (isset($_POST["loginButton"])) {
            $db=db::get();
            $email = $db->escape($posts["email"]);
            $password = $db->escape($posts["password"]);
            if (isset($posts["email"])&& isset($posts["password"])){
                if (empty($email) || empty($password)) {
                    $errorMsg = "Minden mező kitöltése kötelező!";
                }else {
                    $selectString = "SELECT * FROM users WHERE email='" . $_POST["email"] . "' && password = '" . md5($posts["password"]) . "'";
                    $query = $db->numnrows($selectString);
                    if ($query != 1) {
                        $errorMsg = "Hibás email vagy jelszó!";
                    } else {
                        login::login($posts["email"], $posts["password"]);
                    }
                }
            }else{
                $errorMsg = "Minden mező kitöltése kötelező!";
            }
        }

        require_once root . "/Views/Signup/login.php";
    }
}