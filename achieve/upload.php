<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = validateInput($_POST["first_name"], "/^[a-zA-Z ]+$/");
    $last_name = validateInput($_POST["last_name"], "/^[a-zA-Z ]+$/");
    $reg_no = validateInput($_POST["reg_no"], "/^[a-zA-Z0-9]{10}$/");
    $description = validateInput($_POST["description"], "/^.+$/");
    
    $target_dir = "uploads/";
    $file_name = basename($_FILES["certificate"]["name"]);
    $file = $target_dir . $file_name;

    // Check if file already exists
    
    // Check file size
    if ($_FILES["certificate"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        exit();
    }

    // Allow only specific file formats
    $allowed_formats = array("pdf", "doc", "docx");
    $file_extension = strtolower(pathinfo($file,PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_formats)) {
        echo "Sorry, only PDF, DOC, and DOCX files are allowed.";
        exit();
    }

    if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $file)) {
        $sql = "INSERT INTO certificate (first_name, last_name, reg_no, description, file) 
                VALUES ('$first_name', '$last_name', '$reg_no', '$description', '$file_name')";

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
