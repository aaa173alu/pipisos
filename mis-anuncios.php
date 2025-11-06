<?php

$title = "Mis anuncios - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

// Usuario cuya lista mostramos (por GET o por defecto demo)
$user = trim($_GET['user'] ?? 'usuario1');

// Cargar anuncios
$anuncios = [];
if (file_exists(__DIR__ . '/data/anuncios.php')) {
    $anuncios = require __DIR__ . '/data/anuncios.php';
}

// Filtrar por usuario
$mis = array_filter($anuncios, function ($a) use ($user) {
    return isset($a['usuario']) && $a['usuario'] === $user;
});
?>
<main>
    <section class="mis-anuncios">
        <h1>Mis anuncios (<?php echo htmlspecialchars($user); ?>)</h1>

        <?php if (empty($mis)): ?>
            <p>No hay anuncios para este usuario.</p>
            <p><a href="/pipisos/index-Log.php">Volver al menú</a></p>
        <?php else: ?>
            <ul class="anuncios-list">
                <?php foreach ($mis as $a): ?>
                    <li class="anuncio-item">
                        <a href="/pipisos/ver-anuncio.php?id=<?php echo (int) $a['id']; ?>">
                            <img src="<?php echo htmlspecialchars($a['fotos']['principal'] ?? '/pipisos/img/placeholder.png'); ?>"
                                alt="<?php echo htmlspecialchars($a['titulo'] ?? ''); ?>" width="120">
                            <div class="meta">
                                <h3><?php echo htmlspecialchars($a['titulo'] ?? ''); ?></h3>
                                <p><?php echo htmlspecialchars($a['ciudad'] ?? ''); ?>,
                                    <?php echo htmlspecialchars($a['pais'] ?? ''); ?></p>
                                <p class="precio"><?php echo number_format($a['precio'] ?? 0, 0, ',', '.'); ?> €</p>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p><a href="/pipisos/index-Log.php">Volver al menú</a></p>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>