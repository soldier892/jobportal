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

    $conn = include ("DB_CONNECTION.php");

    if (!$conn) {
        Print '<script>alert("connection Failed");</script>';
        die("Connection failed: " . mysqli_connect_error());
    }

    else {
        $key = $_POST["ID"];
        $sql = "SELECT * FROM `job` WHERE `ID`='$key'";

        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user) {

            echo json_encode($user);
        }

        mysqli_close($conn);
    }
}