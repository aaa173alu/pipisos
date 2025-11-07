<?php
session_start();

$title = "Registro - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
  <section class="registro">
    <h1>Registro</h1>

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

    <form action="/pipisos/respuestaRegistro.php" method="post" enctype="multipart/form-data" novalidate
      id="registroForm">
      <label for="usuario"><span class="icon-user-o"></span> Nombre de usuario:</label>
      <input type="text" id="usuario" name="usuario" maxlength="200"
             placeholder="Elige un nombre de usuario"
             value="<?= htmlspecialchars($old['usuario'] ?? '') ?>"><br>

      <label for="clave"><span class="icon-key"></span> Contraseña:</label>
      <input type="password" id="clave" name="clave" maxlength="200"
             placeholder="Mínimo 6 caracteres, con letra y número"><br>

      <label for="clave2"><span class="icon-key"></span> Repetir contraseña:</label>
      <input type="password" id="clave2" name="clave2" maxlength="200"
             placeholder="Repite la contraseña"><br>

      <label for="email"><span class="icon-mail"></span> Correo electrónico:</label>
      <input type="email" id="email" name="email"
             placeholder="ejemplo@dominio.com"
             value="<?= htmlspecialchars($old['email'] ?? '') ?>"><br>

      <p>Sexo:</p>
      <label><input type="radio" name="sexo" value="hombre" <?= (isset($old['sexo']) && $old['sexo']==='hombre')? 'checked':'' ?>> Hombre</label>
      <label><input type="radio" name="sexo" value="mujer" <?= (isset($old['sexo']) && $old['sexo']==='mujer')? 'checked':'' ?>> Mujer</label>
      <label><input type="radio" name="sexo" value="otro" <?= (isset($old['sexo']) && $old['sexo']==='otro')? 'checked':'' ?>> Otro</label><br>

      <label for="fecha">Fecha de nacimiento:</label>
      <input type="date" id="fecha" name="fecha"
             placeholder="DD/MM/AAAA"
             value="<?= htmlspecialchars($old['fecha'] ?? '') ?>"><br>

      <label for="ciudad">Ciudad:</label>
      <input type="text" id="ciudad" name="ciudad"
             placeholder="Tu ciudad"
             value="<?= htmlspecialchars($old['ciudad'] ?? '') ?>"><br>

      <label for="pais">País:</label>
      <select id="pais" name="pais">
        <option value="">--Selecciona--</option>
        <?php
        $countries = ['España','Francia','Italia','Alemania','Portugal','México','Argentina','Colombia','Chile','Estados Unidos'];
        foreach ($countries as $c): ?>
          <option value="<?= htmlspecialchars($c) ?>" <?= (isset($old['pais']) && $old['pais']===$c)? 'selected':'' ?>><?= htmlspecialchars($c) ?></option>
        <?php endforeach; ?>
      </select><br>

      <label for="foto">Foto:</label>
      <input type="file" id="foto" name="foto" accept="image/*"><br>

      <button type="submit">Registrarse</button>
      <a href="/pipisos/login.php" class="link-secondary">¿Ya tienes cuenta? Entrar</a>
    </form>
  </section>
</main>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
