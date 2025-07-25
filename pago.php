<?php
session_start();
$envio = $_SESSION['envio'] ?? null;

// Aquí podrías guardar en la base de datos que se hizo una compra
// y vaciar el carrito

// Vaciar carrito (si lo usas)
unset($_SESSION['carrito']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Pago Exitoso</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
  <div class="alert alert-success shadow">
    <h3>✅ ¡Pago exitoso!</h3>
    <p>Gracias por tu compra, <?= $envio['nombre'] ?? 'cliente' ?>.</p>
    <p>Enviaremos tu pedido a: <br><strong><?= $envio['direccion'] ?? '' ?>, <?= $envio['localidad'] ?? '' ?></strong></p>
  </div>
  <a href="index.php" class="btn btn-primary">Volver a la tienda</a>
</div>

</body>
</html>
