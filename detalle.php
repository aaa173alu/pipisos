<?php
$title = "Detalle anuncio - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

// Obtener id (por GET) — por defecto 1
$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

// Cargar datos de anuncios
$anuncios = [];
if (file_exists(__DIR__ . '/data/anuncios.php')) {
    $anuncios = require __DIR__ . '/data/anuncios.php';
}

// Selección por par/impar: si existe anuncio con id exacto lo usamos, si no usar par/impar
$ad = null;
// Buscar por id primero
foreach ($anuncios as $a) {
    if (($a['id'] ?? 0) === $id) {
        $ad = $a;
        break;
    }
}
if ($ad === null) {
    // fallback: usar segundo si id par, primero si impar
    if ($id % 2 === 0 && isset($anuncios[1])) {
        $ad = $anuncios[1];
    } elseif (isset($anuncios[0])) {
        $ad = $anuncios[0];
    }
}

// Si no hay anuncios definidos, mostrar mensaje
if ($ad === null) {
    echo '<main><section><h1>Detalle del anuncio</h1><p>No hay datos de anuncio disponibles.</p></section></main>';
    require_once __DIR__ . '/inc/footer.php';
    exit;
}
?>

<main>
    <section class="detalle-anuncio">
        <h1><?php echo htmlspecialchars($ad['titulo']); ?></h1>

        <img src="<?php echo htmlspecialchars($ad['fotos']['principal']); ?>"
            alt="<?php echo htmlspecialchars($ad['titulo']); ?>" width="400"><br><br>

        <p><strong>Tipo de anuncio:</strong> <?php echo htmlspecialchars($ad['tipo']); ?></p>
        <p><strong>Tipo de vivienda:</strong> <?php echo htmlspecialchars($ad['vivienda']); ?></p>
        <p><strong>Título:</strong> <?php echo htmlspecialchars($ad['titulo']); ?></p>
        <p><strong>Texto:</strong> <?php echo nl2br(htmlspecialchars($ad['texto'])); ?></p>
        <p><strong>Fecha publicación:</strong> <?php echo htmlspecialchars($ad['fecha']); ?></p>
        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($ad['ciudad']); ?></p>
        <p><strong>País:</strong> <?php echo htmlspecialchars($ad['pais']); ?></p>
        <p><strong>Precio:</strong> <?php echo number_format($ad['precio'], 0, ',', '.'); ?> €</p>

        <h3>Características</h3>
        <ul>
            <li>Superficie: <?php echo htmlspecialchars($ad['caracteristicas']['superficie'] ?? ''); ?></li>
            <li>Habitaciones: <?php echo (int) ($ad['caracteristicas']['habitaciones'] ?? 0); ?></li>
            <li>Baños: <?php echo (int) ($ad['caracteristicas']['banos'] ?? 0); ?></li>
            <li>Planta: <?php echo htmlspecialchars($ad['caracteristicas']['planta'] ?? ''); ?></li>
            <li>Año: <?php echo htmlspecialchars($ad['caracteristicas']['anio'] ?? ''); ?></li>
        </ul>

        <h3>Otras fotos</h3>
        <?php foreach ($ad['fotos']['galeria'] as $foto): ?>
            <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($ad['titulo']); ?>"
                width="100">
        <?php endforeach; ?>

        <p><a href="/pipisos/enviar-mensaje.php">Enviar mensaje</a></p>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>