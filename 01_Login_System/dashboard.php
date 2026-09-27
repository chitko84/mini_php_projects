<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Dashboard</h1>
    <p>Welcome, <strong><?= htmlspecialchars($_SESSION["username"]) ?></strong>.</p>
    <p>Your login session is active.</p>
    <p><a href="logout.php">Logout</a></p>
</div>
</body>
</html>
