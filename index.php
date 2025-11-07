<?php
$title = "PI - Pisos & Inmuebles";
require_once __DIR__ . '/inc/config.php';

if (!isset($_SESSION['usuario']) && isset($_COOKIE['recordar_usuario'])) {
    $_SESSION['usuario'] = $_COOKIE['recordar_usuario'];
    $_SESSION['estilo'] = $_COOKIE['recordar_estilo'] ?? 'estilos.css';
}

$mensajeVisita = '';
if (isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['ultima_visita'])) {
        $mensajeVisita = "Tu última visita fue el " . htmlspecialchars($_COOKIE['ultima_visita']);
    } else {
        $mensajeVisita = "Bienvenido, es tu primera visita.";
    }
    setcookie('ultima_visita', date('d/m/Y H:i'), time() + (90 * 24 * 60 * 60), "/", "", false, true);
}

$ultimosAnuncios = [];
if (!empty($_COOKIE['ultimos_anuncios'])) {
    $ultimosAnuncios = explode(',', $_COOKIE['ultimos_anuncios']);
    $ultimosAnuncios = array_map('trim', $ultimosAnuncios);
}

require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
    <section>
        <?php if (isset($_SESSION['usuario'])): ?>
            <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
            <p><?= $mensajeVisita ?></p>
            <p>Accede a tu perfil, publica anuncios y gestiona tus mensajes.</p>
        <?php else: ?>
            <h2>Bienvenido a PI - Pisos & Inmuebles</h2>
            <p>Inicia sesión o regístrate para publicar anuncios y contactar con vendedores.</p>
        <?php endif; ?>
    </section>

    <section class="ultimos-anuncios">
        <h2>Últimos anuncios</h2>
        <div class="anuncios-grid">
            <article class="anuncio">
                <a href="detalle.php?id=1">
                    <img src="img/casa-barcelona.svg" alt="Ático en Barcelona">
                    <h3>Ático con terraza</h3>
                    <p class="fecha">15/09/2025 - Barcelona, España</p>
                    <p class="precio">450.000€</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=2">
                    <img src="img/apartamento-sevilla.svg" alt="Apartamento en Sevilla">
                    <h3>Apartamento céntrico</h3>
                    <p class="fecha">12/09/2025 - Sevilla, España</p>
                    <p class="precio">800€/mes</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=3">
                    <img src="img/chalet-malaga.svg" alt="Chalet en Málaga">
                    <h3>Chalet con piscina</h3>
                    <p class="fecha">10/09/2025 - Málaga, España</p>
                    <p class="precio">320.000€</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=4">
                    <img src="img/oficina-bilbao.svg" alt="Oficina en Bilbao">
                    <h3>Oficina moderna</h3>
                    <p class="fecha">09/09/2025 - Bilbao, España</p>
                    <p class="precio">1.200€/mes</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=5">
                    <img src="img/garaje-zaragoza.svg" alt="Garaje en Zaragoza">
                    <h3>Plaza de garaje</h3>
                    <p class="fecha">05/09/2025 - Zaragoza, España</p>
                    <p class="precio">70€/mes</p>
                </a>
            </article>
        </div>
    </section>

    <?php if (!empty($ultimosAnuncios)): ?>
    <section class="ultimos-vistos">
        <h2>Últimos anuncios visitados</h2>
        <ul>
            <?php foreach ($ultimosAnuncios as $titulo): ?>
                <li><?= htmlspecialchars($titulo) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>
</main>

<?php
require_once __DIR__ . '/inc/footer.php';
?>
