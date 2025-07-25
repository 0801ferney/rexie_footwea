<?php
session_start();

// Conexión a la base de datos SQLite
try {
    $pdo = new PDO("sqlite:basedatos.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear la tabla si no existe
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        usuario TEXT NOT NULL UNIQUE,
        contrasena TEXT NOT NULL,
        correo TEXT
    )");

    // Agregar columna correo si no existe (por si ya está creada la tabla sin esa columna)
    $columnas = $pdo->query("PRAGMA table_info(usuarios)")->fetchAll(PDO::FETCH_ASSOC);
    $existeCorreo = false;
    foreach ($columnas as $columna) {
        if ($columna['name'] === 'correo') {
            $existeCorreo = true;
            break;
        }
    }
    if (!$existeCorreo) {
        $pdo->exec("ALTER TABLE usuarios ADD COLUMN correo TEXT");
    }

    // Insertar un usuario de prueba solo si la tabla está vacía
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
    if ($stmt->fetchColumn() == 0) {
        $usuarioPrueba = 'ferney';
        $clavePrueba = password_hash('1234', PASSWORD_DEFAULT); // encriptada
        $correoPrueba = 'ferney@example.com';
        $pdo->prepare("INSERT INTO usuarios (usuario, contrasena, correo) VALUES (?, ?, ?)")
            ->execute([$usuarioPrueba, $clavePrueba, $correoPrueba]);
    }

} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

// Registro de nuevo usuario
if (isset($_POST['nuevo_usuario']) && isset($_POST['nueva_contrasena']) && isset($_POST['nuevo_correo'])) {
    $nuevo_usuario = trim($_POST['nuevo_usuario']);
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $nuevo_correo = trim($_POST['nuevo_correo']);

    if ($nuevo_usuario !== "" && $nueva_contrasena !== "" && $nuevo_correo !== "") {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = ?");
        $stmt->execute([$nuevo_usuario]);
        if ($stmt->fetchColumn() > 0) {
            $registro_error = "El usuario ya existe.";
        } else {
            $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, contrasena, correo) VALUES (?, ?, ?)");
            if ($stmt->execute([$nuevo_usuario, $hash, $nuevo_correo])) {
                $registro_exito = "¡Usuario registrado correctamente!";
            } else {
                $registro_error = "Error al registrar usuario.";
            }
        }
    } else {
        $registro_error = "Completa todos los campos para registrarte.";
    }
}

// Inicio de sesión
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $consulta = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $consulta->execute([$usuario]);
    $usuarioEncontrado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($usuarioEncontrado && password_verify($contrasena, $usuarioEncontrado['contrasena'])) {
        $_SESSION['usuario'] = $usuarioEncontrado['usuario'];
        $_SESSION['correo'] = $usuarioEncontrado['correo'];

        if ($usuario === "Rickcelys") {
            $_SESSION['admin'] = true;
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark text-center fw-bold" id="form-title">
                    Iniciar Sesión
                </div>
                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    <?php if (isset($registro_error)) : ?>
                        <div class="alert alert-danger"><?= $registro_error ?></div>
                    <?php endif; ?>
                    <?php if (isset($registro_exito)) : ?>
                        <div class="alert alert-success"><?= $registro_exito ?></div>
                    <?php endif; ?>

                    <!-- Formulario de Login -->
                    <form method="POST" id="login-form">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario" id="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="contrasena" id="contrasena" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Ingresar</button>
                    </form>

                    <!-- Formulario de Registro (oculto por defecto) -->
                    <!-- Formulario de Registro (oculto por defecto) -->
                    <form method="POST" id="register-form" style="display:none;">
                        <div class="mb-3">
                            <label for="nuevo_usuario" class="form-label">Nuevo usuario</label>
                            <input type="text" class="form-control" name="nuevo_usuario" id="nuevo_usuario">
                        </div>
                        <div class="mb-3">
                            <label for="nueva_contrasena" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" name="nueva_contrasena" id="nueva_contrasena">
                        </div>
                        <div class="mb-3">
                            <label for="nuevo_correo" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" name="nuevo_correo" id="nuevo_correo">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                    </form>


                    <!-- Botón para cambiar entre login y registro -->
                    <div class="text-center mt-3">
                        <button class="btn btn-link" id="toggle-form-btn" type="button">
                            ¿No tienes cuenta? Regístrate
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const toggleBtn = document.getElementById('toggle-form-btn');
    const formTitle = document.getElementById('form-title');

    toggleBtn.addEventListener('click', function() {
        if (loginForm.style.display !== 'none') {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            formTitle.textContent = 'Registrarse';
            toggleBtn.textContent = '¿Ya tienes cuenta? Inicia sesión';
        } else {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            formTitle.textContent = 'Iniciar Sesión';
            toggleBtn.textContent = '¿No tienes cuenta? Regístrate';
        }
    });

    
</script>
</body>
</html>
