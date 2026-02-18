<?php
// search.php - Muestra los resultados de la búsqueda
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de la Búsqueda</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; color: #333; line-height: 1.6; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #0056b3; }
        .back-link { display: inline-block; margin-top: 20px; color: #0056b3; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <!-- VULNERABILIDAD: XSS REFLEJADO -->
        <h1>Resultados para: "<?php echo $_GET['query']; ?>"</h1>
        <p>
            Lo sentimos, no se encontraron cursos que coincidan con tu búsqueda: 
            <strong><?php echo $_GET['query']; ?></strong>.
        </p>
        <p>Por favor, intenta con otros términos.</p>
        <a href="index.php" class="back-link">← Volver al inicio</a>
    </div>
</body>
</html>

