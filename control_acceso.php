<?php
// Control de acceso (sin sesiones, con redirecciones y parámetros en la URL)
$usuario = $_POST['user'] ?? '';
$clave = $_POST['pass'] ?? '';

// Normalizar
$usuario_trim = trim($usuario);
$clave_trim = trim($clave);

// Si no es POST -> volver al formulario de login
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/login.php');
    exit;
}

// Validaciones: no vacío ni solo espacios/tabs
if ($usuario_trim === '' || $clave_trim === '') {
    // error=empty
    header('Location: /pipisos/login.php?error=empty');
    exit;
}

// Cargar usuarios permitidos (fichero data/usuarios.php debe devolver array)
$usuarios = [];
if (file_exists(__DIR__ . '/data/usuarios.php')) {
    $usuarios = require __DIR__ . '/data/usuarios.php';
}

// Comprobar credenciales (clave en claro según práctica)
$ok = false;
foreach ($usuarios as $u) {
    if (($u['user'] ?? '') === $usuario_trim && ($u['pass'] ?? '') === $clave_trim) {
        $ok = true;
        break;
    }
}

if ($ok) {
    // Incluir configuración y guardar datos del usuario
    require_once __DIR__ . '/inc/config.php';
    $_SESSION['usuario'] = $usuario_trim;
    
    // Redirigir a la página principal
    header('Location: /pipisos/');
    exit;
} else {
    // Credenciales incorrectas -> volver al login con error
    header('Location: /pipisos/login.php?error=credentials');
    exit;
}
?>