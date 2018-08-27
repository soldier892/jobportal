<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = include ("DB_CONNECTION.php");
    if (!$conn) {
        Print '<script>alert("connection Failed);</script>';
        die("Connection failed: " . mysqli_connect_error());
    }

    else {
        if ($_POST['delete']) {

            $key = $_POST["ID"];
            $sql = "Delete from `job_applications`  WHERE `job_id`='$key'";

            mysqli_query($conn, $sql);


            $sql = "Delete from `job`  WHERE `ID`='$key'";

            if (mysqli_query($conn, $sql)) {

                echo"Deleted Successfully";
            }
            else {

                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                Print '<script>alert("Error In Query");</script>';

            }
        }
    }
}