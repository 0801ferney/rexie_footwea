<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario'] !== 'Rickcelys') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador - Sistema Tienda Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-brand {
            font-weight: bold;
        }
        .nav-link {
            color: #000 !important;
        }
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

<div class="container mt-5 text-center">
    <h2>Sistema Tienda Online - <strong>SOFTCODEPM</strong></h2>
    <p class="mt-4 fs-5 text-success">¡Bienvenido de Nuevo Administrador!</p>

    <h5 class="mt-4">Desarrollado con:</h5>
    <ul class="list-unstyled">
        <li>✔ HTML</li>
        <li>✔ CSS</li>
        <li>✔ Bootstrap</li>
        <li>✔ PHP</li>
        <li>✔ JavaScript</li>
        <li>✔ Ajax</li>
        <li>✔ MySQL</li>
    </ul>
</div>

<footer class="text-center mt-5 mb-3">
    <hr>
    <small>© 2024 Sistema Tienda Online - SOFTCODEPM</small>
</footer>

</body>
</html>  