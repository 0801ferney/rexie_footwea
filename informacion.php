<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Información de Envío</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4">Información de Envío</h2>
  <form method="post" action="guardar_direccion.php" class="card p-4 shadow">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre quien recibe:</label>
      <input type="text" class="form-control" name="nombre" id="nombre" required>
    </div>

    <div class="mb-3">
      <label for="direccion" class="form-label">Dirección:</label>
      <input type="text" class="form-control" name="direccion" id="direccion" required>
    </div>

    <div class="mb-3">
      <label for="localidad" class="form-label">Localidad:</label>
      <input type="text" class="form-control" name="localidad" id="localidad" required>
    </div>

    <button href="index.php" type="submit" class="btn btn-success">Guardar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</div>

</body>
</html>
