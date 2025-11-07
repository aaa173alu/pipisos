<?php
require_once __DIR__ . '/inc/config.php';
session_start();

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"]);
}

session_destroy();

setcookie('recordar_usuario', '', time() - 3600, "/");
setcookie('ultima_visita', '', time() - 3600, "/");
setcookie('ultimos_anuncios', '', time() - 3600, "/");

header('Location: /pipisos/');
exit;
?>
