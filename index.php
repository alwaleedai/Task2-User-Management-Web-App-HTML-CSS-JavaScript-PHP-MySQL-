<?php
require "db.php";

// معالجة إرسال الفورم (إضافة سجل جديد)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $name = trim($_POST["name"]);
    $age  = intval($_POST["age"]);

    if ($name !== "" && $age > 0) {
        $stmt = $conn->prepare("INSERT INTO users (name, age, status) VALUES (?, ?, 0)");
        $stmt->bind_param("si", $name, $age);
        $stmt->execute();
        $stmt->close();
    }

    // إعادة توجيه لتفادي إعادة الإرسال عند تحديث الصفحة
    header("Location: index.php");
    exit;
}

// جلب كل السجلات لعرضها في الجدول
$result = $conn->query("SELECT id, name, age, status FROM users ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Users Form</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>إضافة مستخدم جديد</h2>

    <form method="POST" action="index.php" class="user-form">
        <label>Name: <input type="text" name="name" required></label>
        <label>Age: <input type="number" name="age" required></label>
        <button type="submit" name="submit">Submit</button>
    </form>

    <h2>قائمة المستخدمين</h2>
    <table id="usersTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr id="row-<?php echo $row['id']; ?>">
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td class="status-cell"><?php echo $row['status']; ?></td>
                    <td>
                        <button class="toggle-btn" data-id="<?php echo $row['id']; ?>">
                            Toggle
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="script.js"></script>
</body>
</html>
