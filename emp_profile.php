

<div class="container profile-div">

    <h1 class="login-heading"> Personel Information </h1>

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
            $user_check_query = "SELECT * FROM `employer_details` WHERE `user_id`='$user_id' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);

            if ($user) { // if user exists


                ?>
                <div class="col-sm-6  form-group">
                    <span id="company_namelabel" for="company_name"></span>
                    <input type="text" class="form-control" id="company_name" name="company_name" aria-describedby="emailHelp"
                           placeholder="Enter First Name" value="<?php echo $user['company_name']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-6 form-group">
                    <span id="industrylabel" for="industry"></span>
                    <input type="text" class="form-control" id="industry" name="industry" aria-describedby="emailHelp"
                           placeholder="Enter Last Name" value="<?php echo $user['industry']?>" onchange="validateInput(this)">
                </div>


                <div class="col-sm-4 form-group">
                    <span id="pro_phonelabel" for="pro_phone"></span>
                    <input type="text" class="form-control" id="pro_phone" name="pro_phone"
                           placeholder="Enter Phone #" value="<?php echo $user['contact']?>" onchange="validateInput(this)">
                </div>

                <div class="col-sm-8 form-group">
                    <span id="pro_addresslabel" for="pro_address"></span>
                    <textarea class="form-control" id="pro_address" name="pro_address"
                              placeholder="Enter You Address" rows="5">
                            <?php if($user['address']!=null){
                                echo $user['address'];}
                            ?>
                        </textarea>

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

            $company_name = ($_POST['company_name']);
            $industry = ($_POST['industry']);
            $pro_phone = ($_POST['pro_phone']);
            $pro_address = ($_POST['pro_address']);

            $user_id = $_SESSION['user_id'];
            $sql = "UPDATE `employer_details` SET `company_name`='$company_name',`industry`='$industry',`contact`='$pro_phone',`address`='$pro_address' WHERE `user_id`='$user_id'";


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