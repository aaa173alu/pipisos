<?php
$title = "Enviar mensaje - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
  <section class="enviar-mensaje">
    <h1>Enviar mensaje al anunciante</h1>

    <form action="respuestaMensaje.php" method="post" novalidate>
      <label for="tipo">Tipo de mensaje:</label><br>
      <select id="tipo" name="tipo" required>
        <option value="">--Selecciona--</option>
        <option value="info">Más información</option>
        <option value="cita">Solicitar una cita</option>
        <option value="oferta">Comunicar una oferta</option>
      </select>
      <br><br>

      <label for="mensaje">Mensaje:</label><br>
      <textarea id="mensaje" name="mensaje" rows="6" cols="60" required></textarea>
      <br><br>

      <button type="submit">Enviar</button>
    </form>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>