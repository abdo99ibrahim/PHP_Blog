<?php 

// validation
$error_fields=array();
if($_SERVER['REQUEST_METHOD']=='POST'){
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
    if( !$error_fields){
        // connection
        require('connection.php');
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $confirm_password=$_POST['confirm_password'];
        $email=$_POST['email'];
        $birth_date=$_POST['date'];
        $city=$_POST['city'];

        $query= $connection->prepare("insert into users(full_name,username,password,email,birth_date,city) values(?,?,?,?,?,?)");

        $query ->execute([$full_name, $username,$password,$email,$birth_date,$city]);
        header("Location: list.php");
        // mysqli_close($connection);
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
        body{
            height: 100vh;
            background-image: linear-gradient(45deg, #8410d1, #51cdbe);
        }
    </style>
    <title>Form</title>
</head>

<body>
    <div class="container mt-3 bg-light rounded">
    <h3 class="text-center fw-bold text-danger p-3">Register Form</h3>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post">

        <div class="mb-3">
            <label class="form-label" for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name"
                value="<?= (isset($_POST['full_name'])) ? $_POST['full_name']:''?>" class="form-control">
            <?php if(in_array("full_name",$error_fields)) echo "<div class='form-text text-danger'>* please enter your Full Name</div>";?>
        </div>
        <div class="mb-3">
            <label class="form-label" for="username">Username:</label>
            <input type="text" id="username" name="username"
                value="<?= (isset($_POST['username'])) ? $_POST['username']:''?>" class="form-control">
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
            <input type="email" id="email" name="email" value="<?= (isset($_POST['email'])) ? $_POST['email']:''?>" class="form-control">
            <?php if(in_array("email",$error_fields)) echo "<div class='form-text text-danger'>* please enter valid Email</div>";?>
        </div>
        <div class="mb-3">
        <label class="form-label" for="date">Birth Date</label>
        <input type="date" id="date" name="date" class="form-control">
        </div>
        <div class="mb-3">
        <label class="form-label" for="city">City</label>
        <select name="city" id="city"  class="form-select">
        <option selected>Choose The City</option>
            <option value="alexandria">Alexandria</option>
            <option value="giza">Giza</option>
            <option value="aswan">Aswan</option>
            <option value="cairo">Cairo</option>
            <option value="sohag">Sohag</option>
        </select>
        </div>

        <input type="submit" value="Register" class="btn btn-secondary w-50 offset-3 mb-3">
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>