<?php

$title = "Registro - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<link rel="stylesheet" href="/pipisos/css/validation.css">

<main>
  <section class="registro">
    <h1>Registro</h1>

    <form action="/pipisos/respuestaRegistro.php" method="post" enctype="multipart/form-data" novalidate
      id="registroForm">
      <label for="usuario"><span class="icon-user-o"></span> Nombre de usuario:</label>
      <input type="text" id="usuario" name="usuario" maxlength="200" 
             placeholder="Elige un nombre de usuario"><br>

      <label for="clave"><span class="icon-key"></span> Contraseña:</label>
      <input type="password" id="clave" name="clave" maxlength="200"
             placeholder="Mínimo 6 caracteres, con letra y número"><br>

      <label for="clave2"><span class="icon-key"></span> Repetir contraseña:</label>
      <input type="password" id="clave2" name="clave2" maxlength="200"
             placeholder="Repite la contraseña"><br>

      <label for="email"><span class="icon-mail"></span> Correo electrónico:</label>
      <input type="email" id="email" name="email"
             placeholder="ejemplo@dominio.com"><br>

      <p>Sexo:</p>
      <label><input type="radio" name="sexo" value="hombre"> Hombre</label>
      <label><input type="radio" name="sexo" value="mujer"> Mujer</label>
      <label><input type="radio" name="sexo" value="otro"> Otro</label><br>

      <label for="fecha">Fecha de nacimiento:</label>
      <input type="date" id="fecha" name="fecha" 
             placeholder="DD/MM/AAAA"><br>

      <label for="ciudad">Ciudad:</label>
      <input type="text" id="ciudad" name="ciudad"
             placeholder="Tu ciudad"><br>

      <label for="pais">País:</label>
      <select id="pais" name="pais">
        <option value="">--Selecciona--</option>
        <option value="España">España</option>
        <option value="Francia">Francia</option>
        <option value="Italia">Italia</option>
        <option value="Alemania">Alemania</option>
        <option value="Portugal">Portugal</option>
        <option value="México">México</option>
        <option value="Argentina">Argentina</option>
        <option value="Colombia">Colombia</option>
        <option value="Chile">Chile</option>
        <option value="Estados Unidos">Estados Unidos</option>
      </select><br>

      <label for="foto">Foto:</label>
      <input type="file" id="foto" name="foto" accept="image/*"><br>

      <button type="submit">Registrarse</button>
      <a href="/pipisos/login.php" class="link-secondary">¿Ya tienes cuenta? Entrar</a>
    </form>
  </section>
</main>

<script src="/pipisos/js/validations.js" defer></script>

<?php require_once __DIR__ . '/inc/footer.php'; ?>