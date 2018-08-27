<?php
    session_start();
    if(isset($_SESSION['user']) && isset($_SESSION['user_type'])){
        header('Location: index.php');
        exit(0);
    }
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Job Portal | A job Of Your Desire</title>
    <meta name="author" content="Ashfaq Ahmad">
    <meta name="description" content="Assignment Project for the assessment of Php and MySQL Training">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>

<div class="banner">

    <div class="form-box">
        <h1 class="login-heading"> Login </h1>
        <form id="form" action="" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <span id="emaillabel" for="email"></span>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" onchange="validateInput(this)">
            </div>

            <div class="form-group">
                <span id="passwordlabel" for="password"></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" onchange="validateInput(this)">
            </div>
            <a href="signup.php">Click here For Signup</a>
            <button id="submit" name="submit" type="submit" class="btn btn-primary">Login</button>

        </form>

    </div>

</div>


<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/custom_script.js"></script>


</body>
</html>


<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = ($_POST['email']);
    $password = md5(($_POST['password']));

    $conn = include ("DB_CONNECTION.php");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $sql = "SELECT email,password,`type` from users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        $table_user = "";
        $table_password = "";

        if ($user) {

                $table_password = $user['password'];

                if ($password == $table_password) {

                    $_SESSION['user'] = $email;
                    $_SESSION['user_type'] = $user['type'];

                    header('Location: index.php');
                    exit(0);
                }
            else {
                Print '<script>alert("Incorrect Password !");</script>';
                Print '<script>window.location.assign("login.php");</script>';
            }
        } else {
            Print '<script>alert("Incorrect Username !");</script>';
            Print '<script>window.location.assign("login.php");</script>';
        }


    }

    mysqli_close($conn);
}
