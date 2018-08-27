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
          <li><a href="job_applications.php">Received Applications</a></li>
          <li><a href="profile.php">Profile</a></li>
        </ul>

          <ul class="nav navbar-nav navbar-right">
              <li><a href="logout.php"><i class="fas white fa-sign-out-alt"></i> Logout</a></li>
          </ul>

      </div>
    </nav>

    <div class="container">

      <!-- Trigger the modal with a button -->
      <a type="button" class="new-button btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">+ Add New Job</a>
      <!-- Modal -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title text-center">Add New Job</h4>
            </div>
            <div class="modal-body">

            <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <input type="text" id="jobid" name="jobid" hidden>
                        <div class="form-group">
                            <span id="companylabel" for="company"></span>
                            <input type="text" class="form-control" id="company" name="company" aria-describedby="emailHelp" placeholder="Enter Company Name" onchange="validateInput(this)">
                        </div>
            
                        <div class="form-group">
                            <span id="industrylabel" for="industry"></span>
                            <input type="text" class="form-control" id="industry" name="industry" aria-describedby="emailHelp" placeholder="Enter Industry Name" onchange="validateInput(this)">
                        </div>

                        <div class="form-group">
                        <span id="designationlabel" for="designation"></span>
                        <input type="text" class="form-control" id="designation" name="designation" aria-describedby="emailHelp" placeholder="Enter Designation" onchange="validateInput(this)">
                    </div>
        
                          <div class="form-group">
                              <span id="salarylabel" for="salary"></span>
                              <input type="text" class="form-control" id="salary" name="salary" aria-describedby="emailHelp" placeholder="Enter Salary Offer" onchange="validateInput(this)">
                          </div>

                          <div class="form-group">
                          <span id="experiencelabel" for="experience"></span>
                          <input type="text" class="form-control" id="experience" name="experience" aria-describedby="emailHelp" placeholder="Enter Required Experience" onchange="validateInput(this)">
                      </div>
          
                      <div class="form-group">
                          <span id="shiftlabel" for="shift"></span>
                          <input type="text" class="form-control" id="shift" name="shift" aria-describedby="emailHelp" placeholder="Enter Job Shift   e.g. Day/Evening/Night" onchange="validateInput(this)">
                      </div>

                      <div class="form-group">
                      <span id="jobtypelabel" for="jobtype"></span>
                      <input type="text" class="form-control" id="jobtype" name="jobtype" aria-describedby="emailHelp" placeholder="Enter Job Type   e.g. Permanent/Cotractual" onchange="validateInput(this)">
                  </div>

                  <div class="form-group">
                      <span id="positionslabel" for="positions"></span>
                      <input type="text" class="form-control" id="positions" name="positions" aria-describedby="emailHelp" placeholder="Enter # of Positions" onchange="validateInput(this)">
                  </div>
            
                        <button id="submit" name="submit" type="submit" class="btn btn-primary">Add Job</button>
            
                    </form>
            </div>
            
          </div>
        </div>
      </div>

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
              $job_check_query = "SELECT * FROM `job` WHERE `user_id`='$user_id' ORDER BY `ID` DESC";
              $result=mysqli_query($conn,$job_check_query);
              $exists=mysqli_num_rows($result);
              if($exists > 0){
                  
                  while($job=mysqli_fetch_assoc($result)){
                //    print_r($job);
                //    echo "<br>";
                    ?>
                <div class="main-div">
                    <a class="del-btn btn btn btn-danger" onclick="delJob(<?php echo $job['ID'] ?>)" >Delete</a>
                    <a class="edit-btn btn btn-success" onclick="editJob(<?php echo $job['ID'] ?>)">Edit</a>
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


