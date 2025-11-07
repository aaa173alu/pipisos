<?php
// registro.php — validación en servidor y errores inline por campo (sin JavaScript)
$title = "Registro - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

// variables para renderizado
$errors = []; // ['campo' => 'mensaje...']
$old = [];    // valores previos

// Lista de países (mantén la tuya si prefieres otra lista)
$countries = ['España','Francia','Italia','Alemania','Portugal','México','Argentina','Colombia','Chile','Estados Unidos'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y sanitizar
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $clave2 = $_POST['clave2'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $sexo = $_POST['sexo'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $ciudad = trim($_POST['ciudad'] ?? '');
    $pais = $_POST['pais'] ?? '';

    // Guardar valores previos (no guardamos las contraseñas por seguridad)
    $old = [
        'usuario' => $usuario,
        'email' => $email,
        'sexo' => $sexo,
        'fecha' => $fecha,
        'ciudad' => $ciudad,
        'pais' => $pais
    ];

    // Validaciones por campo (personaliza mensajes/reglas si lo deseas)
    if ($usuario === '') {
        $errors['usuario'] = 'El nombre de usuario es obligatorio.';
    } elseif (mb_strlen($usuario) < 3) {
        $errors['usuario'] = 'El nombre de usuario debe tener al menos 3 caracteres.';
    }

    if ($clave === '') {
        $errors['clave'] = 'La contraseña es obligatoria.';
    } elseif (strlen($clave) < 6) {
        $errors['clave'] = 'La contraseña debe tener al menos 6 caracteres.';
    } elseif (!preg_match('/[A-Za-z]/', $clave) || !preg_match('/\d/', $clave)) {
        $errors['clave'] = 'La contraseña debe contener al menos una letra y un número.';
    }

    if ($clave2 === '') {
        $errors['clave2'] = 'Repite la contraseña.';
    } elseif ($clave !== $clave2) {
        $errors['clave2'] = 'Las contraseñas no coinciden.';
    }

    if ($email === '') {
        $errors['email'] = 'El correo electrónico es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Formato de correo inválido.';
    }

    $allowed_sexo = ['hombre','mujer','otro',''];
    if (!in_array($sexo, $allowed_sexo, true)) {
        $errors['sexo'] = 'Opción de sexo inválida.';
    }

    if ($fecha !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
        $errors['fecha'] = 'Formato de fecha inválido (AAAA-MM-DD).';
    }

    if ($ciudad !== '' && mb_strlen($ciudad) < 2) {
        $errors['ciudad'] = 'Ciudad demasiado corta.';
    }

    if ($pais !== '' && !in_array($pais, $countries, true)) {
        $errors['pais'] = 'País no válido.';
    }

    // Foto (opcional)
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
            $errors['foto'] = 'Error al subir la foto.';
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['foto']['tmp_name']);
            finfo_close($finfo);
            $allowed = ['image/jpeg','image/png','image/gif'];
            if (!in_array($mime, $allowed, true)) {
                $errors['foto'] = 'Tipo de imagen no permitido (JPG/PNG/GIF).';
            } elseif ($_FILES['foto']['size'] > 2 * 1024 * 1024) {
                $errors['foto'] = 'La foto no puede superar 2MB.';
            }
        }
    }

    // Si no hay errores: procesar registro (hash de contraseña, BD, mover imagen...)
    if (empty($errors)) {
        // Ejemplo mínimo: hash de contraseña (usa prepared statements para BD)
        $hash = password_hash($clave, PASSWORD_DEFAULT);

        // Aquí deberías insertar en la BD y mover la foto si procede.
        // Una vez registrado, puedes redirigir a login o mostrar confirmación:
        ?>
        <main>
          <section class="registro">
            <h1>Registro completado</h1>
            <p>Usuario <?= htmlspecialchars($usuario) ?> registrado correctamente.</p>
            <p><a href="/pipisos/login.php">Iniciar sesión</a></p>
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
  <section class="registro">
    <h1>Registro</h1>

    <form action="" method="post" enctype="multipart/form-data" id="registroForm" novalidate>
      <label for="usuario"><span class="icon-user-o"></span> Nombre de usuario:</label>
      <input type="text" id="usuario" name="usuario" maxlength="200"
             placeholder="Elige un nombre de usuario"
             value="<?= htmlspecialchars($old['usuario'] ?? '') ?>"
             class="<?= isset($errors['usuario']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['usuario'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['usuario']) ?></div>
      <?php endif; ?>
      <br>

      <label for="clave"><span class="icon-key"></span> Contraseña:</label>
      <input type="password" id="clave" name="clave" maxlength="200"
             placeholder="Mínimo 6 caracteres, con letra y número"
             class="<?= isset($errors['clave']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['clave'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['clave']) ?></div>
      <?php endif; ?>
      <br>

      <label for="clave2"><span class="icon-key"></span> Repetir contraseña:</label>
      <input type="password" id="clave2" name="clave2" maxlength="200"
             placeholder="Repite la contraseña"
             class="<?= isset($errors['clave2']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['clave2'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['clave2']) ?></div>
      <?php endif; ?>
      <br>

      <label for="email"><span class="icon-mail"></span> Correo electrónico:</label>
      <input type="email" id="email" name="email"
             placeholder="ejemplo@dominio.com"
             value="<?= htmlspecialchars($old['email'] ?? '') ?>"
             class="<?= isset($errors['email']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['email'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['email']) ?></div>
      <?php endif; ?>
      <br>

      <p>Sexo:</p>
      <label><input type="radio" name="sexo" value="hombre" <?= (isset($old['sexo']) && $old['sexo']==='hombre')? 'checked':'' ?> > Hombre</label>
      <label><input type="radio" name="sexo" value="mujer" <?= (isset($old['sexo']) && $old['sexo']==='mujer')? 'checked':'' ?> > Mujer</label>
      <label><input type="radio" name="sexo" value="otro" <?= (isset($old['sexo']) && $old['sexo']==='otro')? 'checked':'' ?> > Otro</label>
      <?php if (isset($errors['sexo'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['sexo']) ?></div>
      <?php endif; ?>
      <br>

      <label for="fecha">Fecha de nacimiento:</label>
      <input type="date" id="fecha" name="fecha"
             placeholder="DD/MM/AAAA"
             value="<?= htmlspecialchars($old['fecha'] ?? '') ?>"
             class="<?= isset($errors['fecha']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['fecha'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['fecha']) ?></div>
      <?php endif; ?>
      <br>

      <label for="ciudad">Ciudad:</label>
      <input type="text" id="ciudad" name="ciudad"
             placeholder="Tu ciudad"
             value="<?= htmlspecialchars($old['ciudad'] ?? '') ?>"
             class="<?= isset($errors['ciudad']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['ciudad'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['ciudad']) ?></div>
      <?php endif; ?>
      <br>

      <label for="pais">País:</label>
      <select id="pais" name="pais" class="<?= isset($errors['pais']) ? 'input-error' : '' ?>">
        <option value="">--Selecciona--</option>
        <?php foreach ($countries as $c): ?>
          <option value="<?= htmlspecialchars($c) ?>" <?= (isset($old['pais']) && $old['pais']===$c)? 'selected':'' ?>><?= htmlspecialchars($c) ?></option>
        <?php endforeach; ?>
      </select>
      <?php if (isset($errors['pais'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['pais']) ?></div>
      <?php endif; ?>
      <br>

      <label for="foto">Foto:</label>
      <input type="file" id="foto" name="foto" accept="image/*" class="<?= isset($errors['foto']) ? 'input-error' : '' ?>">
      <?php if (isset($errors['foto'])): ?>
        <div class="error-field"><?= htmlspecialchars($errors['foto']) ?></div>
      <?php endif; ?>
      <br>

      <button type="submit">Registrarse</button>
      <a href="/pipisos/login.php" class="link-secondary">¿Ya tienes cuenta? Entrar</a>
    </form>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
