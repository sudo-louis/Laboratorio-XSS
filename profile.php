<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = $_POST['comment'];

    $stmt = $pdo->prepare(
        "INSERT INTO comments (username, comment_text) VALUES (?, ?)"
    );
    $stmt->execute([$username, $comment]);

    header('Location: profile.php');
    exit();
}

$stmt = $pdo->query(
    "SELECT username, comment_text, created_at FROM comments ORDER BY created_at DESC"
);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($username); ?></h1>

    <a href="logout.php">Cerrar sesión</a>

    <h2>Nuevo comentario (XSS almacenado)</h2>
    <form method="POST">
        <textarea name="comment" required></textarea><br><br>
        <button type="submit">Publicar</button>
    </form>

    <h2>Comentarios</h2>

    <?php foreach ($comments as $c): ?>
        <div style="border:1px solid #ccc; margin:10px; padding:10px;">
            <strong><?php echo htmlspecialchars($c['username']); ?></strong><br>
            <?php echo $c['comment_text']; ?>
        </div>
    <?php endforeach; ?>
</body>
</html>
