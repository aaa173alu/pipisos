<?php
require_once __DIR__ . '/inc/config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: /pipisos/login.php');
    exit;
}

$title = "Mis mensajes - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<!-- carga CSS específico (se aplica aunque esté fuera del head) -->
<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
  <section class="mis-mensajes">
    <h1>Mis mensajes</h1>
    <p>A continuación se muestran los mensajes enviados y recibidos:</p>

    <table>
      <caption>Listado de mensajes</caption>
      <thead>
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col">Texto</th>
          <th scope="col">Fecha</th>
          <th scope="col">Usuario</th>
        </tr>
      </thead>
      <tbody>
        <!-- Los mensajes se insertarán aquí dinámicamente -->
      </tbody>
    </table>

  <p><a href="/pipisos/index.php">Volver al menú</a></p>
  </section>
</main>

<!-- script de la página -->
<script src="/pipisos/js/mensajes.js" defer></script>

<?php require_once __DIR__ . '/inc/footer.php'; ?>