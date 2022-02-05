<?php 
require "connection.php";
   $query= $connection ->prepare('Select * FROM users');

   //search by the name or email
   if(isset($_GET['search'])){
    $search=$_GET['search'];
    $query = $connection ->prepare('SELECT * FROM users WHERE username LIKE :search OR email LIKE :search');
    $query ->bindValue(':search', '%'.$search.'%',);
   }
    $query -> execute();
    // FETCH_ASSOC ==>> multi assciative array
    $users=$query ->fetchAll(PDO::FETCH_ASSOC);

    $count=count($users);?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: linear-gradient(45deg, #8410d1, #51cdbe);">
    <div class="container mt-5">
        <form method="GET">
            <div class="row offset-2">
                <div class="col">
                    <input type="text" name="search" placeholder="Search by Email or Username" class="form-control" />
                </div>
                <div class="col">
                    <input type="submit" class="btn btn-dark text-warning w-50 fw-bold" value="Search">
                </div>
            </div>

        </form>
        <table class="table table-hover bg-light">
            <thead class="bg-dark text-light">
                <tr>
                    <th scope="col">Full Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Email</th>
                    <th scope="col">Birth Date</th>
                    <th scope="col">City</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php    
            for($i=0;$i<$count;$i++){
            echo "<tr>
            <td>".$users[$i]["full_name"]."</td>
            <td>".$users[$i]["username"]."</td>
            <td>".$users[$i]['email']."</td>
            <td>".$users[$i]['birth_date']."</td>
            <td>".$users[$i]['city']."</td>
            <td><a href='edit.php?id=".$users[$i]['id']."'>Edit</a> | <a class='text-danger' href='delete.php?id=".$users[$i]['id']."'>Delete</a> </td>
            </tr>";
            }
        ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="bg-dark text-warning" colspan="2" style="text-align: center;"><?=$count?>
                        Users</td>
                    <td class="bg-warning text-light" colspan="4" style="text-align: center;"><a class="text-dark"
                            href="add.php">Add User</a></td>
                </tr>
            </tfoot>
            </tfoot>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>