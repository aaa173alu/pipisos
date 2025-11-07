<?php
require_once __DIR__ . '/config.php';
$usuarioLogueado = isset($_SESSION['usuario']);
?>

<nav class="main-nav">
    <?php if (!$usuarioLogueado): ?>
        <a href="/pipisos/" class="btn">Inicio</a>
        <a href="/pipisos/busqueda.php" class="btn">Buscar</a>
        <a href="/pipisos/login.php" class="btn">Inicio de sesión</a>
        <a href="/pipisos/registro.php" class="btn">Registro</a>
    <?php else: ?>
        <a href="/pipisos/" class="btn">Inicio</a>
        <a href="/pipisos/busqueda.php" class="btn">Buscar</a>
        <a href="/pipisos/mi-perfil.php" class="btn">Mi perfil</a>
        <a href="/pipisos/crear-anuncio.php" class="btn">Publicar anuncio</a>
        <a href="/pipisos/mensajes.php" class="btn">Mis mensajes</a>
        <a href="/pipisos/solicitar-folleto.php" class="btn">Solicitar folleto</a>
        <a href="/pipisos/logout.php" class="btn">Salir</a>
    <?php endif; ?>
</nav>

<?php if ($usuarioLogueado): ?>
<div class="user-info">
    <p>Conectado como <strong><?= htmlspecialchars($_SESSION['usuario'], ENT_QUOTES) ?></strong></p>
    <?php if (!empty($_COOKIE['ultima_visita'])): ?>
        <p>Última visita: <?= htmlspecialchars($_COOKIE['ultima_visita'], ENT_QUOTES) ?></p>
    <?php endif; ?>
</div>
<?php endif; ?>
