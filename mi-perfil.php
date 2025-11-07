<?php
require_once __DIR__ . '/inc/config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: /pipisos/login.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$estilo = $_SESSION['estilo'] ?? ($_COOKIE['recordar_estilo'] ?? 'principal.css');
$ultimaVisita = $_COOKIE['ultima_visita'] ?? 'Primera vez que accedes';

$title = "Mi Perfil - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
    <section class="perfil-usuario">
        <h1>Mi Perfil</h1>
        <p>Bienvenido, <strong><?= htmlspecialchars($usuario, ENT_QUOTES) ?></strong></p>
        <p>Última visita: <?= htmlspecialchars($ultimaVisita, ENT_QUOTES) ?></p>
        <p>Estilo actual: <em><?= htmlspecialchars($estilo, ENT_QUOTES) ?></em></p>

        <div class="opciones-perfil">
            <h2>Gestión de cuenta</h2>
            <ul>
                <li><a href="/pipisos/modificar-datos.php" class="btn"><span class="icon-user"></span> Modificar mis datos</a></li>
                <li><a href="/pipisos/baja-usuario.php" class="btn btn-danger"><span class="icon-user-times"></span> Darse de baja</a></li>
            </ul>

            <h2>Mis anuncios</h2>
            <ul>
                <li><a href="/pipisos/mis-anuncios.php" class="btn"><span class="icon-list"></span> Visualizar mis anuncios</a></li>
                <li><a href="/pipisos/crear-anuncio.php" class="btn"><span class="icon-plus"></span> Crear un anuncio nuevo</a></li>
            </ul>

            <h2>Comunicaciones</h2>
            <ul>
                <li><a href="/pipisos/mensajes.php" class="btn"><span class="icon-mail"></span> Mensajes enviados y recibidos</a></li>
                <li><a href="/pipisos/solicitar-folleto.php" class="btn"><span class="icon-doc-text"></span> Solicitar folleto publicitario</a></li>
                <li><a href="/pipisos/logout.php" class="btn btn-secondary"><span class="icon-logout"></span> Salir</a></li>
            </ul>
        </div>
    </section>
</main>

<style>
.perfil-usuario {
    max-width: 800px;
    margin: 2em auto;
    padding: 0 1em;
}
.opciones-perfil {
    margin-top: 2em;
}
.opciones-perfil h2 {
    margin: 1.5em 0 0.5em;
    padding-bottom: 0.5em;
    border-bottom: 1px solid #ddd;
}
.opciones-perfil ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.opciones-perfil li {
    margin: 0.5em 0;
}
.opciones-perfil .btn {
    display: block;
    padding: 1em;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}
.opciones-perfil .btn:hover {
    transform: translateX(10px);
}
.btn-danger {
    background-color: #dc3545;
    color: white;
}
.btn-danger:hover {
    background-color: #c82333;
}
.btn-secondary {
    background-color: #6c757d;
    color: white;
}
.btn-secondary:hover {
    background-color: #5a6268;
}
</style>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
