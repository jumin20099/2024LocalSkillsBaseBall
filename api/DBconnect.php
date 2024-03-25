<?php
$host = 'localhost';
$db_name = 'skillsbaseballpark';
$user_name = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;",$user_name,$password);
} catch (PDOException $e) {
    echo "<script>alert('데이터베이스 연결 실패 ". addslashes($e->getMessage())."');</script>";
}
?>