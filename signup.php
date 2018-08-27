
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - Job Portal | A job Of Your Desire</title>
    <meta name="author" content="Ashfaq Ahmad">
    <meta name="description" content="Assignment Project for the assessment of Php and MySQL Training">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>

<div class="banner">

    <div class="form-box">

        <h1 class="login-heading"> Sign Up </h1>

        <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

            <div class="form-group">
                <span id="emaillabel" for="email"></span>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" onchange="validateInput(this)">
            </div>

            <div class="form-group">
                <span id="fnamelabel" for="fname"></span>
                <input type="text" class="form-control" id="fname" name="fname" aria-describedby="emailHelp" placeholder="Enter First Name" onchange="validateInput(this)">
            </div>

            <div class="form-group">
                <span id="lnamelabel" for="lname"></span>
                <input type="text" class="form-control" id="lname" name="lname" aria-describedby="emailHelp" placeholder="Enter Last Name" onchange="validateInput(this)">
            </div>

            <div class="form-group">
                <label class="radio-inline"><input type="radio" name="usertype" value="applicant">Job Seeker</label>
                <label class="radio-inline"><input type="radio"  name="usertype" value="employer">Employeer</label>
            </div>
            <div class="form-group">
                <span id="passwordlabel" for="password"></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" onchange="validateInput(this)">
            </div>

            <div class="form-group">
                <span id="repasswordlabel" for="re_password"></span>
                <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Confirm Password" onchange="validateInput(this)">
                <label id="okpasswordlabel" for="re_password">* Password and Confirm Password didn't match</label>

            </div>
            <a href="login.php">Click for Login If Already Signed Up!</a>
            <button id="submit" name="submit" type="submit" class="btn btn-primary">Signup</button>

        </form>

    </div>

</div>


<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/custom_script.js"></script>

<script type="text/javascript">

    function indexvalidate(indexval,value) {

        $("#"+indexval).css("border","1px solid red");
        $("#"+indexval).siblings("span").css("display","inline");
        $("#"+indexval).siblings("span").html("* "+value);

    }

</script>

</body>
</html>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST" and ($_POST['email'] and $_POST['fname'] and $_POST['lname'] and $_POST['password'] and $_POST['usertype'])) {



    $email = ($_POST['email']);
    $fname = ($_POST['fname']);
    $lname = ($_POST['lname']);
    $password = (md5($_POST['password']));
    $type = ($_POST['usertype']);

    $bool = true;
    $conn = include ("DB_CONNECTION.php");
    if (!$conn) {
        Print '<script>alert("connection Failed);</script>';
        die("Connection failed: " . mysqli_connect_error());
    }

    else {

        $user_check_query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($conn, $user_check_query);
        $user = mysqli_fetch_assoc($result);

        Print '<script>alert('.$type.');</script>';


        if ($user) { // if user exists
            Print '<script>alert("User Exists");</script>';

            if ($user['email'] === $email) {

                Print '<script>alert("Email Already Exists");</script>';

            }
        }

        else {

            $sql = "INSERT INTO `users` (`first_name`, `last_name`, `email`,`password`,`type`) VALUES ('$fname','$lname','$email','$password','$type')";

            if (mysqli_query($conn, $sql)) {

                $user_sql = "SELECT `ID` from users WHERE email='$email'";
                $result = mysqli_query($conn, $user_sql);
                $user = mysqli_fetch_assoc($result);
                $id ="";

                if ($user) {

                    $id=$user["ID"];
                }

                if ($type == "applicant"){
                    $info_sql = "INSERT INTO `applicant_details`(`highest_degree`, `school`, `major_subject`, `past_organization`, `experience`, `current_salary`, `expected_salary`, `user_id`) VALUES ('','','','','','','','$id')";
                    mysqli_query($conn, $info_sql);
                }
                elseif ($type == "employer"){
                    $info_sql = "INSERT INTO `employer_details`(`company_name`, `industry`, `contact`, `address`, `user_id`) VALUES ('','','','','$id')";
                    mysqli_query($conn, $info_sql);
                }

                Print '<script>alert("New record created successfully");</script>';
                Print '<script>window.location.assign("login.php");</script>';
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);

            }
        }

    }

    mysqli_close($conn);
}