<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = validateInput($_POST["first_name"], "/^[a-zA-Z ]+$/");
    $last_name = validateInput($_POST["last_name"], "/^[a-zA-Z ]+$/");
    $reg_no = validateInput($_POST["reg_no"], "/^[a-zA-Z0-9]{10}$/");
    $certification = $_POST["certification"]; // No need to validate, as it's a dropdown menu
    $batch = validateInput($_POST["batch"], "/^\d{4}-\d{4}$/"); // Validate batch format (e.g., 2023-2027)
    $name = validateInput($_POST["name"], "/^.+$/");
    $start_date = $_POST["start_date"]; // No need to validate, as it's a date input
    $end_date = $_POST["end_date"]; // No need to validate, as it's a date input
    $num_days = $_POST["num_days"]; // No need to validate, as it's a number input
    $organiser = validateInput($_POST["organiser"], "/^.+$/");
    $mode = $_POST["mode"]; // No need to validate, as it's a dropdown menu
    $semester = $_POST["semester"]; // No need to validate, as it's a dropdown menu
    $awards = $_POST["awards"]; // No need to validate, it's optional
    $description = $_POST["description"];
    
    $target_dir = "uploads/";
    $file_name = basename($_FILES["certificate"]["name"]);
    $file = $target_dir . $file_name;

    // Check file size
    if ($_FILES["certificate"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow only specific file formats
    $allowed_formats = array("pdf", "doc", "docx");
    $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_formats)) {
        echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
        exit();
    }

    // Validate file name format
    if (!preg_match("/^\d{2}[A-Za-z]{2}\d[A-Za-z]\d{2}[A-Za-z0-9]{2}\.\w{3,4}$/", $file_name)) {
        echo "Sorry, the file name must be in the format 21JG1A9544.pdf.";
        exit();
    }

    $photo_names = array();
    $target_dir_photos = "uploads/photos/";

    foreach ($_FILES["photos"]["name"] as $key => $photo_name) {
        $photo_temp = $_FILES["photos"]["tmp_name"][$key];
        $photo_extension = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));
        $new_photo_name = uniqid() . "." . $photo_extension;
        $target_photo = $target_dir_photos . $new_photo_name;
        
        // Check file size
        if ($_FILES["photos"]["size"][$key] > 5000000) {
            echo "Sorry, your photo " . ($key + 1) . " is too large.";
            exit();
        }

        // Allow only specific file formats
        $allowed_photo_formats = array("jpg", "jpeg", "png");
        if (!in_array($photo_extension, $allowed_photo_formats)) {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed for photo " . ($key + 1);
            exit();
        }

        if (!move_uploaded_file($photo_temp, $target_photo)) {
            echo "Sorry, there was an error uploading your photo " . ($key + 1);
            exit();
        }

        $photo_names[] = $new_photo_name;
    }

    if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $file)) {
        $sql = "INSERT INTO certificate (first_name, last_name, reg_no, certification, batch, name, start_date, end_date, num_days, organiser, mode, semester, awards, description, file) 
                VALUES ('$first_name', '$last_name', '$reg_no', '$certification','$batch', '$name', '$start_date', '$end_date', '$num_days', '$organiser', '$mode', '$semester', '$awards', '$description', '$file_name')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Achievement added successfully");</script>';
            echo '<script>window.location.href = "view.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
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
