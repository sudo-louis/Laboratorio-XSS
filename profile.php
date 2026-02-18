
<?php
session_start();
require 'db.php'; // Incluimos la conexión a la BD

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
$username = $_SESSION['username'];

// Procesar el envío de un nuevo comentario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment_text = $_POST['comment'];
    // VULNERABILIDAD: XSS ALMACENADO
    // El texto del comentario se inserta directamente en la BD sin sanitizar.
    $stmt = $pdo->prepare("INSERT INTO comments (username, comment_text) VALUES (?, ?)");
    $stmt->execute([$username, $comment_text]);
    // Redirigir para evitar el reenvío del formulario al actualizar la página
    header("Location: profile.php");
    exit();
}

// Obtener todos los comentarios de la base de datos para mostrarlos
$stmt = $pdo->query("SELECT username, comment_text, created_at FROM comments ORDER BY created_at DESC");
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; line-height: 1.6; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1, h2 { color: #0056b3; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        textarea { width: 100%; padding: 8px; box-sizing: border-box; min-height: 100px; }
        button { background-color: #28a745; color: #fff; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #218838; }
        .comment { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .comment-header { font-weight: bold; color: #555; margin-bottom: 10px; }
        .comment-body { /* Estilo para el texto del comentario */ }
        .logout-btn { background-color: #dc3545; }
        .logout-btn:hover { background-color: #c82333; }
        .vulnerable-box { margin-top: 30px; padding: 15px; border: 1px solid #ddd; border-left: 5px solid #dc3545; background-color: #fff8f8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Esta es tu página de perfil. Aquí puedes interactuar con otros usuarios a través de comentarios.</p>
        <a href="logout.php" class="logout-btn" style="text-decoration: none; color: white; padding: 8px 12px; border-radius: 4px;">Cerrar Sesión</a>

        <div class="vulnerable-box">
            <h2> Publicar un Comentario (Vulnerable a XSS Almacenado)</h2>
            <p>Deja un comentario para la comunidad. ¡Cuidado! Un atacante podría usar esto para inyectar código.</p>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="comment">Tu comentario:</label>
                    <textarea id="comment" name="comment" required></textarea>
                </div>
                <button type="submit">Publicar Comentario</button>
            </form>
        </div>

        <h2>Comentarios Recientes</h2>
        <?php if (empty($comments)): ?>
            <p>Aún no hay comentarios. ¡Sé el primero en participar!</p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment-header">
                        Por: <?php echo htmlspecialchars($comment['username']); ?> 
                        el: <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?>
                    </div>
                    <div class="comment-body">
                        <!-- VULNERABILIDAD: XSS ALMACENADO -->
                        <!-- El texto del comentario se imprime directamente, permitiendo la ejecución de scripts -->
                        <?php echo $comment['comment_text']; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>

