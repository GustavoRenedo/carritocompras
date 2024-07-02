<?php
// llamdo de los campos 
$nombre= $_POST['nombre'];
$correo= $_POST['correo'];
$telefono= $_POST['tema'];
$mensaje= $_POST['mensaje'];
//datos del correo
$destinatario ="informacion.apex@amg.com";
$asunto = "Contacto desde la web";

$carta = "De: $nombre \n";
$carta .="Correo: $correo \n";
$carta .= "Telefono: $telefono \n";
$carta .= "Mensaje: $mensaje ";
//enviar mensaje
 mail($destinatario, $asunto, $carta);
 header('location:enviodemensaje.php')


?>