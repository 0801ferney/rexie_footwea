<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST["nombre"]);
    $correo = htmlspecialchars($_POST["correo"]);
    $mensaje = htmlspecialchars($_POST["mensaje"]);

    $destinatario = "rixiefootwear@gmail.com";  // Cambia esto a tu correo real
    $asunto = "Nuevo mensaje desde el formulario";
    $contenido = "Nombre: $nombre\nCorreo: $correo\nMensaje:\n$mensaje";

    $cabeceras = "From: $correo\r\nReply-To: $correo";

    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        echo "<script>alert('Mensaje enviado con éxito.');window.history.back();</script>";
    } else {
        echo "<script>alert('Error al enviar el mensaje.');window.history.back();</script>";
    }
} else {
    echo "Acceso no autorizado.";
}
