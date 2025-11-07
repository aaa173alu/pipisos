<?php

$title = "Solicitar folleto - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

// variables para renderizado
$errors = []; // ['campo' => 'mensaje...']
$old = [];    // valores previos

// valores por defecto / opciones permitidas
$allowed_colors = ['blanco', 'color'];
$allowed_resol = ['baja', 'alta'];
$allowed_anuncios = ['atico','apartamento','chalet'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $paginas = isset($_POST['paginas']) && $_POST['paginas'] !== '' ? intval($_POST['paginas']) : null;
    $fotos = isset($_POST['fotos']) && $_POST['fotos'] !== '' ? intval($_POST['fotos']) : null;
    $color = $_POST['color'] ?? 'blanco';
    $resolucion = $_POST['resolucion'] ?? 'baja';
    $copias = isset($_POST['copias']) && $_POST['copias'] !== '' ? intval($_POST['copias']) : null;
    $anuncio = $_POST['anuncio'] ?? '';
    $impresion = $_POST['impresion'] ?? '';
    $mostrar_precio = isset($_POST['mostrar_precio']) ? 'si' : '';
    $texto_adicional = trim($_POST['texto_adicional'] ?? '');

    // Guardar valores previos
    $old = [
        'nombre' => $nombre,
        'email' => $email,
        'direccion' => $direccion,
        'telefono' => $telefono,
        'paginas' => $paginas,
        'fotos' => $fotos,
        'color' => $color,
        'resolucion' => $resolucion,
        'copias' => $copias,
        'anuncio' => $anuncio,
        'impresion' => $impresion,
        'mostrar_precio' => $mostrar_precio,
        'texto_adicional' => $texto_adicional
    ];

    // Validaciones (todos los campos obligatorios salvo teléfono y texto_adicional)
    if ($nombre === '') {
        $errors['nombre'] = 'Completa este campo.';
    }

    if ($email === '') {
        $errors['email'] = 'Completa este campo.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Correo electrónico inválido.';
    }

    if ($direccion === '') {
        $errors['direccion'] = 'Completa este campo.';
    }

    // teléfono opcional: si se rellena, validar formato simple (opcional)
    if ($telefono !== '' && !preg_match('/^[0-9+\-\s()]{6,30}$/', $telefono)) {
        $errors['telefono'] = 'Formato de teléfono inválido.';
    }

    if ($paginas === null || $paginas < 1) {
        $errors['paginas'] = 'Indica al menos 1 página.';
    }

    if ($fotos === null || $fotos < 0) {
        $errors['fotos'] = 'Número de fotos inválido.';
    }

    if (!in_array($color, $allowed_colors, true)) {
        $errors['color'] = 'Color no válido.';
    }

    if (!in_array($resolucion, $allowed_resol, true)) {
        $errors['resolucion'] = 'Resolución no válida.';
    }

    if ($copias === null || $copias < 1 || $copias > 999) {
        $errors['copias'] = 'Número de copias inválido (1-999).';
    }

    if ($anuncio === '') {
        $errors['anuncio'] = 'Selecciona un anuncio.';
    } elseif (!in_array($anuncio, $allowed_anuncios, true)) {
        $errors['anuncio'] = 'Anuncio no válido.';
    }

    $allowed_impresion = ['bn','color'];
    if ($impresion === '' || !in_array($impresion, $allowed_impresion, true)) {
        $errors['impresion'] = 'Selecciona tipo de impresión.';
    }

    // límite de longitud texto adicional
    if (mb_strlen($texto_adicional) > 4000) {
        $errors['texto_adicional'] = 'El texto adicional no puede superar 4000 caracteres.';
    }

    // Si no hay errores: procesar solicitud (ej. enviar correo, guardar en BD, etc.)
    if (empty($errors)) {
        // Aquí tu lógica de procesamiento (ejemplo básico)
        // Puedes calcular precio, enviar email, guardar en BD...
        ?>
        <main>
          <section>
            <h2>Solicitud recibida</h2>
            <p>Gracias <?= htmlspecialchars($nombre) ?>, hemos recibido tu solicitud.</p>
            <p>Te enviaremos confirmación a <?= htmlspecialchars($email) ?>.</p>
            <p><a href="/pipisos/index.php">Volver al inicio</a></p>
          </section>
        </main>
        <?php
        require_once __DIR__ . '/inc/footer.php';
        exit;
    }
}
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
            <form action="" method="post" novalidate id="solicitarFolletoForm">
                <label for="nombre">Nombre*:</label>
                <input type="text" id="nombre" name="nombre" maxlength="200"
                       placeholder="Tu nombre completo"
                       value="<?= htmlspecialchars($old['nombre'] ?? '') ?>"
                       class="<?= isset($errors['nombre']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['nombre'])): ?><div class="error-field"><?= htmlspecialchars($errors['nombre']) ?></div><?php endif; ?>
                <br><br>

                <label for="email">Correo electrónico*:</label>
                <input type="email" id="email" name="email" maxlength="200"
                       placeholder="ejemplo@dominio.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                       class="<?= isset($errors['email']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['email'])): ?><div class="error-field"><?= htmlspecialchars($errors['email']) ?></div><?php endif; ?>
                <br><br>

                <label for="direccion">Dirección postal* (calle, nº, cp, localidad):</label>
                <input type="text" id="direccion" name="direccion" maxlength="400"
                       placeholder="Calle, número, código postal y localidad"
                       value="<?= htmlspecialchars($old['direccion'] ?? '') ?>"
                       class="<?= isset($errors['direccion']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['direccion'])): ?><div class="error-field"><?= htmlspecialchars($errors['direccion']) ?></div><?php endif; ?>
                <br><br>

                <label for="telefono">Teléfono:</label>
                <input type="tel" id="telefono" name="telefono" maxlength="30"
                       placeholder="Número de teléfono (opcional)"
                       value="<?= htmlspecialchars($old['telefono'] ?? '') ?>"
                       class="<?= isset($errors['telefono']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['telefono'])): ?><div class="error-field"><?= htmlspecialchars($errors['telefono']) ?></div><?php endif; ?>
                <br><br>

                <label for="paginas">Número de páginas*:</label>
                <input type="number" id="paginas" name="paginas" min="1" value="<?= htmlspecialchars($old['paginas'] ?? '8') ?>"
                       placeholder="Mínimo 1 página" class="<?= isset($errors['paginas']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['paginas'])): ?><div class="error-field"><?= htmlspecialchars($errors['paginas']) ?></div><?php endif; ?>
                <br><br>

                <label for="fotos">Número de fotos:</label>
                <input type="number" id="fotos" name="fotos" min="0" value="<?= htmlspecialchars($old['fotos'] ?? '2') ?>"
                       placeholder="Número de fotos a incluir" class="<?= isset($errors['fotos']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['fotos'])): ?><div class="error-field"><?= htmlspecialchars($errors['fotos']) ?></div><?php endif; ?>
                <br><br>

                <label for="color">Color de portada:</label>
                <select id="color" name="color" class="<?= isset($errors['color']) ? 'input-error' : '' ?>">
                    <option value="blanco" <?= (isset($old['color']) && $old['color']==='blanco') ? 'selected' : '' ?>>Blanco y negro</option>
                    <option value="color" <?= (isset($old['color']) && $old['color']==='color') ? 'selected' : '' ?>>Color</option>
                </select>
                <?php if (isset($errors['color'])): ?><div class="error-field"><?= htmlspecialchars($errors['color']) ?></div><?php endif; ?>
                <br><br>

                <label for="resolucion">Resolución de fotos:</label>
                <select id="resolucion" name="resolucion" class="<?= isset($errors['resolucion']) ? 'input-error' : '' ?>">
                    <option value="baja" <?= (isset($old['resolucion']) && $old['resolucion']==='baja') ? 'selected' : '' ?>>Baja (150 DPI)</option>
                    <option value="alta" <?= (isset($old['resolucion']) && $old['resolucion']==='alta') ? 'selected' : '' ?>>Alta (300 DPI)</option>
                </select>
                <?php if (isset($errors['resolucion'])): ?><div class="error-field"><?= htmlspecialchars($errors['resolucion']) ?></div><?php endif; ?>
                <br><br>

                <label for="copias">Número de copias*:</label>
                <input type="number" id="copias" name="copias" min="1" max="999" value="<?= htmlspecialchars($old['copias'] ?? '1') ?>" required
                       class="<?= isset($errors['copias']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['copias'])): ?><div class="error-field"><?= htmlspecialchars($errors['copias']) ?></div><?php endif; ?>
                <br><br>

                <label for="anuncio">Anuncio (seleccione):</label>
                <select id="anuncio" name="anuncio" required class="<?= isset($errors['anuncio']) ? 'input-error' : '' ?>">
                    <option value="">--Seleccione--</option>
                    <option value="atico" <?= (isset($old['anuncio']) && $old['anuncio']==='atico')? 'selected':'' ?>>Ático en Barcelona</option>
                    <option value="apartamento" <?= (isset($old['anuncio']) && $old['anuncio']==='apartamento')? 'selected':'' ?>>Apartamento en Sevilla</option>
                    <option value="chalet" <?= (isset($old['anuncio']) && $old['anuncio']==='chalet')? 'selected':'' ?>>Chalet en Málaga</option>
                </select>
                <?php if (isset($errors['anuncio'])): ?><div class="error-field"><?= htmlspecialchars($errors['anuncio']) ?></div><?php endif; ?>
                <br><br>

                <p>Impresión:</p>
                <label><input type="radio" name="impresion" value="bn" <?= (!isset($old['impresion']) || $old['impresion']==='bn') ? 'checked' : '' ?> > Blanco y negro</label>
                <label><input type="radio" name="impresion" value="color" <?= (isset($old['impresion']) && $old['impresion']==='color') ? 'checked' : '' ?> > Color</label>
                <?php if (isset($errors['impresion'])): ?><div class="error-field"><?= htmlspecialchars($errors['impresion']) ?></div><?php endif; ?>
                <br><br>

                <label><input type="checkbox" name="mostrar_precio" value="si" <?= (isset($old['mostrar_precio']) && $old['mostrar_precio']==='si') ? 'checked' : '' ?> > Mostrar precio en el folleto</label>
                <br><br>

                <label for="texto_adicional">Texto adicional:</label><br>
                <textarea id="texto_adicional" name="texto_adicional" rows="4" cols="60" maxlength="4000"
                          class="<?= isset($errors['texto_adicional']) ? 'input-error' : '' ?>"><?= htmlspecialchars($old['texto_adicional'] ?? '') ?></textarea>
                <?php if (isset($errors['texto_adicional'])): ?><div class="error-field"><?= htmlspecialchars($errors['texto_adicional']) ?></div><?php endif; ?>
                <br><br>

                <button type="submit">Enviar solicitud</button>
                <button type="reset">Borrar todo</button>
            </form>
        </section>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
