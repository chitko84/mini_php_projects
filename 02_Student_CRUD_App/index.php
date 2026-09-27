<?php
require "db.php";
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student CRUD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Student Management</h1>

    <p><a href="create.php">+ Add Student</a></p>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Age</th>
            <th>Grade</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= (int)$row["id"] ?></td>
                <td><?= htmlspecialchars($row["name"]) ?></td>
                <td><?= (int)$row["age"] ?></td>
                <td><?= htmlspecialchars($row["grade"]) ?></td>
                <td class="actions">
                    <a href="edit.php?id=<?= (int)$row["id"] ?>">Edit</a>
                    <a href="delete.php?id=<?= (int)$row["id"] ?>"
                       onclick="return confirm('Delete this student?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
