<?php
$error_fields=array();
//edit.php?id=1 =>$_GET['id']
require "connection.php";
$id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$query= $connection -> prepare("SELECT * FROM users Where users.id=?");
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
    $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $full_name=$_POST['full_name'];
    $username=$_POST['username'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
    $confirm_password=$_POST['confirm_password'];
    $email=$_POST['email'];
    $birth_date=$_POST['date'];
    $city=$_POST['city'];

    $query= $connection ->prepare("UPDATE users SET full_name = '".$full_name."', username= '".$username."', password= '".$password."', email='".$email."', birth_date= '".$birth_date."', city= '".$city."' where users.id=".$id);
    $query ->execute([$full_name, $username,$password,$email,$birth_date,$city]);
    header("Location: list.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <style>
        body{
            height: 100vh;
            background-image: linear-gradient(45deg, #8410d1, #51cdbe);
        }
    </style>
    <title>Form</title>
</head>

<body>
<div class="container mt-3 bg-light ">
<h2 class="text-center fw-bold text-danger p-3">Edit Form</h2>
    <form  method="post">
        <input type="hidden" name="id" id="id" value="<?=(isset($users[0]['id'])) ? $users[0]['id']:''?>" />
        <div class="mb-3">
            <label class="form-label" for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name"
                value="<?= (isset($users[0]['full_name'])) ? $users[0]['full_name']:''?>" class="form-control">
            <?php if(in_array("full_name",$error_fields)) echo "<div class='form-text text-danger'>* please enter your Full Name</div>";?>
        </div>
        <div class="mb-3">
            <label class="form-label" for="username">Username:</label>
            <input type="text" id="username" name="username"
                value="<?= (isset($users[0]['username'])) ? $users[0]['username']:''?>" class="form-control">
            <?php if(in_array("username",$error_fields)) echo "<div class='form-text text-danger'>* please enter your Username</div>";?>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
                <?php if(in_array("password",$error_fields)) echo "<div class='form-text text-danger'>* please enter a password not less than 6 characters</div>";?>
            </div>
            <div class="col">
                <label class="form-label" for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                <?php if(in_array("confirm_password",$error_fields)) echo "<div class='form-text text-danger'>* Your Password doesn't match</div>";?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= (isset($users[0]['email'])) ? $users[0]['email']:''?>"
                class="form-control">
            <?php if(in_array("email",$error_fields)) echo "<div class='form-text text-danger'>* please enter valid Email</div>";?>
        </div>
        <div class="mb-3">
            <label class="form-label" for="date">Birth Date</label>
            <input type="date" id="date" name="date" value="<?=$users[0]['birth_date']?>" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label" for="city">City</label>
            <select name="city" id="city" class="form-select">
                <option selected>Choose The City</option>
                <option value="alexandria" <?=($users[0]['city']=="alexandria")?"selected":"";?>>Alexandria</option>
                <option value="giza" <?=($users[0]['city']=="aiza")?"selected":"";?>>Giza</option>
                <option value="aswan" <?=($users[0]['city']=="aswan")?"selected":"";?>>Aswan</option>
                <option value="cairo" <?=($users[0]['city']=="cairo")?"selected":"";?>>Cairo</option>
                <option value="sohag" <?=($users[0]['city']=="sohag")?"selected":"";?>>Sohag</option>
            </select>
        </div>

        <input type="submit" value="Update" class="btn btn-secondary w-50 offset-3 mb-3">
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>