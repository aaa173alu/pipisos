<?php
require_once __DIR__ . '/inc/config.php';

$usuarios = file_exists(__DIR__ . '/data/usuarios.php') ? require __DIR__ . '/data/usuarios.php' : [];

if (!isset($_SESSION['usuario']) && isset($_COOKIE['recordar_usuario'])) {
    foreach ($usuarios as $u) {
        if (($u['user'] ?? '') === $_COOKIE['recordar_usuario']) {
            $_SESSION['usuario'] = $u['user'];
            $_SESSION['estilo'] = $u['estilo'] ?? '';
            header('Location: /pipisos/');
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['user'] ?? '');
    $clave = trim($_POST['pass'] ?? '');
    $recordar = isset($_POST['recordar']);

    if ($usuario === '' || $clave === '') {
        header('Location: /pipisos/login.php?error=empty');
        exit;
    }

    $usuarioEncontrado = null;
    foreach ($usuarios as $u) {
        if (($u['user'] ?? '') === $usuario) {
            // Verificar password con password_verify (soporta hashes)
            if (password_verify($clave, $u['pass'] ?? '')) {
                $usuarioEncontrado = $u;
                break;
            }
        }
    }

    if ($usuarioEncontrado) {
        session_regenerate_id(true);
        $_SESSION['usuario'] = $usuarioEncontrado['user'];
        $_SESSION['estilo'] = $usuarioEncontrado['estilo'] ?? '';

        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        $cookieOptions = [
            'expires' => time() + (90 * 24 * 60 * 60),
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ];

        if ($recordar) {
            setcookie('recordar_usuario', $usuarioEncontrado['user'], $cookieOptions);
            setcookie('recordar_estilo', $usuarioEncontrado['estilo'] ?? '', $cookieOptions);
            setcookie('ultima_visita', date('d/m/Y H:i'), $cookieOptions);
        }

        header('Location: /pipisos/');
        exit;
    } else {
        header('Location: /pipisos/login.php?error=credentials');
        exit;
    }
}

header('Location: /pipisos/login.php');
exit;
