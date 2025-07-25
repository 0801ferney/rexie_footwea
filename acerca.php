<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acerca de - RIXIE FOOTWEAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-warning py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" width="32" height="32" class="me-2">
            <span class="fw-bold">OnlineShopping</span>
        </a>
        <form class="d-flex flex-grow-1 mx-3">
            <input class="form-control me-2" type="search" placeholder="Buscar productos...">
            <button class="btn btn-outline-dark"><i class="bi bi-search"></i></button>
        </form>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item mx-2"><a class="nav-link fw-semibold" href="#"><i class="bi bi-bag-fill me-1"></i> Mis compras</a></li>
            <li class="nav-item mx-2"><a class="nav-link fw-semibold" href="carrito.php"><i class="bi bi-cart-fill me-1"></i> Mi Carrito</a></li>
            <li class="nav-item dropdown mx-2">
                <a class="nav-link fw-semibold dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-gear-fill me-1"></i> Soporte</a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="acerca.php"><i class="bi bi-info-circle me-2"></i>Acerca De</a></li>
                    <li><a class="dropdown-item" href="login.php"><i class="bi bi-box-arrow-right me-2"></i>Salir</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<!-- CONTENIDO PRINCIPAL -->
<section class="container my-5">
    <h2 class="mb-4">👟 Acerca de <strong>RIXIE FOOTWEAR</strong></h2>
    <p><strong>RIXIE FOOTWEAR</strong> es una tienda online desarrollada para la venta de calzado. Ofrece una experiencia de compra moderna, segura y adaptada a las necesidades del usuario.</p>
    <p>Desde zapatos casuales hasta deportivos, todo se gestiona desde un sistema completo y personalizable.</p>

    <h4 class="mt-5">⚙️ Características del Sistema</h4>
    <ul>
        <li>Login y Registro de usuarios</li>
        <li>Gestión de productos e inventario</li>
        <li>Carrito de compras</li>
        <li>Roles de usuario</li>
        <li>Panel de administración</li>
        <li>Historial de ventas con información de envío</li>
    </ul>

    <p>Construido con <strong>PHP, JavaScript, MySQL, AJAX y Bootstrap</strong>, este sistema es rápido, escalable y seguro.</p>


    <h4 class="mt-5">📬 Contáctanos</h4>
    <p>¿Tienes preguntas o deseas una cotización? Escríbenos a <strong><a href="mailto:rixiefootwear@gmail.com">rixiefootwear@gmail.com</a></strong></p>

    <div class="card mt-3 p-4">
        <h5 class="mb-3"><i class="bi bi-envelope-fill me-2"></i>Formulario de contacto</h5>
        <form method="POST" action="enviar_mensaje.php">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Mensaje</label>
                    <textarea name="mensaje" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-warning">Enviar mensaje</button>
                </div>
            </div>
        </form>

    </div>

    <h4 class="mt-5">👤 Desarrollador</h4>
    <p><strong>Nombre:</strong> Ferney Durán</p>
    <p><strong>Usuario:</strong> rixie3002</p>
    <p><strong>Correo:</strong> rixiefootwear@gmail.com</p>

    <h6 class="text-muted mt-4">📅 Versión 1.4 - Última actualización: Julio 2025</h6> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
