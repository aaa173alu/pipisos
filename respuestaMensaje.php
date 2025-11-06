<?php
$title = "Confirmación envío - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

$allowed = [
    'info' => 'Más información',
    'cita' => 'Solicitar una cita',
    'oferta' => 'Comunicar una oferta',
];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/enviar-mensaje.php');
    exit;
}

$tipo = $_POST['tipo'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';

if (!array_key_exists($tipo, $allowed)) {
    $errors[] = 'Tipo de mensaje inválido.';
}

if (trim($mensaje) === '') {
    $errors[] = 'El texto del mensaje no puede estar vacío.';
}
?>
<main>
    <section class="respuesta-mensaje">
        <h1>Enviar mensaje</h1>

        <?php if ($errors): ?>
            <div class="errores">
                <p>Error(es):</p>
                <ul>
                    <?php foreach ($errors as $e)
                        echo '<li>' . htmlspecialchars($e) . '</li>'; ?>
                </ul>
                <p><a href="/pipisos/enviar-mensaje.php">Volver al formulario</a></p>
            </div>
        <?php else: ?>
            <div class="confirmacion">
                <p>Mensaje enviado correctamente. Datos recibidos:</p>
                <ul>
                    <li><strong>Tipo:</strong> <?php echo htmlspecialchars($allowed[$tipo]); ?></li>
                    <li><strong>Mensaje:</strong> <?php echo nl2br(htmlspecialchars($mensaje)); ?></li>
                </ul>
                <p><a href="/pipisos/index.php">Volver al inicio</a></p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>