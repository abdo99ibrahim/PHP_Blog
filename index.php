<?php
class Database{
    private $database = 'itidb' ;
    private $root = 'root';
    private $password = '12345';
    private function connect (){
        try{
            $connection = new PDO("mysql:dbname=$this->database;host=localhost",
                $this->root,$this->password);
            return $connection;
        }
        catch (PDOException $exception){
            echo $exception->getMessage();
        }
        return false;
    }
    public function insert($table,$full_name,$username,$pass,$email,$birth_date,$city){
        $myConnection=$this->connect();
        $query=$myConnection->prepare("insert into $table (full_name,username,password,email,birth_date,city) values(?,?,?,?,?,?);");
        $query->execute([$full_name,$username,$pass,$email,$birth_date,$city]);
        return $this->select($table);
    }
    public function select($table){
        $Connection =$this->connect();
        $query =$Connection->prepare("select * from $table");
        $query->execute();
        $output =$query->fetchAll(PDO::FETCH_ASSOC);
        return $output;
    }
    public function selectByID($table,$id){
        $Connection =$this->connect();
        $query =$Connection->prepare("select * from $table where id=$id");
        $query->execute();
        $output =$query->fetchAll(PDO::FETCH_ASSOC);
        return $output;
    }

    public function update($table,$id,$full_name,$username,$pass,$email,$birth_date,$city){
        $Connection =$this->connect();
        $query = $Connection->prepare("update $table set full_name=? , username=? , password=? , email=? ,birth_date=? , city=?  where id=?");
        $query->execute([$id,$full_name,$username,$pass,$email,$birth_date,$city]);
        return $this->select($table);
    }
    public function delete ($table,$id){
        $Connection = $this->connect();
        $query = $Connection->prepare("delete from $table where id=?");
        $query->execute([$id]);
        return $this->select($table);
    }

}

$obj = new Database();

$tableName ='users';
$columnsName =['full_name','username','password','email','birth_date','city'];

$select = $obj->select($tableName);
$selectByID = $obj->selectByID($tableName,5);

$insert=$obj->insert($tableName,"Abdelrahman_Ibrahim","Abdo2299","A#ssa4dsa","abdo@yahoo.com","2008-02-01","cairo");
$delete = $obj->delete($tableName,2);
$update = $obj->update($tableName,29,"Abdelrahman_Ibrahim","Abdo20000299","A#ssa4dsa","abdo23@yahoo.com","2008-02-01","alex");

$obj->delete($tableName,22);

$obj->update($tableName,8,"gamal_eldin","gamal2020","ds#ds~","gmal23@yahoo.com","1-3-2020","sohag");

$outAfterInsert = $obj->select($tableName);

echo "<pre>";
var_dump($select);
echo "<br>";
var_dump($selectByID);
echo "<br>";
var_dump($insert);
echo "<br>";
var_dump($delete);
echo "<br>";
var_dump($update);
echo "</pre>";