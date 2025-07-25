<?php
session_start();
require_once "conexion.php";

// Añadir al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_carrito'])) {
    $id_producto = $_POST['id_producto'];
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }
    if (!isset($_SESSION['carrito'][$id_producto])) {
        $_SESSION['carrito'][$id_producto] = 1;
    } else {
        $_SESSION['carrito'][$id_producto]++;
    }
    header("Location: index.php"); // Redireccionar para evitar reenvío del formulario
    exit();
}

$productos = $conn->query("SELECT * FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Online Mejorada</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .card:hover { transform: scale(1.02); transition: 0.3s; }
        .btn-carrito, .btn-fav { margin-top: 10px; }
        .chat-boton { position: fixed; bottom: 20px; right: 20px; z-index: 999; }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-warning py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Logo" width="32" height="32" class="me-2">
            <span class="fw-bold">OnlineShopping</span>
        </a>
        <form class="d-flex flex-grow-1 mx-3" role="search">
            <input class="form-control me-2" type="search" placeholder="Buscar productos..." aria-label="Buscar">
            <button class="btn btn-outline-dark" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
            <li class="nav-item mx-2"><a class="nav-link fw-semibold" href="#"><i class="bi bi-bag-fill me-1"></i> Mis compras</a></li>
            <li class="nav-item mx-2"><a class="nav-link fw-semibold" href="carrito.php"><i class="bi bi-cart-fill me-1"></i> Mi Carrito</a></li>
            <li class="nav-item dropdown mx-2">
                <a class="nav-link fw-semibold dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-gear-fill me-1"></i> Soporte</a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="acerca.php"><i class="bi bi-info-circle me-2"></i>Acerca De</a></li>
                    <li><a class="dropdown-item" href="login.php"><i class="bi bi-box-arrow-right me-2"></i>Salir</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center mb-4">Tienda Online</h2>

    <!-- Filtros -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-outline-primary mx-1 filtro-btn" data-categoria="todos">Todos</button>
            <button class="btn btn-outline-primary mx-1 filtro-btn" data-categoria="muebles">Muebles</button>
            <button class="btn btn-outline-primary mx-1 filtro-btn" data-categoria="dormitorio">Dormitorio</button>
            <button class="btn btn-outline-primary mx-1 filtro-btn" data-categoria="accesorios">Accesorios</button>
        </div>
        <div>
            <select id="ordenar" class="form-select w-auto">
                <option value="default">Ordenar por</option>
                <option value="precio_asc">Precio: Menor a mayor</option>
                <option value="precio_desc">Precio: Mayor a menor</option>
                <option value="nombre">Nombre</option>
            </select>
        </div>
    </div>

    <div class="row" id="productos-lista">
        <?php while($producto = $productos->fetch_assoc()): ?>
        <div class="col-md-4 mb-4 producto" data-categoria="<?= strtolower($producto['categoria']) ?>" data-precio="<?= $producto['precio'] ?>" data-nombre="<?= strtolower($producto['nombre']) ?>">
            <div class="card text-center shadow-sm">
                <img src="<?= $producto['imagen'] ?: 'https://cdn-icons-png.flaticon.com/512/263/263142.png' ?>" class="card-img-top p-4" alt="Producto">
                <div class="card-body">
                    <h5 class="card-title fw-semibold"><?= htmlspecialchars($producto['nombre']) ?></h5>
                    <p>Stock: <?= $producto['stock'] ?></p>
                    <p>Status: <span class="text-<?= $producto['estado'] === 'Disponible' ? 'success' : 'danger' ?>"><?= $producto['estado'] ?></span></p>
                    <p>
                        <?php if (!empty($producto['precio_anterior'])): ?>
                            <s>$<?= $producto['precio_anterior'] ?></s>
                        <?php endif; ?>
                        <span class="text-success fw-bold">$<?= $producto['precio'] ?></span>
                    </p>
                    <p>⭐⭐⭐⭐☆</p>
                    <form method="POST">
                        <input type="hidden" name="id_producto" value="<?= $producto['id'] ?>">
                        <button type="submit" name="agregar_carrito" class="btn btn-carrito btn-primary w-100">Añadir al carrito</button>
                    </form>
                    <button class="btn btn-fav btn-outline-danger w-100">❤️ Añadir a Favoritos</button>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="chat-boton">
    <button class="btn btn-success rounded-circle shadow" title="Soporte"><i class="bi bi-chat-dots-fill"></i></button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll(".filtro-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const cat = btn.dataset.categoria;
            document.querySelectorAll(".producto").forEach(prod => {
                prod.style.display = (cat === "todos" || prod.dataset.categoria === cat) ? "block" : "none";
            });
        });
    });

    document.getElementById("ordenar").addEventListener("change", (event) => {
        const lista = document.getElementById("productos-lista");
        const productos = Array.from(lista.querySelectorAll(".producto"));
        const orden = event.target.value;

        productos.sort((a, b) => {
            if (orden === "precio_asc") return a.dataset.precio - b.dataset.precio;
            if (orden === "precio_desc") return b.dataset.precio - a.dataset.precio;
            if (orden === "nombre") return a.dataset.nombre.localeCompare(b.dataset.nombre);
            return 0;
        });

        productos.forEach(p => lista.appendChild(p));
    });
</script>
</body>
</html> 

