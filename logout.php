<?php
require_once __DIR__ . '/inc/config.php';

// Guardar mensaje flash en cookie temporal (la sesión se va a destruir)
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$flashOptions = [
    'expires' => time() + 60, // Solo 60 segundos
    'path' => '/',
    'secure' => $secure,
    'httponly' => false, // Necesario para leer en cliente si fuera preciso
    'samesite' => 'Lax'
];
setcookie('flash_message', 'Has cerrado sesión correctamente', $flashOptions);

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"] ?? '', $params["secure"] ?? false, $params["httponly"] ?? false);
}

session_destroy();

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$del = [
    'expires' => time() - 3600,
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
];

// Al cerrar sesión explícitamente, eliminamos cookies persistentes para evitar auto-login
setcookie('recordar_usuario', '', $del);
setcookie('recordar_estilo', '', $del);
setcookie('ultima_visita', '', $del);
setcookie('ultimos_anuncios', '', $del);

header('Location: /pipisos/');
exit;
