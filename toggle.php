<?php
require "db.php";
header("Content-Type: application/json");

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

if ($id <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid ID"]);
    exit;
}

// جلب الحالة الحالية
$stmt = $conn->prepare("SELECT status FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

if (!$row) {
    echo json_encode(["success" => false, "message" => "Record not found"]);
    exit;
}

// عكس القيمة (0 <-> 1)
$newStatus = $row["status"] == 1 ? 0 : 1;

$update = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
$update->bind_param("ii", $newStatus, $id);
$update->execute();
$update->close();

echo json_encode(["success" => true, "new_status" => $newStatus]);
