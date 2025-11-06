<?php
$title = "Ver anuncio - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

// id requerido
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

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
    echo '<main><section><h1>Anuncio no encontrado</h1><p>No existe el anuncio solicitado.</p><p><a href="/pipisos/index-Log.php">Volver</a></p></section></main>';
    require_once __DIR__ . '/inc/footer.php';
    exit;
}
?>
<main>
    <section class="ver-anuncio">
        <h1><?php echo htmlspecialchars($ad['titulo']); ?></h1>

        <img src="<?php echo htmlspecialchars($ad['fotos']['principal'] ?? '/pipisos/img/placeholder.png'); ?>"
            alt="<?php echo htmlspecialchars($ad['titulo']); ?>" width="420"><br><br>

        <p><strong>Propietario:</strong> <?php echo htmlspecialchars($ad['usuario'] ?? ''); ?></p>
        <p><strong>Tipo de anuncio:</strong> <?php echo htmlspecialchars($ad['tipo'] ?? ''); ?></p>
        <p><strong>Tipo de vivienda:</strong> <?php echo htmlspecialchars($ad['vivienda'] ?? ''); ?></p>
        <p><strong>Precio:</strong> <?php echo number_format($ad['precio'] ?? 0, 0, ',', '.'); ?> €</p>
        <p><strong>Ciudad:</strong> <?php echo htmlspecialchars($ad['ciudad'] ?? ''); ?></p>
        <p><strong>País:</strong> <?php echo htmlspecialchars($ad['pais'] ?? ''); ?></p>
        <p><strong>Fecha:</strong> <?php echo htmlspecialchars($ad['fecha'] ?? ''); ?></p>

        <h3>Descripción</h3>
        <p><?php echo nl2br(htmlspecialchars($ad['texto'] ?? '')); ?></p>

        <h3>Características</h3>
        <ul>
            <li>Superficie: <?php echo htmlspecialchars($ad['caracteristicas']['superficie'] ?? ''); ?></li>
            <li>Habitaciones: <?php echo (int) ($ad['caracteristicas']['habitaciones'] ?? 0); ?></li>
            <li>Baños: <?php echo (int) ($ad['caracteristicas']['banos'] ?? 0); ?></li>
            <li>Planta: <?php echo htmlspecialchars($ad['caracteristicas']['planta'] ?? ''); ?></li>
            <li>Año: <?php echo htmlspecialchars($ad['caracteristicas']['anio'] ?? ''); ?></li>
        </ul>

        <h3>Galería</h3>
        <?php if (!empty($ad['fotos']['galeria'])): ?>
            <?php foreach ($ad['fotos']['galeria'] as $foto): ?>
                <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($ad['titulo']); ?>"
                    width="100">
            <?php endforeach; ?>
        <?php else: ?>
            <p>No hay más fotos.</p>
        <?php endif; ?>

        <p>
            <a href="/pipisos/anadir-foto.php?anuncio=<?php echo (int) $ad['id']; ?>">Añadir foto al anuncio</a> |
            <a href="/pipisos/mis-anuncios.php?user=<?php echo urlencode($ad['usuario'] ?? ''); ?>">Volver a mis
                anuncios</a> |
            <a href="/pipisos/index-Log.php">Volver al menú</a>
        </p>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>