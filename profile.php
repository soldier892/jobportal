
<?php

session_start();
if(!isset($_SESSION['user_type'])){
    header('Location: login.php');
    exit(0);
}

?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal | A job Of Your Desire</title>
    <meta name="author" content="Ashfaq Ahmad">
    <meta name="description" content="Assignment Project for the assessment of Php and MySQL Training">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>


    <!--    <div class="form-box">-->
    <nav class="navbar-inverse navbar-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">COEUS JobPortal</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Dashboard</a></li>
                <?php
                    if($_SESSION['user_type'] == 'employer'){
                        ?>
                        <li><a href="job_applications.php">Received Applications</a></li>
                        <?php
                    }
                    elseif ($_SESSION['user_type'] == 'applicant'){
                        ?>
                        <li><a href="job_applications.php">Applied Jobs</a></li>

                    <?php
                    }
                ?>

                <li><a class="active" href="profile.php">Profile</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php"><i class="fas white fa-sign-out-alt"></i> Logout</a></li>
            </ul>

        </div>
    </nav>
    <div class="banner-profile">
    <?php
    if (isset($_SESSION['user'])) {

        if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'employer'){

            include('emp_profile.php');
        }
        elseif (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'applicant'){

            include('jobseek_profile.php');
        }
        else{
            include('logout.php');
        }
    }
    else{

        echo "<script> window.location.assign('login.php') </script>";
    }
    ?>
</div>


<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="js/custom_script.js"></script> -->

</body>

</html> 
