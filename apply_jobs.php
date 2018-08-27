<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = include ("DB_CONNECTION.php");
    if (!$conn) {
        Print '<script>alert("connection Failed);</script>';
        die("Connection failed: " . mysqli_connect_error());
    }

    else {

        $job_id = $_POST["job_id"];
        $user_id = $_POST["user_id"];

        $sql = "INSERT INTO `job_applications`(`job_id`, `user_id`, `status`) 
                  VALUES ('$job_id','$user_id','pending')";

        if (mysqli_query($conn, $sql)) {


            $sql = "SELECT `email` from users u
                    INNER JOIN job j
                    ON j.user_id = u.ID
                    WHERE j.ID='$job_id'";

//            $sql = "SELECT `email` from users WHERE ID='$user_id'";

            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_assoc($result);

            if ($user) {
                $to = $user["email"];
            }


            $user_sql = "SELECT `first_name`, `last_name` from users WHERE `ID`='$user_id'";

            $user_result = mysqli_query($conn, $user_sql);
            $new_user = mysqli_fetch_assoc($user_result);

            if ($new_user) {
                $first_name = $new_user['first_name'];
                $last_name = $new_user['last_name'];
            }

            $subject = "Form submission";

            $message = $first_name . " " . $last_name . " Applied For a Job You Posted:" . "\n" ."Job ID : ".$job_id;

            $headers = "From: ashfaq.ahmed@coeus-solutions.de";

            mail($to,$subject,$message,$headers);


            echo true;

        } else {
            echo false;

        }
    }
    mysqli_close($conn);

}