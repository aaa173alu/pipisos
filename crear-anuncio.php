<?php
require_once __DIR__ . '/inc/config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: /pipisos/login.php');
    exit;
}

$title = "Crear anuncio - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
    <section class="crear-anuncio">
        <h1>Crear anuncio</h1>
        <form action="/pipisos/respuestaCrearAnuncio.php" method="post" novalidate enctype="multipart/form-data" class="crear-anuncio-form">
            <label>Tipo de anuncio:</label><br>
            <label><input type="radio" name="tipo" value="venta" checked> Venta</label>
            <label><input type="radio" name="tipo" value="alquiler"> Alquiler</label>
            <br><br>

            <label for="vivienda">Tipo de vivienda:</label><br>
            <select id="vivienda" name="vivienda">
                <option value="">Selecciona el tipo de vivienda</option>
                <option value="vivienda">Vivienda</option>
                <option value="chalet">Chalet</option>
                <option value="atico">Ático</option>
                <option value="apartment">Apartamento</option>
                <option value="oficina">Oficina</option>
                <option value="garaje">Garaje</option>
            </select>
            <br><br>

            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo" maxlength="200"
                   placeholder="Ejemplo: Ático luminoso en el centro"><br><br>

            <label for="texto">Descripción:</label><br>
            <textarea id="texto" name="texto" rows="6" cols="60"
                     placeholder="Describe las características principales de la vivienda"></textarea><br><br>

            <label for="fecha">Fecha publicación:</label><br>
            <input type="date" id="fecha" name="fecha"><br><br>

            <label for="ciudad">Ciudad:</label><br>
            <input type="text" id="ciudad" name="ciudad"
                   placeholder="Ciudad donde está la vivienda"><br><br>

            <label for="pais">País:</label><br>
            <input type="text" id="pais" name="pais"
                   placeholder="País donde está la vivienda"><br><br>

            <label for="precio">Precio (€):</label><br>
            <input type="number" id="precio" name="precio" min="0" step="1"
                   placeholder="Precio en euros"><br><br>

            <h3>Características</h3>
            <label for="superficie">Superficie:</label><br>
            <input type="text" id="superficie" name="superficie"><br><br>

            <label for="habitaciones">Habitaciones:</label><br>
            <input type="number" id="habitaciones" name="habitaciones" min="0"><br><br>

            <label for="banos">Baños:</label><br>
            <input type="number" id="banos" name="banos" min="0"><br><br>

            <label for="planta">Planta:</label><br>
            <input type="text" id="planta" name="planta"><br><br>

            <label for="anio">Año construcción:</label><br>
            <input type="number" id="anio" name="anio" min="1800" max="2100"><br><br>

            <button type="submit">Crear anuncio</button>
            <a href="/pipisos/index.php">Cancelar</a>
        </form>
    </section>
</main>

<script src="/pipisos/js/validations.js" defer></script>

<?php require_once __DIR__ . '/inc/footer.php'; ?>