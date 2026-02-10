<?php
session_start();
require 'db.php'; // Incluimos el archivo de conexión

$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar el usuario (vulnerable a SQLi, pero nos enfocamos en XSS)
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
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; line-height: 1.6; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #0056b3; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background-color: #0056b3; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #004494; }
        .error { color: #d9534f; }
        .vulnerable-box { margin-top: 30px; padding: 15px; border: 1px solid #ddd; border-left: 5px solid #f0ad4e; background-color: #fff8e1; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido al Portal de la UNE</h1>
        <p>Este es un entorno de aprendizaje controlado para estudiar vulnerabilidades web.</p>

        <h2>Iniciar Sesión</h2>
        <?php if ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Entrar</button>
        </form>

        <div class="vulnerable-box">
            <h2> Zeta de Búsqueda (Vulnerable a XSS Reflejado)</h2>
            <p>Usa esta barra de búsqueda para encontrar cursos. El atacante puede manipular los resultados aquí.</p>
            <form method="GET" action="search.php">
                <div class="form-group">
                    <label for="search_query">Buscar:</label>
                    <input type="text" id="search_query" name="query" required>
                </div>
                <button type="submit">Buscar Curso</button>
            </form>

            <p>Ejemplo de ataque: <code>?query=&lt;script&gt;alert('XSS')&lt;/script&gt;</code></p>
        </div>
    </div>
</body>
</html>

