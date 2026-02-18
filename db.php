<?php
// db.php - Archivo de conexión a la base de datos
$host = 'localhost';
$dbname = 'lab_xss';
$user = 'root'; // Usuario por defecto de XAMPP
$pass = ''; // Contraseña por defecto de XAMPP (vacía)

try {
    // Crear una nueva instancia de PDO para conectar a MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    // Configurar PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la conexión falla, mostrar un mensaje de error y detener el script
    die("¡Error de conexión a la base de datos!: " . $e->getMessage());
}
?>
