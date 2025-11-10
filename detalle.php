<?php
// Control de acceso: solo usuarios autenticados pueden ver detalle
require_once __DIR__ . '/inc/config.php';

if (!isset($_SESSION['usuario'])) {
    // Flash message y redirección al login
    $_SESSION['flash_message'] = 'Debes iniciar sesión para ver los detalles del anuncio.';
    header('Location: /pipisos/login.php');
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

$anuncios = [];
if (file_exists(__DIR__ . '/data/anuncios.php')) {
    $anuncios = require __DIR__ . '/data/anuncios.php';
}

$ad = null;
foreach ($anuncios as $a) {
    if (($a['id'] ?? 0) === $id) {
        $ad = $a;
        break;
    }
}
if ($ad === null) {
    if ($id % 2 === 0 && isset($anuncios[1])) {
        $ad = $anuncios[1];
    } elseif (isset($anuncios[0])) {
        $ad = $anuncios[0];
    }
}

if ($ad === null) {
    // No data available
    require_once __DIR__ . '/inc/header.php';
    require_once __DIR__ . '/inc/menu.php';
    echo '<main><section><h1>Detalle del anuncio</h1><p>No hay datos de anuncio disponibles.</p></section></main>';
    require_once __DIR__ . '/inc/footer.php';
    exit;
}

/* === Actualizar cookie de últimos anuncios (solo usuarios autenticados) === */
$titulo = $ad['titulo'] ?? "Anuncio $id";
$ultimos = [];

if (!empty($_COOKIE['ultimos_anuncios'])) {
    $ultimos = explode(',', $_COOKIE['ultimos_anuncios']);
    $ultimos = array_map('trim', $ultimos);
}

$ultimos = array_filter($ultimos, fn($t) => $t !== $titulo);
$ultimos[] = $titulo;
if (count($ultimos) > 5) array_shift($ultimos);

$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
$cookieOptions = [
    'expires' => time() + (90 * 24 * 60 * 60),
    'path' => '/',
    'secure' => $secure,
    'httponly' => true,
    'samesite' => 'Lax'
];
setcookie('ultimos_anuncios', implode(',', $ultimos), $cookieOptions);

// Mostrar detalle (estructura y estilo existentes)
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
    <section class="detalle-anuncio">
        <h1><?= htmlspecialchars($ad['titulo']) ?></h1>

        <img src="<?= htmlspecialchars($ad['fotos']['principal']) ?>"
            alt="<?= htmlspecialchars($ad['titulo']) ?>" width="400"><br><br>

        <p><strong>Tipo de anuncio:</strong> <?= htmlspecialchars($ad['tipo']) ?></p>
        <p><strong>Tipo de vivienda:</strong> <?= htmlspecialchars($ad['vivienda']) ?></p>
        <p><strong>Título:</strong> <?= htmlspecialchars($ad['titulo']) ?></p>
        <p><strong>Texto:</strong> <?= nl2br(htmlspecialchars($ad['texto'])) ?></p>
        <p><strong>Fecha publicación:</strong> <?= htmlspecialchars($ad['fecha']) ?></p>
        <p><strong>Ciudad:</strong> <?= htmlspecialchars($ad['ciudad']) ?></p>
        <p><strong>País:</strong> <?= htmlspecialchars($ad['pais']) ?></p>
        <p><strong>Precio:</strong> <?= number_format($ad['precio'], 0, ',', '.') ?> €</p>

        <h3>Características</h3>
        <ul>
            <li>Superficie: <?= htmlspecialchars($ad['caracteristicas']['superficie'] ?? '') ?></li>
            <li>Habitaciones: <?= (int) ($ad['caracteristicas']['habitaciones'] ?? 0) ?></li>
            <li>Baños: <?= (int) ($ad['caracteristicas']['banos'] ?? 0) ?></li>
            <li>Planta: <?= htmlspecialchars($ad['caracteristicas']['planta'] ?? '') ?></li>
            <li>Año: <?= htmlspecialchars($ad['caracteristicas']['anio'] ?? '') ?></li>
        </ul>

        <h3>Otras fotos</h3>
        <?php foreach ($ad['fotos']['galeria'] as $foto): ?>
            <img src="<?= htmlspecialchars($foto) ?>" alt="<?= htmlspecialchars($ad['titulo']) ?>" width="100">
        <?php endforeach; ?>

        <p><a href="/pipisos/enviar-mensaje.php">Enviar mensaje</a></p>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
