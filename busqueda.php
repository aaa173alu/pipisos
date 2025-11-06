<?php
$title = "Búsqueda de anuncios - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
  <section class="busqueda">
    <h1>Búsqueda de anuncios</h1>

    <form action="resultados.php" method="get" novalidate>

      <label>Tipo de anuncio:</label><br>
      <input type="radio" name="tipo" value="venta"> Venta
      <input type="radio" name="tipo" value="alquiler"> Alquiler
      <br><br>

      <label for="vivienda">Tipo de vivienda:</label>
      <select id="vivienda" name="vivienda">
        <option value="">--Cualquiera--</option>
        <option value="obra">Obra nueva</option>
        <option value="vivienda">Vivienda</option>
        <option value="oficina">Oficina</option>
        <option value="local">Local</option>
        <option value="garaje">Garaje</option>
      </select>
      <br><br>

      <label for="ciudad">Ciudad:</label>
      <input type="text" id="ciudad" name="ciudad" list="ciudades">
      <datalist id="ciudades">
        <option value="Barcelona">
        <option value="Bilbao">
        <option value="Madrid">
        <option value="Sevilla">
        <option value="Valencia">
      </datalist>
      <br><br>

      <label for="pais">País:</label>
      <select id="pais" name="pais">
        <option value="">--Cualquiera--</option>
        <option value="alemania">Alemania</option>
        <option value="españa">España</option>
        <option value="francia">Francia</option>
        <option value="italia">Italia</option>
        <option value="portugal">Portugal</option>
      </select>
      <br><br>

      <label for="precio"><span class="icon-money"></span> Precio (€):</label>
      <input type="number" id="precio" name="precio" min="0" step="1000" placeholder="Máx.">
      <br><br>

      <label for="fecha">Fecha de publicación (desde):</label>
      <input type="date" id="fecha" name="fecha">
      <br><br>

      <button type="submit">Buscar</button>
    </form>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>