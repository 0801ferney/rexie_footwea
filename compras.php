<?php
session_start();
require_once "conexion.php";

// Eliminar compra (primero eliminar detalles)
if (isset($_GET['eliminar'])) {
    $idVenta = intval($_GET['eliminar']);

    try {
        // Eliminar detalles relacionados
        $stmt = $pdo->prepare("DELETE FROM detalle_ventas WHERE venta_id = ?");
        $stmt->execute([$idVenta]);

        // Luego eliminar la venta
        $stmt = $pdo->prepare("DELETE FROM ventas WHERE id = ?");
        $stmt->execute([$idVenta]);

        header("Location: compras.php");
        exit();
    } catch (PDOException $e) {
        die("Error al eliminar la compra: " . $e->getMessage());
    }
}

// Cambiar estado de la compra
if (isset($_GET['cambiar_estado'])) {
    $idVenta = intval($_GET['cambiar_estado']);
    $nuevoEstado = $_GET['nuevo_estado'] ?? 'Pendiente';

    $stmt = $pdo->prepare("UPDATE ventas SET status = ? WHERE id = ?");
    $stmt->execute([$nuevoEstado, $idVenta]);

    header("Location: compras.php");
    exit();
}

// Obtener todas las ventas
try {
    $stmt = $pdo->query("SELECT * FROM ventas ORDER BY fecha DESC");
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener ventas: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-warning bg-warning">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🛒 OnlineShopping</a>
        <form class="d-flex mx-auto" style="width: 40%;">
            <input class="form-control me-2" type="search" placeholder="Buscar productos, marcas y más..." aria-label="Buscar">
            <button class="btn btn-dark" type="submit">🔍</button>
        </form>
        <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="inventario.php">📦 Inventario</a></li>
        <li class="nav-item"><a class="nav-link" href="compras.php">🛍 Compras</a></li>
        <li class="nav-item"><a class="nav-link" href="usuario.php">👥 Usuarios</a></li>
        

        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="mb-4">Historial de Compras</h2>

    <?php if (count($ventas) === 0): ?>
        <div class="alert alert-info">No hay compras registradas.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover bg-white shadow">
            <thead class="table-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Referencia (Correo)</th>
                    <th>Información de Envío</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr class="<?= $venta['status'] === 'Completado' ? 'table-success' : '' ?>">
                        <td><?= htmlspecialchars($venta['fecha']) ?></td>
                        <td>$<?= number_format($venta['total'], 2) ?></td>
                        <td><?= htmlspecialchars($venta['status']) ?></td>
                        <td><?= htmlspecialchars($venta['correo'] ?? 'Sin correo') ?></td>
                        <td>
                            <?= "Envío a: " . 
                                htmlspecialchars($venta['nombre']) . ", " . 
                                htmlspecialchars($venta['direccion']) . ", " . 
                                htmlspecialchars($venta['localidad']) ?>
                        </td>
                        <td>
                            <?php if ($venta['status'] === 'Pendiente'): ?>
                                <a href="?cambiar_estado=<?= $venta['id'] ?>&nuevo_estado=Completado"
                                   class="btn btn-success btn-sm mb-1"
                                   onclick="return confirm('¿Marcar como completado?')">
                                   ✅ Completar
                                </a>
                            <?php else: ?>
                                <span class="text-success d-block mb-1">✅ Completado</span>
                            <?php endif; ?>
                            
                            <a href="?eliminar=<?= $venta['id'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Estás seguro de eliminar esta compra?')">
                               🗑 Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="admin.php" class="btn btn-primary">Volver a la tienda</a>
</div>

</body>
</html>
