<?php
require_once 'config.inc.php';

final class Db{
    private static $instance= NULL;
    private $host= DATABASE_HOST;
    private $db_name= DATABASE_NAME;
    private $db_username= DATABASE_USERNAME;
    private $db_password= DATABASE_PASSWORD;

    private $conn;

    private function __construct(){
        try{
        $this->conn= new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->db_username, $this->db_password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            header("Location: http://localhost:8080/project/public/error?error=ERR_DB_CONN");
        }
    } 

    public static function getDbInstance(){
        try{
        if(!self::$instance){
            self::$instance= new Db();
        }
        return self::$instance;
    }catch(PDOException $ex){
        header("Location: http://localhost:8080/project/public/error?error=ERR_DB_CONN");
    }
    }

    public function openDbConnection(){
        return $this->conn;
    }
}


?>