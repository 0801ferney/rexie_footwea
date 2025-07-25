<?php
session_start();
require_once "conexion.php"; // Asegúrate que este archivo conecta con tu DB

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$correo = isset($_SESSION['correo']) ? $_SESSION['correo'] : $usuario . '@gmail.com';
$fecha = date('d-m-Y');

$carrito = $_SESSION['carrito'] ?? [];
$total = 0;

// Obtener datos de productos del carrito
$productos_carrito = [];
if (!empty($carrito)) {
    $ids = implode(',', array_keys($carrito));
    $query = $conn->query("SELECT * FROM productos WHERE id IN ($ids)");
    while ($row = $query->fetch_assoc()) {
        $id = $row['id'];
        $row['cantidad'] = $carrito[$id];
        $productos_carrito[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-warning py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Logo" width="32" height="32" class="me-2">
            <span class="fw-bold">OnlineShopping</span>
        </a>
        <span class="ms-auto fw-semibold"><i class="bi bi-cart-fill me-1"></i> Mi Carrito</span>
    </div>
</nav>

<div class="container mt-4">
    <div class="mb-3">
        <strong>Usuario:</strong> <?= htmlspecialchars($usuario) ?><br>
        <strong>Correo:</strong> <?= htmlspecialchars($correo) ?><br>
        <strong>Fecha:</strong> <?= $fecha ?>
    </div>

    <h4 class="text-center mb-4">AGREGAR AL CARRITO</h4>
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Artículo</th>
                    <th>Cant</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($productos_carrito)): ?>
                    <tr><td colspan="5">No hay productos en el carrito.</td></tr>
                <?php else: ?>
                    <?php foreach ($productos_carrito as $index => $producto): 
                        $subtotal = $producto['precio'] * $producto['cantidad'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= $producto['cantidad'] ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <h5>Total: $<?= number_format($total, 2) ?></h5>
    </div>

    <a href="carrito.php" class="btn btn-primary">Guardar Registro</a>
<a href="pago.php" class="btn btn-success">Pagar Ahora</a>

</div>

<footer class="text-center mt-5 mb-3 text-muted">
    © 2024 Sistema Tienda Online | <a href="#">SOFTCODEPM</a>
</footer>

<script>
    document.getElementById('guardar-registro').onclick = function () {
        alert('¡Registro guardado! Aquí puedes agregar la lógica para guardar en la base de datos.');
    };
</script>
</body>
</html>

