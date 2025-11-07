<?php
$title = "PI - Pisos & Inmuebles";
require_once __DIR__ . '/inc/config.php';

// Auto-login: Si hay cookie de "recordar" pero no hay sesión activa
if (!isset($_SESSION['usuario']) && isset($_COOKIE['recordar_usuario'])) {
    $_SESSION['usuario'] = $_COOKIE['recordar_usuario'];
    $_SESSION['estilo'] = $_COOKIE['recordar_estilo'] ?? 'estilos.css';
    // Marcar que fue auto-login para mostrar mensaje especial si quieres
    $_SESSION['auto_login'] = true;
}

// Sistema de flashdata: capturar mensaje temporal
$flashMessage = '';
if (isset($_SESSION['flash_message'])) {
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
} elseif (isset($_COOKIE['flash_message'])) {
    $flashMessage = $_COOKIE['flash_message'];
    // Eliminar cookie flash inmediatamente
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    setcookie('flash_message', '', [
        'expires' => time() - 3600,
        'path' => '/',
        'secure' => $secure,
        'httponly' => false,
        'samesite' => 'Lax'
    ]);
} elseif (isset($_SESSION['auto_login'])) {
    // Mensaje especial si fue auto-login desde cookies
    $flashMessage = '¡Bienvenido de nuevo! Has iniciado sesión automáticamente.';
    unset($_SESSION['auto_login']);
}

$mensajeVisita = '';
if (isset($_SESSION['usuario'])) {
    if (isset($_COOKIE['ultima_visita'])) {
        $mensajeVisita = "Tu última visita fue el " . htmlspecialchars($_COOKIE['ultima_visita']);
    } else {
        $mensajeVisita = "Bienvenido, es tu primera visita.";
    }
    
    $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    $cookieOptions = [
        'expires' => time() + (90 * 24 * 60 * 60),
        'path' => '/',
        'secure' => $secure,
        'httponly' => true,
        'samesite' => 'Lax'
    ];
    setcookie('ultima_visita', date('d/m/Y H:i'), $cookieOptions);
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
    <?php if (!empty($flashMessage)): ?>
    <section class="flash-message" style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
        <p><strong>✓</strong> <?= htmlspecialchars($flashMessage, ENT_QUOTES, 'UTF-8') ?></p>
    </section>
    <?php endif; ?>

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
                    <img src="img/casa-rural.jpg" alt="Casa rural reformada">
                    <h3>Loft industrial reformado</h3>
                    <p class="fecha">01/10/2025 - Madrid, España</p>
                    <p class="precio">415.000€</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=2">
                    <img src="img/casa-rural.jpg" alt="Casa rural reformada">
                    <h3>Apartamento céntrico</h3>
                    <p class="fecha">12/09/2025 - Sevilla, España</p>
                    <p class="precio">800€/mes</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=3">
                    <img src="img/casa-rural.jpg" alt="Casa rural reformada">
                    <h3>Loft industrial reformado</h3>
                    <p class="fecha">01/10/2025 - Madrid, España</p>
                    <p class="precio">415.000€</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=4">
                    <img src="img/casa-rural.jpg" alt="Casa rural reformada">
                    <h3>Apartamento céntrico</h3>
                    <p class="fecha">12/09/2025 - Sevilla, España</p>
                    <p class="precio">800€/mes</p>
                </a>
            </article>
            <article class="anuncio">
                <a href="detalle.php?id=5">
                    <img src="img/casa-rural.jpg" alt="Casa rural reformada">
                    <h3>Loft industrial reformado</h3>
                    <p class="fecha">01/10/2025 - Madrid, España</p>
                    <p class="precio">415.000€</p>
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
