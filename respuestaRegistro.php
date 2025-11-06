<?php
// Respuesta al formulario de registro.
// Valida servidor: usuario, clave, repetir clave y que coincidan.
// No guarda ficheros ni muestra la foto de perfil.
// Redirige de vuelta a registro.php con parámetros en la URL si hay errores.

$title = "Registro - Confirmación";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/registro.php');
    exit;
}

// Recoger campos (no incluimos fichero de foto en la salida)
$usuario = trim($_POST['usuario'] ?? '');
$clave = $_POST['clave'] ?? '';
$clave2 = $_POST['clave2'] ?? '';
$email = trim($_POST['email'] ?? '');
$sexo = $_POST['sexo'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$ciudad = trim($_POST['ciudad'] ?? '');
$pais = $_POST['pais'] ?? '';

// Validaciones mínimas solicitadas
$errors = [];

if ($usuario === '') {
    $errors[] = 'empty_user';
}
if ($clave === '') {
    $errors[] = 'empty_pass';
}
if ($clave2 === '') {
    $errors[] = 'empty_pass2';
}
if ($clave !== '' && $clave2 !== '' && $clave !== $clave2) {
    $errors[] = 'mismatch';
}

// (Opcional) validar formato de email básico
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'invalid_email';
}

// Si hay errores, redirigir a registro.php pasando errores y campos para reutilizar
if (!empty($errors)) {
    $qs = [
        'error' => implode('|', $errors),
        'usuario' => $usuario,
        'email' => $email,
        'sexo' => $sexo,
        'fecha' => $fecha,
        'ciudad' => $ciudad,
        'pais' => $pais
    ];
    $location = '/pipisos/registro.php?' . http_build_query($qs);
    header('Location: ' . $location);
    exit;
}

// Si todo OK, mostrar confirmación (no mostrar la contraseña ni la foto)
?>
<main>
    <section class="respuesta-registro">
        <h1>Registro recibido</h1>
        <p>Se han recibido los siguientes datos (la contraseña no se muestra):</p>

        <table>
            <tbody>
                <tr>
                    <th>Usuario</th>
                    <td><?php echo htmlspecialchars($usuario); ?></td>
                </tr>
                <tr>
                    <th>Correo electrónico</th>
                    <td><?php echo htmlspecialchars($email); ?></td>
                </tr>
                <tr>
                    <th>Sexo</th>
                    <td><?php echo htmlspecialchars($sexo); ?></td>
                </tr>
                <tr>
                    <th>Fecha de nacimiento</th>
                    <td><?php echo htmlspecialchars($fecha); ?></td>
                </tr>
                <tr>
                    <th>Ciudad</th>
                    <td><?php echo htmlspecialchars($ciudad); ?></td>
                </tr>
                <tr>
                    <th>País</th>
                    <td><?php echo htmlspecialchars($pais); ?></td>
                </tr>
            </tbody>
        </table>

        <p>En próximas prácticas se verificará y almacenará este usuario en la base de datos.</p>
        <p><a href="/pipisos/login.php">Entrar</a> | <a href="/pipisos/index.php">Ir al inicio</a></p>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>