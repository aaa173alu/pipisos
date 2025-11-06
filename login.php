<?php
// login.php - validación en PHP usando data/usuarios.php
session_start();

// Inicializar valores y errores
$userValue = '';
$passValue = '';
$userError = false;
$passError = false;
$errorMessages = [];

// Si viene del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userValue = trim($_POST['user'] ?? '');
    $passValue = trim($_POST['pass'] ?? '');

    // Validar campos vacíos
    if ($userValue === '') {
        $userError = true;
        $errorMessages[] = "El usuario no puede estar vacío.";
    }
    if ($passValue === '') {
        $passError = true;
        $errorMessages[] = "La contraseña no puede estar vacía.";
    }

    // Si no hay errores de campos vacíos, comprobar credenciales
    if (empty($errorMessages)) {
        // Cargar lista de usuarios desde tu archivo
        $usuarios = require __DIR__ . '/data/usuarios.php';

        $usuarioEncontrado = null;
        foreach ($usuarios as $u) {
            if ($u['user'] === $userValue) {
                $usuarioEncontrado = $u;
                break;
            }
        }

        if ($usuarioEncontrado) {
            // Usuario existe → comprobar contraseña
            if ($usuarioEncontrado['pass'] === $passValue) {
                // ✅ Login correcto
                session_regenerate_id(true);
                $_SESSION['usuario'] = $userValue;
                header('Location: /pipisos/index.php');
                exit;
            } else {
                // ❌ Contraseña incorrecta
                $passError = true;
                $errorMessages[] = "Contraseña incorrecta.";
            }
        } else {
            // ❌ Usuario no encontrado
            $userError = true;
            $errorMessages[] = "Usuario incorrecto.";
        }
    }
}

// A partir de aquí se imprime HTML
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

      <button type="submit">Entrar</button>
      <button type="reset">Limpiar</button>
    </form>

    <p>
      <a href="/pipisos/registro.php">¿No tienes cuenta? Regístrate</a>
    </p>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
