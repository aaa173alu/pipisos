<?php
require_once __DIR__ . '/inc/config.php';
session_start();

// vaciar la sesión
$_SESSION = [];

// eliminar cookie de sesión si procede
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"] ?? '', $params["secure"] ?? false, $params["httponly"] ?? false);
}

session_destroy();

// Eliminar cookies relacionadas con "recordarme" y estilo.
// Usamos opciones compatibles con PHP >= 7.3 (array) y una eliminación segura.
$delOptions = [
    'expires' => time() - 3600,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Lax'
];

setcookie('recordar_usuario', '', $delOptions);
setcookie('recordar_estilo', '', $delOptions);
setcookie('ultima_visita', '', $delOptions);
setcookie('ultimos_anuncios', '', $delOptions);

// Redirigir al inicio
header('Location: /pipisos/');
exit;
?>
