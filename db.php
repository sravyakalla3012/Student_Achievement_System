<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'student';
$port = 3306; // Port number should be an integer

$conn = mysqli_connect($host, $username, $password, $dbname, $port);

if(!$conn)
    die("Something went wrong")

//if ($conn->connect_error) {
 //   die("Connection failed: " . $conn->connect_error);
//}
?>
