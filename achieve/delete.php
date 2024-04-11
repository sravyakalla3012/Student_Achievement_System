<?php
include 'db.php'; // Make sure to include your database connection

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM certificate WHERE id = $id";
    $result = $conn->query($query);

    if ($result === TRUE) {
        echo "success";
    } else {
        echo "error";
    }

    $conn->close();
}
?>