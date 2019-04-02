<?php
require_once root . "/DB/db.php";


class login
{
    private static $table = "users";

    public $name;
    public $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public static function login($email, $password)
    {

        $db = db::get();
        $selectString = "SELECT * FROM " . self::$table . " WHERE `email`='" . $email . "' && `password` = '" . md5($password) . "'";
        $query = $db->numnrows($selectString);
        if ($query != 1) {
            $errorMsg = "Hibás email vagy jelszó";
        } else {

            $selectUserData = "SELECT * FROM " . self::$table . " WHERE `email`='" . $email . "' && `password` = '" . md5($password) . "'";
            $loginUser = $db->getRow($selectUserData);

            session_start();
            $_SESSION["id"] = $loginUser["user_id"];
            $_SESSION["name"] = $loginUser["name"];
            $_SESSION["email"] = $loginUser["email"];

            header("Location: /index");
        }

        return new login($email, $password, $db->insert_id());
    }

}
