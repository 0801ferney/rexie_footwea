<?php
session_start();


$pdo = new PDO("sqlite:basedatos.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Eliminar usuario
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: usuarios.php");
    exit();
}

// Obtener todos los usuarios
$stmt = $pdo->query("SELECT * FROM usuarios");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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

<body class="bg-light">
    <div class="container mt-5">
        <h2>👥 Usuarios Registrados</h2>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Correo</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                    <td><?= htmlspecialchars($usuario['usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['correo']) ?></td>
                    <td>
                        <a href="?eliminar=<?= $usuario['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
