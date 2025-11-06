<?php

$title = "PI - Pisos & Inmuebles";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
  <section>
    <h2>Búsqueda rápida</h2>
    <form action="/pipisos/resultados.php" method="get" novalidate>
      <p>Tipo de anuncio:</p>
      <label>
        <input type="radio" name="tipo" value="venta" checked> Compra
      </label>
      <label>
        <input type="radio" name="tipo" value="alquiler"> Alquiler
      </label>
      <br><br>
      <label for="busqueda">Palabra clave:</label>
      <input type="text" id="busqueda" name="busqueda">
      <button type="submit">Buscar</button>
    </form>
  </section>

  <section>
    <h2>Acceso de usuarios</h2>
    <form action="/pipisos/login.php" method="post" novalidate>
      <label for="usuario">Usuario:</label>
      <input type="text" id="usuario" name="usuario" required>
      <br>
      <label for="clave">Contraseña:</label>
      <input type="password" id="clave" name="clave" required>
      <br>
      <button type="submit">Entrar</button>
    </form>
  </section>

  <section>
    <h2>Últimos anuncios</h2>
    <ul class="anuncios-list">
      <li>
        <a href="/pipisos/detalle.php">
          <img src="/pipisos/img/casa-barcelona.jpg" alt="Ático en Barcelona" width="150">
          <p>Ático con terraza - 15/09/2025 - Barcelona, España - 450.000€</p>
        </a>
      </li>
      <li>
        <a href="/pipisos/detalle.php">
          <img src="/pipisos/img/apartamento-sevilla.jpg" alt="Apartamento en Sevilla" width="150">
          <p>Apartamento céntrico - 12/09/2025 - Sevilla, España - 800€/mes</p>
        </a>
      </li>
      <li>
        <a href="/pipisos/detalle.php">
          <img src="/pipisos/img/chalet-malaga.jpg" alt="Chalet en Málaga" width="150">
          <p>Chalet con piscina - 10/09/2025 - Málaga, España - 320.000€</p>
        </a>
      </li>
      <li>
        <a href="/pipisos/detalle.php">
          <img src="/pipisos/img/oficina-bilbao.jpg" alt="Oficina en Bilbao" width="150">
          <p>Oficina moderna - 09/09/2025 - Bilbao, España - 1.200€/mes</p>
        </a>
      </li>
      <li>
        <a href="/pipisos/detalle.php">
          <img src="/pipisos/img/garaje-zaragoza.jpg" alt="Garaje en Zaragoza" width="150">
          <p>Plaza de garaje - 05/09/2025 - Zaragoza, España - 70€/mes</p>
        </a>
      </li>
    </ul>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>