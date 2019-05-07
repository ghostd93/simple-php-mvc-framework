<?php 
/**
 *  PDO Database Class
 */

class Database {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $handler;
    private $statement;
    private $error;

    public function __construct(){

        $dsn = 'mysql:host=' . $this->host
            . ';dbname=' . $this->dbname;

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        try{
            $this->handler = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }

    }

    // prepare query
    public function query($sql){

        $this->statement = $this->handler->prepare($sql);

    }

    // bind parameters
    public function bind($param, $value, $type = null){

        if(is_null($type)){
            switch($type){
                case is_int($value): $type = PDO::PARAM_INT; break;
                case is_bool($value): $type = PDO::PARAM_BOOL; break;
                case is_null($value): $type = PDO::PARAM_NULL; break;
                default: $type = PDO::PARAM_STR;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    // execute statement
    public function execute(){
        return $this->statement->execute();
    }

    // get result set
    public function resultSet(){
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    // get single row
    public function single(){
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    // row count
    public function rowCount(){
        return $this->statement->rowCount();
    }
}