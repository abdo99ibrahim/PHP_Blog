<?php 

try{
    // $connection ==> object
    $connection =new PDO('mysql:dbname=itidb;host=localhost','root','12345');
    // echo "conntected";
}
catch(PDOException $exception){
    // access properity using arrow 
    echo $exception->getMessage();
}

?>