<?php
session_start();
require_once "conexion.php";
$usuario = $_SESSION['usuario'] ?? 'Invitado';
$correo = $_SESSION['correo'] ?? $usuario . '@ejemplo.com'; // valor de respaldo


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['usuario']) || !isset($_SESSION['carrito'])) {
        header("Location: index.php");
        exit();
    }

    $usuario = $_SESSION['usuario'];
    $carrito = $_SESSION['carrito'];

    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $localidad = $_POST['localidad'] ?? '';

    $total = 0;
    $ids = implode(',', array_keys($carrito));
    $productos = $conn->query("SELECT id, precio FROM productos WHERE id IN ($ids)");

    $precios = [];
    while ($row = $productos->fetch_assoc()) {
        $precios[$row['id']] = $row['precio'];
        $total += $row['precio'] * $carrito[$row['id']];
    }

    $referencia = uniqid('ref_');
    $stmt = $conn->prepare("INSERT INTO ventas (referencia, total, nombre, direccion, localidad) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $referencia, $total, $nombre, $direccion, $localidad);
    $stmt->execute();
    $venta_id = $stmt->insert_id;

    $stmt_detalle = $conn->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad) VALUES (?, ?, ?)");
    foreach ($carrito as $producto_id => $cantidad) {
        $stmt_detalle->bind_param("iii", $venta_id, $producto_id, $cantidad);
        $stmt_detalle->execute();
    }

    unset($_SESSION['carrito']);

    // ✅ Redirige al usuario a la página principal
    echo "<script>alert('¡Compra realizada con éxito!'); window.location.href='index.php';</script>";
} else {
    header("Location: index.php");
    exit;
}
