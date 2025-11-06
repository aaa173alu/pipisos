<?php

$title = "PI - Respuesta solicitud de folleto";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

function coste_folleto($paginas, $fotos, $color, $resolucion)
{
    // Tarifas de ejemplo — sustituye por las reales si las tienes
    $precio_por_pagina = 0.12;   // €/página
    $precio_por_foto = 0.45;     // €/foto
    $suplemento_color = ($color === 'color') ? 0.20 * $paginas : 0; // 0.20€/página extra si es color
    $suplemento_res = ($resolucion === 'alta') ? 0.10 * ($paginas + $fotos) : 0;
    $unitario = $precio_por_pagina * $paginas + $precio_por_foto * $fotos + $suplemento_color + $suplemento_res;
    return round($unitario, 2);
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/solicitar-folleto.php');
    exit;
}

// Leer campos (compatible con formularios conocidos)
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$paginas = isset($_POST['paginas']) ? intval($_POST['paginas']) : (isset($_POST['numero_paginas']) ? intval($_POST['numero_paginas']) : 0);
$fotos = isset($_POST['fotos']) ? intval($_POST['fotos']) : 0;
$color = $_POST['color'] ?? ($_POST['color_portada'] ?? 'blanco');
$resolucion = $_POST['resolucion'] ?? 'baja';
$copias = isset($_POST['copias']) ? max(1, intval($_POST['copias'])) : 1;
$anuncio = trim($_POST['anuncio'] ?? '');
$impresion = $_POST['impresion'] ?? 'digital';
$mostrar_precio = isset($_POST['mostrar_precio']) ? 'Sí' : 'No';
$texto_adicional = trim($_POST['texto_adicional'] ?? '');

if ($nombre === '')
    $errors[] = 'El nombre es obligatorio.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL))
    $errors[] = 'Correo electrónico inválido.';
if ($paginas < 1)
    $errors[] = 'Número de páginas inválido.';
if ($fotos < 0)
    $errors[] = 'Número de fotos inválido.';
if (!in_array($color, ['blanco', 'color']))
    $errors[] = 'Tipo de color inválido.';
if (!in_array($resolucion, ['baja', 'alta']))
    $errors[] = 'Resolución inválida.';
if ($copias < 1)
    $errors[] = 'Número de copias inválido.';

?>
<main>
    <section>
        <h2>Solicitud recibida</h2>

        <?php if ($errors): ?>
            <div class="errores">
                <p>Error(es):</p>
                <ul>
                    <?php foreach ($errors as $e)
                        echo '<li>' . htmlspecialchars($e) . '</li>'; ?>
                </ul>
                <p><a href="/pipisos/solicitar-folleto.php">Volver al formulario</a></p>
            </div>
        <?php else: ?>
            <?php $precio_unitario = coste_folleto($paginas, $fotos, $color, $resolucion); ?>
            <p>Gracias, <?php echo htmlspecialchars($nombre); ?>. A continuación los datos recibidos:</p>

            <table>
                <caption>Resumen de solicitud</caption>
                <tbody>
                    <tr>
                        <th scope="row">Nombre</th>
                        <td><?php echo htmlspecialchars($nombre); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Correo electrónico</th>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Dirección</th>
                        <td><?php echo htmlspecialchars($direccion); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Teléfono</th>
                        <td><?php echo htmlspecialchars($telefono); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Color de portada</th>
                        <td><?php echo htmlspecialchars($color); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Número de copias</th>
                        <td><?php echo $copias; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Resolución</th>
                        <td><?php echo htmlspecialchars($resolucion); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Anuncio</th>
                        <td><?php echo htmlspecialchars($anuncio); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Número de páginas</th>
                        <td><?php echo $paginas; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Número de fotos</th>
                        <td><?php echo $fotos; ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Impresión</th>
                        <td><?php echo htmlspecialchars($impresion); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Mostrar precio</th>
                        <td><?php echo htmlspecialchars($mostrar_precio); ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Texto adicional</th>
                        <td><?php echo nl2br(htmlspecialchars($texto_adicional)); ?></td>
                    </tr>
                </tbody>
            </table>

            <h3>Coste del folleto</h3>
            <p>Precio unitario (por folleto): <strong><?php echo number_format($precio_unitario, 2); ?> €</strong></p>
            <p>Precio total (<?php echo $copias; ?> copia(s)):
                <strong><?php echo number_format($precio_unitario * $copias, 2); ?> €</strong></p>

            <p>En breve recibirás un correo con más información.</p>
            <p><a href="/pipisos/index.php">Volver al inicio</a></p>
        <?php endif; ?>
    </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>