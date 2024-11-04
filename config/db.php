<?php
class MyDB
{
    private $pdo;

    public function __construct()
    {
        $host = 'database-3.chaocgea2ln5.us-east-1.rds.amazonaws.com'; // เปลี่ยนให้เป็น endpoint ของ RDS
        $dbName = 'database-3'; // ชื่อฐานข้อมูลที่ต้องการใช้
        $user = 'admin';
        $pass = 'Natta123$';

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}

// เปิดการเชื่อมต่อ
$db = new MyDB();
$connection = $db->getConnection();

?>