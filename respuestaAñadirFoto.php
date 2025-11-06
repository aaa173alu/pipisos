<?php
$title = "Respuesta Añadir Foto - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/anadir-foto.php');
    exit;
}

// Recoger datos
$anuncio = isset($_POST['anuncio']) ? (int) $_POST['anuncio'] : 0;
$titulo = trim($_POST['titulo'] ?? '');
$alt = trim($_POST['alt'] ?? '');

// Fichero recibido (no se almacena)
$foto_info = $_FILES['foto'] ?? null;

$errors = [];
if ($anuncio <= 0)
    $errors[] = 'No se ha seleccionado un anuncio.';
if ($titulo === '')
    $errors[] = 'El título es obligatorio.';
if (strlen($alt) < 10)
    $errors[] = 'El texto alternativo debe tener al menos 10 caracteres.';

?>
<main>
    <section class="respuesta-anadir-foto">
        <h1>Respuesta: Añadir foto</h1>

        <?php if ($errors): ?>
            <div class="errores">
                <p>Error(es):</p>
                <ul>
                    <?php foreach ($errors as $e)
                        echo '<li>' . htmlspecialchars($e) . '</li>'; ?>
                </ul>
                <p><a href="/pipisos/anadir-foto.php?anuncio=<?php echo $anuncio ?: ''; ?>">Volver al formulario</a></p>
            </div>
        <?php else: ?>
            <p>Datos recibidos correctamente (no se ha realizado la subida real):</p>
            <ul>
                <li><strong>Anuncio ID:</strong> <?php echo $anuncio; ?></li>
                <li><strong>Título:</strong> <?php echo htmlspecialchars($titulo); ?></li>
                <li><strong>Texto alternativo:</strong> <?php echo htmlspecialchars($alt); ?></li>
                <li><strong>Fichero enviado:</strong>
                    <?php echo $foto_info && !empty($foto_info['name']) ? htmlspecialchars($foto_info['name']) : 'No se proporcionó fichero'; ?>
                </li>
            </ul>
            <p><a href="/pipisos/ver-anuncio.php?id=<?php echo $anuncio; ?>">Ver anuncio</a> | <a
                    href="/pipisos/mis-anuncios.php">Mis anuncios</a></p>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>