<?php
require "db.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $age = (int)($_POST["age"] ?? 0);
    $grade = trim($_POST["grade"] ?? "");

    if ($name === "" || $age < 1 || $grade === "") {
        $error = "Please enter a valid name, age, and grade.";
    } else {
        $stmt = $conn->prepare("INSERT INTO students (name, age, grade) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $age, $grade);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Add Student</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <div><input type="text" name="name" placeholder="Name" required></div>
        <div><input type="number" name="age" placeholder="Age" min="1" required></div>
        <div><input type="text" name="grade" placeholder="Grade" required></div>
        <button type="submit">Save Student</button>
    </form>

    <p><a href="index.php">Back</a></p>
</div>
</body>
</html>
