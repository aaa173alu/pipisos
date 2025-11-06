<?php
require_once __DIR__ . '/inc/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$tipo = $_POST['tipo'] ?? '';
$vivienda = $_POST['vivienda'] ?? '';
$titulo = trim($_POST['titulo'] ?? '');
$texto = trim($_POST['texto'] ?? '');
$fecha = $_POST['fecha'] ?? '';
$ciudad = trim($_POST['ciudad'] ?? '');
$pais = trim($_POST['pais'] ?? '');
$precio = is_numeric($_POST['precio'] ?? null) ? (float) $_POST['precio'] : null;

$caracteristicas = [
    'superficie' => trim($_POST['superficie'] ?? ''),
    'habitaciones' => isset($_POST['habitaciones']) ? (int) $_POST['habitaciones'] : 0,
    'banos' => isset($_POST['banos']) ? (int) $_POST['banos'] : 0,
    'planta' => trim($_POST['planta'] ?? ''),
    'anio' => isset($_POST['anio']) ? (int) $_POST['anio'] : null,
];

$errors = [];
if (!in_array($tipo, ['venta', 'alquiler'])) {
    $errors[] = 'Tipo inválido.';
}
if ($vivienda === '') {
    $errors[] = 'Tipo de vivienda requerido.';
}
if ($titulo === '') {
    $errors[] = 'Título requerido.';
}
if ($precio === null || $precio < 0) {
    $errors[] = 'Precio inválido.';
}

header('Content-Type: application/json');

if ($errors) {
    http_response_code(400);
    echo json_encode(['errors' => $errors]);
    exit;
}

// Aquí iría el código para guardar el anuncio en la base de datos
// Por ahora solo simularemos éxito

http_response_code(200);
echo json_encode(['success' => true]);
exit;