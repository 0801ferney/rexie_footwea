<?php
$conn = new mysqli("localhost", "root", "", "zapatos_db");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


try {
    $pdo = new PDO("mysql:host=localhost;dbname=zapatos_db;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
