

<div class="container profile-div">

    <h1 class="login-heading"> Personel Information </h1>
    <?php
    ?>
    <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <?php

        $conn = include ("DB_CONNECTION.php");

        if (!$conn) {
            Print '<script>alert("connection Failed);</script>';
            die("Connection failed: " . mysqli_connect_error());
        }
        else {
            $user_email = $_SESSION['user'];
            $user_check_query = "SELECT * FROM users WHERE email='$user_email' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);

            if ($user) { // if user exists

                ?>
                <div class="col-sm-6  form-group">
                    <span id="fnamelabel" for="fname"></span>
                    <input type="text" class="form-control" id="fname" name="fname" aria-describedby="emailHelp"
                           placeholder="Enter First Name" value="<?php echo $user['first_name']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-6 form-group">
                    <span id="lnamelabel" for="lname"></span>
                    <input type="text" class="form-control" id="lname" name="lname" aria-describedby="emailHelp"
                           placeholder="Enter Last Name" value="<?php echo $user['last_name']?>" onchange="validateInput(this)">
                </div>


                <div class="col-sm-4 form-group">
                    <span id="emaillabel" for="email"></span>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                           placeholder="Enter email" value="<?php echo $user['email']?>" onchange="validateInput(this)" disabled>
                </div>

                <div class="col-sm-4 form-group">
                    <span id="passwordlabel" for="password"></span>
                    <input type="text" class="form-control" id="dob" name="dob"
                           placeholder="Enter Date Of Birth" value="<?php echo $user['dob']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-4 form-group">
                    <span id="repasswordlabel" for="re_password"></span>
                    <input type="text" class="form-control" id="age" name="age"
                           placeholder="Enter Age in Years" value="<?php echo $user['age']?>" onchange="validateInput(this)">

                </div>

                <div class="col-sm-4 form-group">
                    <span id="passwordlabel" for="password"></span>
                    <input type="text" class="form-control" id="phone" name="phone"
                           placeholder="Enter Phone #" value="<?php echo $user['phone']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-8 form-group">
                    <span id="addresslabel" for="re_password"></span>
                    <textarea class="form-control" id="address" name="address"
                              placeholder="Enter You Address" rows="5">
                            <?php if($user['address']!=null){
                                echo $user['address'];}
                            ?>
                        </textarea>

                </div>

                <button id="submit" name="submit" type="submit" class="btn btn-primary" value="personnel">Save Changes</button>

                <?php
            }

            mysqli_close($conn);
        }
        ?>

    </form>


</div>
<br><br>
<div class="container profile-div">

    <h1 class="login-heading"> Professional Information </h1>



    <form id="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <?php

        $conn = include ("DB_CONNECTION.php");

        if (!$conn) {
            Print '<script>alert("connection Failed);</script>';
            die("Connection failed: " . mysqli_connect_error());
        }
        else {
            $user_id = $_SESSION['user_id'];

            $user_check_query = "SELECT * FROM `applicant_details` WHERE `user_id`='$user_id' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);

            if ($user) { // if user exists


                ?>
                <div class="col-sm-6  form-group">
                    <span id="degreelabel" for="degree"></span>
                    <input type="text" class="form-control" id="degree" name="degree" aria-describedby="emailHelp"
                           placeholder="Enter Highest Degree" value="<?php echo $user['highest_degree']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-6 form-group">
                    <span id="schoollabel" for="school"></span>
                    <input type="text" class="form-control" id="school" name="school" aria-describedby="emailHelp"
                           placeholder="Enter University Name" value="<?php echo $user['school']?>" onchange="validateInput(this)">
                </div>


                <div class="col-sm-6 form-group">
                    <span id="majorlabel" for="major"></span>
                    <input type="text" class="form-control" id="major" name="major" aria-describedby="emailHelp"
                           placeholder="Enter Major Subject" value="<?php echo $user['major_subject']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-6 form-group">
                    <span id="organizationlabel" for="organization"></span>
                    <input type="text" class="form-control" id="organization" name="organization"
                           placeholder="Enter Previous Company" value="<?php echo $user['past_organization']?>" onchange="validateInput(this)">
                </div>


                <div class="col-sm-4 form-group">
                    <span id="experiencelabel" for="experience"></span>
                    <input type="text" class="form-control" id="experience" name="experience"
                           placeholder="Enter Experience in Years" value="<?php echo $user['experience']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-4 form-group">
                    <span id="salarylabel" for="salary"></span>
                    <input type="text" class="form-control" id="salary" name="salary" placeholder="Enter Current Salary" value="<?php echo $user['current_salary']?>" onchange="validateInput(this)">

                </div>

                <div class="col-sm-4 form-group">
                    <span id="demand_salarylabel" for="demand_salary"></span>
                    <input type="text" class="form-control" id="demand_salary" name="demand_salary" placeholder="Enter Expected Salary" value="<?php echo $user['expected_salary']?>" onchange="validateInput(this)">

                </div>

                <button id="submit" name="submit" type="submit" class="btn btn-primary" value="professional">Save Changes</button>

                <?php
            }

            mysqli_close($conn);
        }
        ?>

    </form>


</div>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = include ("DB_CONNECTION.php");

    if (!$conn) {
        Print '<script>alert("connection Failed");</script>';
        die("Connection failed: " . mysqli_connect_error());
    }
    else {
        if($_POST["submit"] == "personnel"){
            $email = $_SESSION['user'];
            $fname = ($_POST['fname']);
            $lname = ($_POST['lname']);
            $dob = ($_POST['dob']);
            $age = ($_POST['age']);
            $phone = ($_POST['phone']);
            $address = ($_POST['address']);

            $sql = "UPDATE `users` SET `first_name`='$fname',`last_name`='$lname',`dob`='$dob',`age`='$age',`email`='$email',`phone`='$phone',`address`='$address' WHERE `email`='$email'";


            if (mysqli_query($conn, $sql)) {

                Print '<script>window.location.assign("profile.php");</script>';

            } else {

                Print '<script>alert("QUERY Failed");</script>';

                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
        elseif ($_POST["submit"] == "professional"){

            $degree = ($_POST['degree']);
            $school = ($_POST['school']);
            $major = ($_POST['major']);
            $organization = ($_POST['organization']);
            $experience = ($_POST['experience']);
            $salary = ($_POST['salary']);
            $expected_salary = ($_POST['demand_salary']);


            $user_id = $_SESSION['user_id'];
            $sql = "UPDATE `applicant_details` SET `highest_degree`='$degree',`school`='$school',`major_subject`='$major',`past_organization`='$organization',`experience`='$experience',`current_salary`='$salary',`expected_salary`='$expected_salary' WHERE `user_id`='$user_id'";


            if (mysqli_query($conn, $sql)) {

                Print '<script>window.location.assign("profile.php");</script>';

            } else {

                Print '<script>alert("QUERY Failed");</script>';

                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }

        }
    }
    mysqli_close($conn);
}
?>