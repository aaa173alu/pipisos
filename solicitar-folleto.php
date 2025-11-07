<?php
session_start();

$title = "Solicitar folleto - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

// recoger errores y valores previos (old) desde sesión
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
    <section>
        <h2>Solicitar folleto publicitario</h2>
        <p>Rellena el formulario para solicitar tu folleto personalizado.</p>

        <?php if (!empty($errors)): ?>
            <div class="errores" role="alert">
                <p>Por favor corrige los siguientes errores:</p>
                <ul>
                    <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <section id="tablaTarifas">
            <button id="toggleTarifas" type="button">Mostrar tarifas</button>
            <div id="tarifasContainer" aria-hidden="true"></div>
        </section>

        <section id="tablaFormulario">
            <form action="/pipisos/respuestaFolleto.php" method="post" novalidate id="solicitarFolletoForm">
                <label for="nombre">Nombre*:</label>
                <input type="text" id="nombre" name="nombre" maxlength="200"
                       placeholder="Tu nombre completo"
                       value="<?= htmlspecialchars($old['nombre'] ?? '') ?>"><br><br>

                <label for="email">Correo electrónico*:</label>
                <input type="email" id="email" name="email" maxlength="200"
                       placeholder="ejemplo@dominio.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"><br><br>

                <label for="direccion">Dirección postal* (calle, nº, cp, localidad):</label>
                <input type="text" id="direccion" name="direccion" maxlength="400"
                       placeholder="Calle, número, código postal y localidad"
                       value="<?= htmlspecialchars($old['direccion'] ?? '') ?>"><br><br>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" maxlength="30"
                       placeholder="Número de teléfono (opcional)"
                       value="<?= htmlspecialchars($old['telefono'] ?? '') ?>"><br><br>

                <label for="paginas">Número de páginas*:</label>
                <input type="number" id="paginas" name="paginas" min="1" value="<?= htmlspecialchars($old['paginas'] ?? '8') ?>"
                       placeholder="Mínimo 1 página"><br><br>

                <label for="fotos">Número de fotos:</label>
                <input type="number" id="fotos" name="fotos" min="0" value="<?= htmlspecialchars($old['fotos'] ?? '2') ?>"
                       placeholder="Número de fotos a incluir"><br><br>

                <label for="color">Color de portada:</label>
                <select id="color" name="color">
                    <option value="blanco" <?= (isset($old['color']) && $old['color']==='blanco') ? 'selected' : '' ?>>Blanco y negro</option>
                    <option value="color" <?= (isset($old['color']) && $old['color']==='color') ? 'selected' : '' ?>>Color</option>
                </select>
                <br><br>

                <label for="resolucion">Resolución de fotos:</label>
                <select id="resolucion" name="resolucion">
                    <option value="baja" <?= (isset($old['resolucion']) && $old['resolucion']==='baja') ? 'selected' : '' ?>>Baja (150 DPI)</option>
                    <option value="alta" <?= (isset($old['resolucion']) && $old['resolucion']==='alta') ? 'selected' : '' ?>>Alta (300 DPI)</option>
                </select>
                <br><br>

                <label for="copias">Número de copias*:</label>
                <input type="number" id="copias" name="copias" min="1" max="999" value="<?= htmlspecialchars($old['copias'] ?? '1') ?>" required><br><br>

                <label for="anuncio">Anuncio (seleccione):</label>
                <select id="anuncio" name="anuncio" required>
                    <option value="">--Seleccione--</option>
                    <option value="atico" <?= (isset($old['anuncio']) && $old['anuncio']==='atico')? 'selected':'' ?>>Ático en Barcelona</option>
                    <option value="apartamento" <?= (isset($old['anuncio']) && $old['anuncio']==='apartamento')? 'selected':'' ?>>Apartamento en Sevilla</option>
                    <option value="chalet" <?= (isset($old['anuncio']) && $old['anuncio']==='chalet')? 'selected':'' ?>>Chalet en Málaga</option>
                </select>
                <br><br>

                <p>Impresión:</p>
                <label><input type="radio" name="impresion" value="bn" <?= (!isset($old['impresion']) || $old['impresion']==='bn') ? 'checked' : '' ?>> Blanco y negro</label>
                <label><input type="radio" name="impresion" value="color" <?= (isset($old['impresion']) && $old['impresion']==='color') ? 'checked' : '' ?>> Color</label>
                <br><br>

                <label><input type="checkbox" name="mostrar_precio" value="si" <?= (isset($old['mostrar_precio']) && $old['mostrar_precio']==='si') ? 'checked' : '' ?>> Mostrar precio en el folleto</label>
                <br><br>

                <label for="texto_adicional">Texto adicional:</label><br>
                <textarea id="texto_adicional" name="texto_adicional" rows="4" cols="60" maxlength="4000"><?= htmlspecialchars($old['texto_adicional'] ?? '') ?></textarea>
                <br><br>

                <button type="submit">Enviar solicitud</button>
                <button type="reset">Borrar todo</button>
            </form>
        </section>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
