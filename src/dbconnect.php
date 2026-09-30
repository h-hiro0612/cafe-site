<?php
try {
    $dsn = 'mysql:host=db;dbname=cafe_db;charset=utf8mb4';
    $pdo = new PDO($dsn, 'cafe_kumonagi', 'password');
} catch (PDOException $e) {
    echo "<p style='color: red; font-weight: bold;'>MySQL接続エラー: " . $e->getMessage() . "</p>";
}
?>