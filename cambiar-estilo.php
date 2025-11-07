<?php
require_once __DIR__ . '/inc/config.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: /pipisos/login.php');
    exit;
}

$estilosDisponibles = [
    'estilos.css' => 'Estilo normal',
    'oscuro.css' => 'Modo oscuro',
    'contrastes.css' => 'Alto contraste',
    'letraGrande.css' => 'Letra grande',
    'contrasteGrande.css' => 'Letra grande y alto contraste'
];

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoEstilo = $_POST['estilo'] ?? '';
    
    if (array_key_exists($nuevoEstilo, $estilosDisponibles)) {
        $_SESSION['estilo'] = $nuevoEstilo;
        
        if (isset($_COOKIE['recordar_usuario'])) {
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            $cookieOptions = [
                'expires' => time() + (90 * 24 * 60 * 60),
                'path' => '/',
                'secure' => $secure,
                'httponly' => true,
                'samesite' => 'Lax'
            ];
            setcookie('recordar_estilo', $nuevoEstilo, $cookieOptions);
        }
        
        $mensaje = 'Estilo actualizado correctamente.';
    } else {
        $mensaje = 'Estilo no válido.';
    }
}

$estiloActual = $_SESSION['estilo'] ?? 'estilos.css';

$title = "Cambiar Estilo - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<main>
    <section class="cambiar-estilo">
        <h1>Cambiar Estilo</h1>
        
        <?php if ($mensaje): ?>
            <div class="mensaje-exito">
                <p><?= htmlspecialchars($mensaje) ?></p>
            </div>
        <?php endif; ?>
        
        <form method="post" action="">
            <label for="estilo">Selecciona un estilo:</label><br>
            <select id="estilo" name="estilo">
                <?php foreach ($estilosDisponibles as $archivo => $nombre): ?>
                    <option value="<?= htmlspecialchars($archivo) ?>" <?= $archivo === $estiloActual ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nombre) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br><br>
            
            <button type="submit">Cambiar estilo</button>
            <a href="/pipisos/mi-perfil.php">Volver al perfil</a>
        </form>
    </section>
</main>

<style>
.cambiar-estilo {
    max-width: 600px;
    margin: 2em auto;
    padding: 0 1em;
}

.cambiar-estilo select {
    width: 100%;
    padding: 0.5em;
    font-size: 1em;
    margin-top: 0.5em;
}

.cambiar-estilo button {
    padding: 0.75em 1.5em;
    font-size: 1em;
    margin-right: 1em;
}

.mensaje-exito {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 1em;
    border-radius: 4px;
    margin-bottom: 1em;
}
</style>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
