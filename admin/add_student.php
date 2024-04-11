<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = validateInput($_POST["first_name"], "/^[a-zA-Z ]+$/");
    $last_name = validateInput($_POST["last_name"], "/^[a-zA-Z ]+$/");
    $reg_no = validateInput($_POST["reg_no"], "/^[a-zA-Z0-9]{10}$/");
    $year = validateInput($_POST["year"], "/^(I|II|III|IV)$/"); 
    $email = validateInput($_POST["email"], "/^\S+@\S+\.\S+$/");
    $phone_number = validateInput($_POST["phone_number"], "/^\d{10}$/");
    $address = validateInput($_POST["address"], "/^.+$/");

    $sql = "INSERT INTO student (first_name, last_name, reg_no , year, email, phone_number, address) 
            VALUES ('$first_name', '$last_name', '$reg_no', '$year', '$email', '$phone_number', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("New student record created successfully");</script>';
        echo '<script>window.location.href = "view_students.php";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}


function validateInput($input, $pattern) {
    if (preg_match($pattern, $input)) {
        return $input;
    } else {
        die("Invalid input");
    }
}


?>