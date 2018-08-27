<?php

if(!isset($_SESSION['user_type'])){
    header('Location: login.php');
    exit(0);
}
else{

    ?>
    <nav class="navbar navbar-inverse navbar-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">COEUS JobPortal</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Dashboard</a></li>
                <li><a href="job_applications.php">Applied Jobs</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php"><i class="fas white fa-sign-out-alt"></i> Logout</a></li>
            </ul>

        </div>
    </nav>

    <div class="container">



        <div class="job-container">
            <?php

            $conn = include ("DB_CONNECTION.php");

            if (!$conn) {
                Print '<script>alert("connection Failed);</script>';
                die("Connection failed: " . mysqli_connect_error());
            }
            else {
                $user_email = $_SESSION['user'];
                $user_id=0;
                $user_check_query = "SELECT * FROM users WHERE email='$user_email' LIMIT 1";
                $result = mysqli_query($conn, $user_check_query);
                $user = mysqli_fetch_assoc($result);



                if ($user) { // if user exists

                    if ($user['email'] === $user_email) {
                        $user_id = $user['ID'];
                    }
                }

                $_SESSION["user_id"] = $user_id;

                $job_check_query = "SELECT * FROM job WHERE 
                                    ID NOT IN (
                                    SELECT j.`ID` FROM `job_applications` a 
                                    Inner JOIN `job` j ON a.job_id = j.ID
                                    WHERE a.user_id='$user_id')";

                $result=mysqli_query($conn,$job_check_query);
                $exists=mysqli_num_rows($result);

                if($exists > 0){

                    while($job=mysqli_fetch_assoc($result)){
                        $ID=$_SESSION['U_id'];
                        ?>
                        <div class="main-div">
                            <div class="job-status">
                                <a class="edit-btn btn btn-success" onclick="applyJob(this,<?php echo $job['ID'] ?>,<?php echo $user_id ?>)">Apply For Job</a>
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
    </div>

    <?php

if($_SERVER["REQUEST_METHOD"] == "POST") {

        $company = ($_POST['company']);
        $industry = ($_POST['industry']);
        $designation = ($_POST['designation']);
        $salary = ($_POST['salary']);
        $experience = ($_POST['experience']);
        $shift = ($_POST['shift']);
        $jobtype = ($_POST['jobtype']);
        $positions = ($_POST['positions']);
        $key = ($_POST['jobid']);

        $conn = include ("DB_CONNECTION.php");

        if (!$conn) {
            Print '<script>alert("connection Failed);</script>';
            die("Connection failed: " . mysqli_connect_error());
        }

        else {
            if ($_POST['submit'] == "edit") {


                $sql = "UPDATE `job` SET `company_name`='$company',`industry`='$industry',`designation`='$designation',`offered_salary`='$salary',`experience_required`='$experience',`shift`='$shift',`job_type`='$tybtype',`slots`='$positions' WHERE `ID`='$key'";
                if (mysqli_query($conn, $sql)) {

                    Print '<script>window.location.assign("index.php");</script>';
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);

                    Print '<script>alert("Error In Query");</script>';

                }
            } else {

                $sql = "INSERT INTO `job`(`company_name`, `industry`, `designation`, `offered_salary`, `experience_required`, `shift`, `job_type`, `slots`,`user_id`) 
                  VALUES ('$company','$industry','$designation','$salary','$experience','$shift','$jobtype','$positions','$user_id')";

                if (mysqli_query($conn, $sql)) {

                    Print '<script>window.location.assign("index.php");</script>';
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);

                    Print '<script>alert("Error In Query");</script>';


                }
            }
            mysqli_close($conn);
        }
    }

}


