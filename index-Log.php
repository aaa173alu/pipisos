<?php

$title = "PI - Pisos & Inmuebles (Usuario)";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
    <section>
        <section>
            <h2>Bienvenido, Usuario</h2>
            <p>Accede a tu perfil, publica anuncios y gestiona tus mensajes.</p>
        </section>

        <section class="ultimos-anuncios">
            <h2>Últimos anuncios</h2>
            <div class="anuncios-grid">
                <article class="anuncio">
                    <a href="/pipisos/detalle.php">
                        <img src="/pipisos/img/casa-barcelona.svg" alt="Ático en Barcelona">
                        <h3>Ático con terraza</h3>
                        <p class="fecha">15/09/2025 - Barcelona, España</p>
                        <p class="precio">450.000€</p>
                    </a>
                </article>

                <article class="anuncio">
                    <a href="/pipisos/detalle.php">
                        <img src="/pipisos/img/apartamento-sevilla.svg" alt="Apartamento en Sevilla">
                        <h3>Apartamento céntrico</h3>
                        <p class="fecha">12/09/2025 - Sevilla, España</p>
                        <p class="precio">800€/mes</p>
                    </a>
                </article>

                <article class="anuncio">
                    <a href="/pipisos/detalle.php">
                        <img src="/pipisos/img/chalet-malaga.svg" alt="Chalet en Málaga">
                        <h3>Chalet con piscina</h3>
                        <p class="fecha">10/09/2025 - Málaga, España</p>
                        <p class="precio">320.000€</p>
                    </a>
                </article>

                <article class="anuncio">
                    <a href="/pipisos/detalle.php">
                        <img src="/pipisos/img/oficina-bilbao.svg" alt="Oficina en Bilbao">
                        <h3>Oficina moderna</h3>
                        <p class="fecha">09/09/2025 - Bilbao, España</p>
                        <p class="precio">1.200€/mes</p>
                    </a>
                </article>

                <article class="anuncio">
                    <a href="/pipisos/detalle.php">
                        <img src="/pipisos/img/garaje-zaragoza.svg" alt="Garaje en Zaragoza">
                        <h3>Plaza de garaje</h3>
                        <p class="fecha">05/09/2025 - Zaragoza, España</p>
                        <p class="precio">70€/mes</p>
                    </a>
                </article>
            </div>
        </section>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>