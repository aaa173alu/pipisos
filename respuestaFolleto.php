<?php
session_start();

// Si no viene por POST, volvemos al formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /pipisos/solicitar-folleto.php');
    exit;
}

// Recoger y sanitizar entradas
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$direccion = trim($_POST['direccion'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$paginas = isset($_POST['paginas']) ? intval($_POST['paginas']) : 0;
$fotos = isset($_POST['fotos']) ? intval($_POST['fotos']) : 0;
$color = $_POST['color'] ?? 'blanco';
$resolucion = $_POST['resolucion'] ?? 'baja';
$copias = isset($_POST['copias']) ? intval($_POST['copias']) : 0;
$anuncio = $_POST['anuncio'] ?? '';
$impresion = $_POST['impresion'] ?? 'bn';
$mostrar_precio = isset($_POST['mostrar_precio']) ? 'si' : 'no';
$texto_adicional = trim($_POST['texto_adicional'] ?? '');

$errors = [];

// Validaciones básicas
if ($nombre === '') $errors[] = 'El nombre es obligatorio.';
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Correo electrónico inválido o vacío.';
if ($direccion === '') $errors[] = 'La dirección postal es obligatoria.';
if ($paginas < 1) $errors[] = 'El número de páginas debe ser al menos 1.';
if ($fotos < 0) $errors[] = 'El número de fotos no puede ser negativo.';
if ($copias < 1) $errors[] = 'El número de copias debe ser al menos 1.';
if ($anuncio === '') $errors[] = 'Debes seleccionar un anuncio.';
$allowed_colors = ['blanco','color'];
if (!in_array($color, $allowed_colors, true)) $errors[] = 'Color de portada no válido.';
$allowed_resol = ['baja','alta'];
if (!in_array($resolucion, $allowed_resol, true)) $errors[] = 'Resolución no válida.';

// Si hay errores, guardamos y redirigimos
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    // Guardar valores previos (para rellenar el formulario)
    $_SESSION['old'] = [
        'nombre'=>$nombre,'email'=>$email,'direccion'=>$direccion,'telefono'=>$telefono,
        'paginas'=>$paginas,'fotos'=>$fotos,'color'=>$color,'resolucion'=>$resolucion,
        'copias'=>$copias,'anuncio'=>$anuncio,'impresion'=>$impresion,'mostrar_precio'=>($mostrar_precio==='si'?'si':''),
        'texto_adicional'=>$texto_adicional
    ];
    header('Location: /pipisos/solicitar-folleto.php');
    exit;
}

// Si no hay errores, continúa el procesamiento normal (mostrar confirmación, calcular precios, enviar email, etc.)
// ... aquí puedes reutilizar la lógica que ya tenías para el cálculo y la salida.
// Ejemplo simplificado de respuesta:
$title = "PI - Respuesta solicitud folleto";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
  <section>
    <h2>Solicitud recibida</h2>
    <p>Gracias <?= htmlspecialchars($nombre) ?>, hemos recibido tu solicitud. Te enviaremos un correo a <?= htmlspecialchars($email) ?> con la confirmación.</p>
    <!-- aquí más detalle si necesitas -->
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
