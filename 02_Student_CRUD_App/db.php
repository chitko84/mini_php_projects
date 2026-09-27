<?php
$conn = new mysqli("localhost", "root", "", "phase11_crud");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
