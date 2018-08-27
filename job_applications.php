
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
                <li class="active"><a href="job_applications.php">Received Applications</a></li>
                <?php
            }
            elseif ($_SESSION['user_type'] == 'applicant'){
                ?>
                <li class="active"><a href="job_applications.php">Applied Jobs</a></li>

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
<div class="container">
    <?php
    if (isset($_SESSION['user'])) {

    if (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'applicant'){
    ?>
    <div class="job-container">
        <?php
        $conn = include ("DB_CONNECTION.php");
        if (!$conn) {
            Print '<script>alert("connection Failed);</script>';
            die("Connection failed: " . mysqli_connect_error());
        }
        else {
            $id = $_SESSION["user_id"];

            $job_check_query = "SELECT j.*,a.* FROM `job_applications` a 
                                INNER JOIN `job` j ON j.ID = a.job_ID 
                                INNER Join `users` u
                                ON a.user_id = u.ID
                                WHERE a.user_id='$id'
                                ORDER BY a.`ID` DESC";
            $result=mysqli_query($conn,$job_check_query);
            $exists=mysqli_num_rows($result);

            if($exists > 0){

                while($job=mysqli_fetch_assoc($result)){

                    ?>
                    <div class="main-div">
                        <div class="job-status">
                            <?php
                            if ($job["status"] != "pending"){
                                if ($job["status"] == "accepted"){
                                    ?>
                                    <b style='color: green;'>Accepted</b>
                                    <?php
                                }
                                elseif ($job["status"] == "rejected"){
                                    ?>
                                    <b style='color: red;'>Rejected</b>
                                    <?php
                                }

                            }
                            else{
                                ?>
                                <b style='color: Blue;'>Pending</b>
                                <?php
                            }

                            ?>
                        </div>
                        Company Name: <label><?php echo $job['company_name'] ?></label><br>
                        Industry Type: <label><?php echo $job['industry'] ?></label><br>
                        Designation: <label><?php echo $job['designation'] ?></label><br>
                        Offered Salary: <label><?php echo $job['offered_salary'] ?></label><br>
                        Required Experience: <label><?php echo $job['experience_required'] ?></label><br>
                        Job Shift: <label><?php echo $job['shift'] ?></label><br>
                        Job Type: <label><?php echo $job['job_type'] ?></label><br>
                        Positions: <label><?php echo $job['slots'] ?></label><br>

                    </div>

                    <br>
                    <?php
                }
            }
        }
        ?>
    </div>
    <?php
    }
    elseif (isset($_SESSION['user_type']) and $_SESSION['user_type'] == 'employer'){

        ?>
        <div class="job-container">
            <?php

            $conn = include ("DB_CONNECTION.php");
            if (!$conn) {
                Print '<script>alert("connection Failed);</script>';
                die("Connection failed: " . mysqli_connect_error());
            }
            else {
                $id = $_SESSION["user_id"];

                $job_check_query = "SELECT a.ID AS 'application_id',a.user_id as 'applicant_id',j.*,a.*,u.* FROM `job_applications` a 
                                    INNER JOIN `job` j ON j.ID = a.job_ID 
                                    INNER Join `users` u
                                    ON j.user_id = u.ID
                                    WHERE u.ID='$id'
                                    ORDER BY a.`ID` DESC";

                $result = mysqli_query($conn, $job_check_query);
                $exists = mysqli_num_rows($result);

                if ($exists > 0) {

                    while ($job = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="main-div">

                            <div class="job-status">
                                <?php
                                    if ($job["status"] != "pending"){
                                        if ($job["status"] == "accepted"){
                                            ?>
                                            <b style='color: green;'>Accepted</b>
                                            <?php
                                        }
                                        elseif ($job["status"] == "rejected"){
                                            ?>
                                            <b style='color: red;'>Rejected</b>
                                            <?php
                                        }

                                    }
                                    else{
                                        ?>

                                <a class="del-btn btn btn btn-danger" onclick="rejectApplication(this, <?php echo $job['application_id'] ?>)">Reject</a>
                                <a class="edit-btn btn btn-success" onclick="acceptApplication(this, <?php echo $job['application_id'] ?>)">Accept</a>
                               <?php
                                    }

                                    ?>
                            </div>

                            <h3>Job Details</h3>

                        Company Name: <label><?php echo $job['company_name'] ?></label><br>
                        Industry Type: <label><?php echo $job['industry'] ?></label><br>
                        Designation: <label><?php echo $job['designation'] ?></label><br>
                        Offered Salary: <label><?php echo $job['offered_salary'] ?></label><br>
                        Required Experience: <label><?php echo $job['experience_required'] ?></label><br>
                        Job Shift: <label><?php echo $job['shift'] ?></label><br>
                        Job Type: <label><?php echo $job['job_type'] ?></label><br>
                        Positions: <label><?php echo $job['slots'] ?></label><br>


                        <?php
                        $app_id = $job['applicant_id'];
                        $query = "SELECT * FROM `applicant_details` a
                                    INNER JOIN `users` u 
                                    ON a.user_id = u.ID
                                    WHERE a.`user_id` = '$app_id'";

                        $rows = mysqli_query($conn, $query);
                        $count = mysqli_num_rows($result);

                        if ($count > 0) {

                            while ($applicant = mysqli_fetch_assoc($rows)) {
                                ?>

                                <h3>Applicant Details</h3>
                                Applicant Name:
                                <label><?php echo $applicant['first_name'] . " " . $applicant['last_name'] ?></label>
                                <br>
                                Qualification: <label><?php echo $applicant['highest_degree'] ?></label><br>
                                University: <label><?php echo $applicant['school'] ?></label><br>
                                Major Subject: <label><?php echo $applicant['major_subject'] ?></label><br>
                                Past Experience: <label><?php echo $applicant['past_experience'] ?></label><br>
                                Current Salary: <label><?php echo $applicant['current_salary'] ?></label><br>
                                Expected Salary: <label><?php echo $applicant['expected_salary'] ?></label><br>
                                <?php
                            }

                        }
                        ?>
                         </div>

                            <br>
            <?php
                    }
                }
                ?>
                </div>
                <?php
            }
            mysqli_close($conn);
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
</div>

<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- <script type="text/javascript" src="js/custom_script.js"></script> -->
<script>
    function acceptApplication(element,key) {

        $.ajax({
            type:"POST",
            url: "job_application_action.php",
            data: {accept: "true", ID: key},
            success: function(result){
                result = JSON.parse(result);
                debugger;
                element.parentElement.innerHTML="<b style='color: green;'>Accepted</b>";

            }
        });
    }

    function rejectApplication(element,key) {

        var check = confirm("Are You Sure, You want to Reject this ?");

        if (check == true) {

            $.ajax({
                type:"POST",
                url: "job_application_action.php",
                data: {reject: "true", ID: key},
                success: function(result){
                    element.parentElement.innerHTML="<b style='color: red;'>Rejected</b>";

                }
            });
        }

    }

</script>
</body>

</html> 
