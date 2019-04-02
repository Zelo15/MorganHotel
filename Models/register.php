<?php
require_once root . "/DB/db.php";


class register
{

    private static $table = "users";

    public $name;
    public $email;
    public $password;
    public $joined;

    public function __construct($name, $email, $password, $joined,$status)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->joined = $joined;
        $this->status = $status;
    }

    public static function register($name, $email, $password)
    {

        $db = db::get();

        if (empty($_POST["name"])
            ||empty($_POST["email"])
            ||empty($_POST["password"])
            ||empty($_POST["rePassword"])
        ){
            $errorMsg = "Minden mező kitöltöltése kötelező!";
        }else if($password != $_POST["rePassword"]){
            $errorMsg ="A két jelszó nem egyezik!";
        }else if($db->numnrows("SELECT * FROM ".self::$table." WHERE email='".$email."'")!=0){
            $errorMsg="Ez az email cím már regisztrálva van! Kérem próbálkozzon másik jelszóval!";
        }else {
            $hashedpw = md5($password);
            $insertString = 'INSERT INTO ' . self::$table . ' (name,email,password,joined,status) VALUES ("' . $name . '","' . $email . '","' . $hashedpw . '","' . date('Y-m-d') . '","1")';
            $query = $db->query($insertString);
            if (!$query) {
                $errorMsg = "Hiba a felhasználó létrehozára közben! Kérem próbálja meg később!";
            }
            session_start();
            $successMsg = "Sikeres regisztráció!";
            $_SESSION["success"] = $successMsg;
        }
        return new register($name, $email, $password,$db->insert_id());
    }

}
