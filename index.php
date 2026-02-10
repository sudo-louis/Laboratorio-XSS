<?php
session_start();
require 'db.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: profile.php');
        exit();
    } else {
        $error_message = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal Universitario - Laboratorio XSS</title>
</head>
<body>
    <h1>Bienvenido al Portal de la UNE</h1>

    <h2>Iniciar Sesión</h2>
    <?php if ($error_message): ?>
        <p style="color:red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="username" required><br><br>

        <label>Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <hr>

    <h2>Zona de Búsqueda (XSS Reflejado)</h2>
    <form method="GET" action="search.php">
        <input type="text" name="query" required>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>
