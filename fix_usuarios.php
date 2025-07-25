<?php
$pdo = new PDO("sqlite:basedatos.sqlite");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    // Agregar columna 'correo' si no existe
    $resultado = $pdo->query("PRAGMA table_info(usuarios)");
    $columnas = $resultado->fetchAll(PDO::FETCH_ASSOC);
    $nombresColumnas = array_column($columnas, 'name');

    if (!in_array('correo', $nombresColumnas)) {
        $pdo->exec("ALTER TABLE usuarios ADD COLUMN correo TEXT");
        echo "✅ Columna 'correo' agregada a la tabla usuarios.";
    } else {
        echo "✅ La tabla 'usuarios' ya tiene la columna 'correo'.";
    }
} catch (PDOException $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
