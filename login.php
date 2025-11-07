<?php
session_start();

// Lectura de cookie para "recordarme" si no se ha enviado el formulario
$userValue = '';
$passValue = '';
$userError = false;
$passError = false;
$errorMessages = [];
$recordarChecked = false;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Si existe cookie de recordar usuario, precargar el campo usuario
    if (!empty($_COOKIE['recordar_usuario'])) {
        // No confiar en la cookie sin sanear: la mostraremos usando htmlspecialchars al imprimir
        $userValue = (string) $_COOKIE['recordar_usuario'];
        $recordarChecked = true;
    }
} 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userValue = trim($_POST['user'] ?? '');
    $passValue = trim($_POST['pass'] ?? '');
    $recordar = isset($_POST['recordar']);
    $recordarChecked = $recordar;

    if ($userValue === '') {
        $userError = true;
        $errorMessages[] = "El usuario no puede estar vacío.";
    }
    if ($passValue === '') {
        $passError = true;
        $errorMessages[] = "La contraseña no puede estar vacía.";
    }

    if (empty($errorMessages)) {
        $usuarios = require __DIR__ . '/data/usuarios.php';
        $usuarioEncontrado = null;
        foreach ($usuarios as $u) {
            if ($u['user'] === $userValue) {
                $usuarioEncontrado = $u;
                break;
            }
        }

        if ($usuarioEncontrado && $usuarioEncontrado['pass'] === $passValue) {
            session_regenerate_id(true);
            $_SESSION['usuario'] = $userValue;
            $_SESSION['estilo'] = $usuarioEncontrado['estilo'];

            // Preparar opciones seguras para setcookie
            $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            $cookieOptions = [
                'expires' => time() + (90 * 24 * 60 * 60),
                'path' => '/',
                'secure' => $secure,
                'httponly' => true,
                'samesite' => 'Lax'
            ];

            if ($recordar) {
                // Guardar solo el nombre de usuario y estilo (nunca la contraseña)
                setcookie('recordar_usuario', $userValue, $cookieOptions);
                setcookie('recordar_estilo', $usuarioEncontrado['estilo'], $cookieOptions);
                // ultima_visita no necesita httponly necesariamente, pero lo volvemos httponly también
                setcookie('ultima_visita', date('d/m/Y H:i'), $cookieOptions);
            } else {
                // Si no quiere recordar, eliminar cookies antiguas (si existen)
                setcookie('recordar_usuario', '', ['expires' => time() - 3600, 'path' => '/', 'samesite' => 'Lax']);
                setcookie('recordar_estilo', '', ['expires' => time() - 3600, 'path' => '/', 'samesite' => 'Lax']);
                setcookie('ultima_visita', '', ['expires' => time() - 3600, 'path' => '/', 'samesite' => 'Lax']);
            }

            header('Location: /pipisos/index.php');
            exit;
        } else {
            $errorMessages[] = "Usuario o contraseña incorrectos.";
            $userError = $passError = true;
        }
    }
}

require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
  <section class="acceso-usuario">
    <h1>Acceso de usuarios</h1>
    <p>Introduce tu nombre de usuario y contraseña para acceder a la parte privada.</p>

    <?php if (!empty($errorMessages)): ?>
      <div class="error-list">
        <ul>
          <?php foreach ($errorMessages as $msg): ?>
            <li><?= htmlspecialchars($msg, ENT_QUOTES) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="/pipisos/login.php" method="post">
      <label for="user"><span class="icon-user-o"></span> Usuario:</label><br>
      <input
        type="text"
        id="user"
        name="user"
        maxlength="200"
        value="<?= htmlspecialchars($userValue, ENT_QUOTES) ?>"
        placeholder="<?= $userError ? 'Usuario incorrecto' : 'Introduce tu usuario' ?>"
        class="<?= $userError ? 'input-error' : '' ?>"
      >
      <br><br>

      <label for="pass"><span class="icon-key"></span> Contraseña:</label><br>
      <input
        type="password"
        id="pass"
        name="pass"
        maxlength="200"
        placeholder="<?= $passError ? 'Contraseña incorrecta' : 'Introduce tu contraseña' ?>"
        class="<?= $passError ? 'input-error' : '' ?>"
      >
      <br><br>

      <label>
        <input type="checkbox" name="recordar" <?= $recordarChecked ? 'checked' : '' ?>>
        Recordarme en este equipo
      </label>
      <br><br>

      <button type="submit">Entrar</button>
      <button type="reset">Limpiar</button>
    </form>

    <p><a href="/pipisos/registro.php">¿No tienes cuenta? Regístrate</a></p>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
