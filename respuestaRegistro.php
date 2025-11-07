<?php
require_once __DIR__ . '/inc/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/registro.php');
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$clave = $_POST['clave'] ?? '';
$clave2 = $_POST['clave2'] ?? '';
$email = trim($_POST['email'] ?? '');
$sexo = $_POST['sexo'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$ciudad = trim($_POST['ciudad'] ?? '');
$pais = $_POST['pais'] ?? '';

$errors = [];

if ($usuario === '') $errors[] = 'El nombre de usuario es obligatorio.';
if (strlen($clave) < 6) $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
if ($clave !== $clave2) $errors[] = 'Las contraseñas no coinciden.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Correo electrónico inválido o vacío.';

// ejemplo verificación fecha (opcional)
if ($fecha !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) $errors[] = 'Fecha de nacimiento con formato inválido.';

// validación MIME/size de la foto (opcional)
if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = 'Error al subir la foto.';
    } else {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
        finfo_close($finfo);
        $allowed = ['image/jpeg','image/png','image/gif'];
        if (!in_array($mime, $allowed, true)) $errors[] = 'Tipo de imagen no permitido. Usa JPG/PNG/GIF.';
        if ($_FILES['foto']['size'] > 2*1024*1024) $errors[] = 'La foto no puede superar 2MB.';
    }
}

// Si hay errores, guardamos y redirigimos
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = [
        'usuario'=>$usuario,'email'=>$email,'sexo'=>$sexo,'fecha'=>$fecha,
        'ciudad'=>$ciudad,'pais'=>$pais
    ];
    header('Location: /pipisos/registro.php');
    exit;
}

// Si no hay errores, procesar el registro (hash de contraseña, guardar en BD, mover imagen, etc.)
// Ejemplo rápido (recuerda: usar siempre prepared statements para la BD):
// $hash = password_hash($clave, PASSWORD_DEFAULT);
// ... insertar usuario en la base de datos ...

$title = "Registro completado - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
  <section>
    <h2>Registro completado</h2>
    <p>Usuario <?= htmlspecialchars($usuario) ?> registrado correctamente. Se ha enviado un correo a <?= htmlspecialchars($email) ?> (si procede).</p>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
