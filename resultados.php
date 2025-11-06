<?php

$title = "Resultados de búsqueda - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
  <section>
    <h2>Resultados de búsqueda</h2>

    <section class="ultimos-anuncios">
      <div class="anuncios-grid">
        <article class="anuncio">
          <a href="/pipisos/detalle.php">
            <img src="/pipisos/img/casa-barcelona.svg" alt="Piso en Madrid">
            <h3>Piso en Madrid</h3>
            <p class="fecha">01/12/2023 - Madrid, España</p>
            <p class="precio">250.000€</p>
          </a>
        </article>

        <article class="anuncio">
          <a href="/pipisos/detalle.php">
            <img src="/pipisos/img/chalet-malaga.svg" alt="Chalet en Málaga">
            <h3>Chalet en Málaga</h3>
            <p class="fecha">20/11/2023 - Málaga, España</p>
            <p class="precio">350.000€</p>
          </a>
        </article>
      </div>
    </section>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>