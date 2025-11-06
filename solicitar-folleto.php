<?php

$title = "Solicitar folleto - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
    <section>
        <h2>Solicitar folleto publicitario</h2>
        <p>Rellena el formulario para solicitar tu folleto personalizado.</p>

        <section id="tablaTarifas">
            <button id="toggleTarifas" type="button">Mostrar tarifas</button>
            <div id="tarifasContainer" aria-hidden="true"></div>
        </section>

        <section id="tablaFormulario">
            <form action="/pipisos/respuestaFolleto.php" method="post" novalidate id="solicitarFolletoForm">
                <label for="nombre">Nombre*:</label>
                <input type="text" id="nombre" name="nombre" maxlength="200" 
                       placeholder="Tu nombre completo"><br><br>

                <label for="email">Correo electrónico*:</label>
                <input type="email" id="email" name="email" maxlength="200"
                       placeholder="ejemplo@dominio.com"><br><br>

                <label for="direccion">Dirección postal* (calle, nº, cp, localidad):</label>
                <input type="text" id="direccion" name="direccion" maxlength="400"
                       placeholder="Calle, número, código postal y localidad"><br><br>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" maxlength="30"
                       placeholder="Número de teléfono (opcional)"><br><br>

                <label for="paginas">Número de páginas*:</label>
                <input type="number" id="paginas" name="paginas" min="1" value="8"
                       placeholder="Mínimo 1 página"><br><br>

                <label for="fotos">Número de fotos:</label>
                <input type="number" id="fotos" name="fotos" min="0" value="2"
                       placeholder="Número de fotos a incluir"><br><br>

                <label for="color">Color de portada:</label>
                <select id="color" name="color">
                    <option value="blanco">Blanco y negro</option>
                    <option value="color">Color</option>
                </select>
                <br><br>

                <label for="resolucion">Resolución de fotos:</label>
                <select id="resolucion" name="resolucion">
                    <option value="baja">Baja (150 DPI)</option>
                    <option value="alta">Alta (300 DPI)</option>
                </select>
                <br><br>

                <label for="copias">Número de copias*:</label>
                <input type="number" id="copias" name="copias" min="1" max="999" value="1" required><br><br>

                <label for="anuncio">Anuncio (seleccione):</label>
                <select id="anuncio" name="anuncio" required>
                    <option value="">--Seleccione--</option>
                    <option value="atico">Ático en Barcelona</option>
                    <option value="apartamento">Apartamento en Sevilla</option>
                    <option value="chalet">Chalet en Málaga</option>
                </select>
                <br><br>

                <p>Impresión:</p>
                <label><input type="radio" name="impresion" value="bn" checked> Blanco y negro</label>
                <label><input type="radio" name="impresion" value="color"> Color</label>
                <br><br>

                <label><input type="checkbox" name="mostrar_precio" value="si"> Mostrar precio en el folleto</label>
                <br><br>

                <label for="texto_adicional">Texto adicional:</label><br>
                <textarea id="texto_adicional" name="texto_adicional" rows="4" cols="60" maxlength="4000"></textarea>
                <br><br>

                <button type="submit">Enviar solicitud</button>
                <button type="reset">Borrar todo</button>
            </form>
        </section>
    </section>
</main>

<script src="/pipisos/js/validations.js" defer></script>

<?php require_once __DIR__ . '/inc/footer.php'; ?>