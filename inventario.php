<?php
$conn = new mysqli("localhost", "root", "", "zapatos_db");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM productos WHERE id = $id");
    header("Location: inventario.php");
    exit();
}

// Agregar producto
if (isset($_POST['agregar'])) {
    $nombre = $_POST['nombre'];
    $stock = intval($_POST['stock']);
    $precio = floatval($_POST['precio']);
    $estado = $_POST['estado'];
    $categoria = $_POST['categoria'];
    $conn->query("INSERT INTO productos (nombre, stock, precio, estado, categoria) VALUES ('$nombre', $stock, $precio, '$estado', '$categoria')");
    header("Location: inventario.php");
    exit();
}

// Editar producto
if (isset($_POST['editar'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $stock = intval($_POST['stock']);
    $precio = floatval($_POST['precio']);
    $estado = $_POST['estado'];
    $categoria = $_POST['categoria'];
    $conn->query("UPDATE productos SET nombre='$nombre', stock=$stock, precio=$precio, estado='$estado', categoria='$categoria' WHERE id=$id");
    header("Location: inventario.php");
    exit();
}

// Obtener productos
$productos = $conn->query("SELECT * FROM productos ORDER BY id DESC");

// Si se va a editar, obtener los datos
$producto_editar = null;
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM productos WHERE id = $id_editar");
    if ($res->num_rows > 0) {
        $producto_editar = $res->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario | OnlineShopping</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #ffc107; }
        .table th, .table td { vertical-align: middle; }
        .btn-editar { background-color: #ffc107; color: black; }
        .btn-eliminar { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
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

<div class="container mt-4">
    <h2 class="text-center mb-4">INVENTARIO</h2>

    <!-- Formulario de Agregar / Editar -->
    <div class="card mb-4">
        <div class="card-header bg-warning fw-bold">
            <?= $producto_editar ? "Editar Producto" : "Agregar Producto" ?>
        </div>
        <div class="card-body">
            <form method="POST">
                <?php if ($producto_editar): ?>
                    <input type="hidden" name="id" value="<?= $producto_editar['id'] ?>">
                <?php endif; ?>
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required value="<?= $producto_editar['nombre'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="stock" class="form-control" placeholder="Stock" required value="<?= $producto_editar['stock'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required value="<?= $producto_editar['precio'] ?? '' ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="estado" class="form-control" placeholder="Estado" value="<?= $producto_editar['estado'] ?? 'Disponible' ?>">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="categoria" class="form-control" placeholder="Categoría" value="<?= $producto_editar['categoria'] ?? 'General' ?>">
                    </div>
                </div>
                <div class="text-end mt-3">
                    <button type="submit" name="<?= $producto_editar ? 'editar' : 'agregar' ?>" class="btn btn-success">
                        <?= $producto_editar ? 'Actualizar' : 'Agregar' ?>
                    </button>
                    <?php if ($producto_editar): ?>
                        <a href="inventario.php" class="btn btn-secondary">Cancelar</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de productos -->
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-warning">
            <tr>
                <th>Artículo</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Categoría</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $productos->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= $row['stock'] ?></td>
                <td>$<?= $row['precio'] ?></td>
                <td><?= $row['estado'] ?></td>
                <td><?= $row['categoria'] ?></td>
                <td><?= $row['fecha'] ?></td>
                <td>
                    <a href="inventario.php?editar=<?= $row['id'] ?>" class="btn btn-editar btn-sm"><i class="bi bi-pencil-square"></i></a>
                    <a href="inventario.php?eliminar=<?= $row['id'] ?>" class="btn btn-eliminar btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                        <i class="bi bi-trash3"></i>
                    </a>
                </td>
            </tr>
        <?php endwhile ?>
        </tbody>
    </table>
</div>

</body>
</html>
