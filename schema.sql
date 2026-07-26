-- schema.sql
-- شغّل هذا الملف في phpMyAdmin (تبع InfinityFree) لإنشاء الجدول

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 0
);
