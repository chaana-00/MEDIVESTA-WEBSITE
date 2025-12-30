<?php
$host = "localhost";
$user = "root";
$pass = "1234";
$db   = "medivesta_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
