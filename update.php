<?php
$error_fields=array();
require('connection.php');
//edit.php?id=1 =>$_GET['id']
$id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$query= $connection -> prepare("SELECT * FROM users Where id=?");
$query -> execute([$id]);
// FETCH_ASSOC ==>> multi assciative array
$users=$query ->fetchAll(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']=='POST'){
// validation
if(!(isset($_POST['full_name'])&&!empty($_POST['full_name']))){
    $error_fields[]="full_name";
}    
if(!(isset($_POST['username'])&&!empty($_POST['username']))){
    $error_fields[]="username";
}    
if(!(isset($_POST['password'])&&!empty($_POST['password'])&&strlen($_POST['password'])>5)){
    $error_fields[]="password";
}    
if(!(isset($_POST['confirm_password'])&&!empty($_POST['confirm_password'])) || $_POST['password'] != $_POST['confirm_password']){
    $error_fields[]="confirm_password";
}
if(!(isset($_POST['email'])&&!empty($_POST['email'])&&filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL))){
    $error_fields[]="email";
}    
if(!(isset($_POST['city'])&&!empty($_POST['city']))){
    $error_fields[]="city";
}    
if(!(isset($_POST['date'])&&!empty($_POST['date']))){
    $error_fields[]="date";
}
if(!$error_fields){
    $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $confirm_password=$_POST['confirm_password'];
    $email=$_POST['email'];
    $birth_date=$_POST['date'];
    $city=$_POST['city'];

    $query= $connection->prepare("UPDATE `users` SET `full_name` = ?, `username`= ?, `password`= ?, `email`=?, `date`= ?, `city`= ? WHERE `id`=?");

    $query ->execute([$full_name, $username,$password,$email,$birth_date,$city]);
    header("Location: list.php");
}
}
?>