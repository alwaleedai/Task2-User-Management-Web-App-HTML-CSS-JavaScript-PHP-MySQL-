<?php
// db.example.php - نسخة وهمية للعرض على GitHub
// انسخه إلى db.php وحط بياناتك الحقيقية (لا ترفع db.php الحقيقي على GitHub)

$host = "sqlXXX.infinityfree.com";
$db_user = "if0_00000000";
$db_pass = "REPLACE_WITH_YOUR_PASSWORD";
$db_name = "if0_00000000_dbname";

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
?>
