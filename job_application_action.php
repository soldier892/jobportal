<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = include ("DB_CONNECTION.php");

    if (!$conn) {

        Print '<script>alert("connection Failed);</script>';
        die("Connection failed: " . mysqli_connect_error());
    }

    else {

        if ($_POST["accept"]) {

            $job_id = $_POST["ID"];

            $sql = "UPDATE `job_applications` SET `status`='accepted' WHERE `ID`='$job_id'";

            if (mysqli_query($conn, $sql)) {
                echo true;
            }

        }
        elseif ($_POST["reject"]) {

            $job_id = $_POST["ID"];

            $sql = "UPDATE `job_applications` SET `status`='rejected' WHERE `ID`='$job_id'";

            if (mysqli_query($conn, $sql)) {
                echo true;
            }

        }
        else{
            echo "Error";
        }
    }
    mysqli_close($conn);

}