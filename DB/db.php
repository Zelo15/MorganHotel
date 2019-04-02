<?php
/*
 *
 * DB Manager Class
 *
 * */
class db{
    private static $host ="127.0.0.1:3306";
    private static $username ="root";
    private static $password ="";
    private static $database ="morgan";
    private static $coding ="utf8";
    private static $instance = null;
    private $connection ="";

    /**
     * Constructor
     */
    public function __construct(){
        $this->connection = mysqli_connect(self::$host,self::$username,self::$password);
        if (mysqli_connect_errno($this->connection)){
            die("Could not connect mysql database");
        }else{
            mysqli_select_db($this->connection,self::$database);
            mysqli_set_charset($this->connection,self::$coding);
        }
    }
    /*
     * singleton = egyszerre csak egy példány létezhet
     * */

    public static function get(){
        if (is_null(self::$instance)){
            self::$instance = new db;
        }
        return self::$instance;
    }
    /*
     * osztály szintű, mindennek az alapja
     * Usage $DB = DB::get();
     * $DB->query("SELECT *FROM 'USER'");
     *
     * */

    public function query($queryString){
        $result = mysqli_query($this->connection,$queryString);
        if(!$result){
            $this->error(mysqli_error($this->connection,$queryString));
        }
        return $result;
    }
    public function insert_id(){
        return mysqli_insert_id($this->connection);
    }
    public function numnrows($queryString){ //sorok számát adja vissza
        $result = $this->query($queryString);
        return mysqli_num_rows($result);
    }
    public function getRow($queryString){ // egy adat sor visszanyerésére alkalmas
        $result = $this->query($queryString);
        return mysqli_fetch_assoc($result);
    }
    public function getArray($queryString){ // listázáshoz használható
        $rows = array(); // a tömbb minden sora egy asszociatív tömbb
        $result = $this->query($queryString);
        while($row = mysqli_fetch_assoc($result)){
            $rows[]=$row;
        }
        return $rows;
    }
    public function error($error,$query){
        die('SQL err'.$error.'<br> with the following query: '.$query);
    }
    public function escape($string){ // sql injection ellen véd
        return mysqli_real_escape_string($this->connection,$string);
    }
}

?>