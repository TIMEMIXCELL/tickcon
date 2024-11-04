<?php
// สร้างคลาส MyDB ที่สืบทอดจากคลาส SQLite3
class MyDB extends SQLite3
{
    function __construct()
    {
        // เปิดหรือสร้างฐานข้อมูลชื่อ mainDatabase.db
        $this->open('mainDatabase.db');
    }
}

// สร้างออบเจ็กต์ของ MyDB เพื่อเปิดการเชื่อมต่อฐานข้อมูล
$db = new MyDB();

// เช็คการเปิดฐานข้อมูล
if (!$db) {
    echo "Failed to open database: " . $db->lastErrorMsg();
} else {
    echo "Database opened successfully";
}

// ตัวอย่างการปิดการเชื่อมต่อฐานข้อมูล
$db->close();
?>
