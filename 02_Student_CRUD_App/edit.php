<?php
require "db.php";

$id = (int)($_GET["id"] ?? $_POST["id"] ?? 0);

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    die("Student not found.");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $age = (int)($_POST["age"] ?? 0);
    $grade = trim($_POST["grade"] ?? "");

    if ($name === "" || $age < 1 || $grade === "") {
        $error = "Please enter valid data.";
    } else {
        $stmt = $conn->prepare("UPDATE students SET name = ?, age = ?, grade = ? WHERE id = ?");
        $stmt->bind_param("sisi", $name, $age, $grade, $id);
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
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?= (int)$student["id"] ?>">
        <div>
            <input type="text" name="name"
                   value="<?= htmlspecialchars($student["name"]) ?>" required>
        </div>
        <div>
            <input type="number" name="age"
                   value="<?= (int)$student["age"] ?>" min="1" required>
        </div>
        <div>
            <input type="text" name="grade"
                   value="<?= htmlspecialchars($student["grade"]) ?>" required>
        </div>
        <button type="submit">Update Student</button>
    </form>

    <p><a href="index.php">Back</a></p>
</div>
</body>
</html>
