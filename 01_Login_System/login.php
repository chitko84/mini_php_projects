<?php
session_start();
require "db.php";

if (isset($_SESSION["username"])) {
    header("Location: dashboard.php");
    exit;
}

$message = "";

if (isset($_GET["registered"])) {
    $message = "Registration successful. You can now log in.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            session_regenerate_id(true);
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            header("Location: dashboard.php");
            exit;
        }
    }

    $message = "Invalid username or password.";
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Login</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <p>No account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
