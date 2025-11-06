<?php

$title = "Test de Validaciones - PI";
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/menu.php';
?>

<link rel="stylesheet" href="/pipisos/css/validation.css">
<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .test-section {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #ccc;
    }

    .test-case {
        margin: 10px 0;
        padding: 10px;
        background: #f5f5f5;
    }

    .pass {
        color: green;
    }

    .fail {
        color: red;
    }

    h2 {
        margin-top: 0;
    }

    button {
        margin: 5px;
    }
</style>

<main>
    <h1>Test de Validaciones</h1>

    <div class="test-section">
        <h2>1. Login Tests</h2>
        <form action="#" method="post" id="loginTest" novalidate>
            <label for="usuario">Usuario:</label><br>
            <input type="text" id="usuario" name="usuario"><br>
            <label for="password">Contraseña:</label><br>
            <input type="password" id="password" name="password"><br>
            <button type="submit">Login</button>
        </form>
        <div>
            <button type="button" onclick="runLoginTests()">Ejecutar Tests Login</button>
            <div id="loginResults"></div>
        </div>
    </div>

    <div class="test-section">
        <h2>2. Registro Tests</h2>
        <form action="#" method="post" id="registroTest" novalidate>
            <label for="regUsuario">Usuario:</label><br>
            <input type="text" id="regUsuario" name="usuario"><br>
            <label for="regClave">Contraseña:</label><br>
            <input type="password" id="regClave" name="clave"><br>
            <label for="regClave2">Repetir contraseña:</label><br>
            <input type="password" id="regClave2" name="clave2"><br>
            <label for="regEmail">Email:</label><br>
            <input type="text" id="regEmail" name="email"><br>
            <p>Sexo:</p>
            <label><input type="radio" name="sexo" value="hombre"> Hombre</label>
            <label><input type="radio" name="sexo" value="mujer"> Mujer</label>
            <label><input type="radio" name="sexo" value="otro"> Otro</label><br>
            <label for="regFecha">Fecha de nacimiento:</label><br>
            <input type="date" id="regFecha" name="fecha"><br>
            <button type="submit">Registrar</button>
        </form>
        <div>
            <button type="button" onclick="runRegistroTests()">Ejecutar Tests Registro</button>
            <div id="registroResults"></div>
        </div>
    </div>

    <div class="test-section">
        <h2>3. Solicitar Folleto Tests</h2>
        <section id="tablaTarifas">
            <button id="toggleTarifas" type="button">Mostrar tarifas</button>
            <div id="tarifasContainer" aria-hidden="true"></div>
        </section>
        <form action="#" method="get" id="solicitarFolletoTest" novalidate>
            <label for="folletoNombre">Nombre:</label><br>
            <input type="text" id="folletoNombre" name="nombre"><br>
            <label for="folletoEmail">Email:</label><br>
            <input type="text" id="folletoEmail" name="email"><br>
            <label for="folletoCopias">Número de copias:</label><br>
            <input type="number" id="folletoCopias" name="copias" min="1" max="99"><br>
            <button type="submit">Solicitar</button>
        </form>
        <div>
            <button type="button" onclick="runFolletoTests()">Ejecutar Tests Folleto</button>
            <div id="folletoResults"></div>
        </div>
    </div>
</main>

<script src="/pipisos/js/validations.js"></script>
<script>
    function logResult(containerId, testName, passed, message) {
        const div = document.createElement('div');
        div.className = 'test-case ' + (passed ? 'pass' : 'fail');
        div.textContent = `${testName}: ${passed ? '✓' : '✗'} ${message || ''}`;
        document.getElementById(containerId).appendChild(div);
    }

    function clearResults(containerId) {
        document.getElementById(containerId).innerHTML = '';
    }

    function runLoginTests() {
        clearResults('loginResults');
        const form = document.getElementById('loginTest');
        const usuario = document.getElementById('usuario');
        const password = document.getElementById('password');

        // Test 1: Empty fields
        usuario.value = '';
        password.value = '';
        form.dispatchEvent(new Event('submit'));
        logResult('loginResults', 'Campos vacíos',
            form.querySelector('.error-list') !== null,
            'Debería mostrar error para campos vacíos');

        // Test 2: Only spaces
        usuario.value = '   \t   ';
        password.value = '  \t  ';
        form.dispatchEvent(new Event('submit'));
        logResult('loginResults', 'Solo espacios/tabs',
            form.querySelector('.error-list') !== null,
            'Debería mostrar error para campos con solo espacios');

        // Test 3: Valid input
        usuario.value = 'usuario1';
        password.value = 'pass123';
        const originalSubmit = form.onsubmit;
        form.onsubmit = (e) => {
            e.preventDefault();
            logResult('loginResults', 'Datos válidos',
                form.querySelector('.error-list') === null,
                'No debería mostrar errores');
        };
        form.dispatchEvent(new Event('submit'));
        form.onsubmit = originalSubmit;
    }

    function runRegistroTests() {
        clearResults('registroResults');
        const form = document.getElementById('registroTest');
        const usuario = document.getElementById('regUsuario');
        const clave = document.getElementById('regClave');
        const clave2 = document.getElementById('regClave2');
        const email = document.getElementById('regEmail');
        const fecha = document.getElementById('regFecha');
        const radios = form.querySelectorAll('input[name="sexo"]');

        // Test 1: Password validation
        usuario.value = 'usuario1';
        clave.value = 'abc'; // too short
        clave2.value = 'abc';
        email.value = 'valid@email.com';
        fecha.value = '2000-01-01';
        radios[0].checked = true;
        form.dispatchEvent(new Event('submit'));
        logResult('registroResults', 'Contraseña corta',
            form.querySelector('.error-list') !== null,
            'Debería rechazar contraseña menor a 6 caracteres');

        // Test 2: Password mismatch
        clave.value = 'password1';
        clave2.value = 'password2';
        form.dispatchEvent(new Event('submit'));
        logResult('registroResults', 'Contraseñas diferentes',
            form.querySelector('.error-list') !== null,
            'Debería detectar contraseñas que no coinciden');

        // Test 3: Email validation
        clave.value = clave2.value = 'password1';
        email.value = 'invalid.email';
        form.dispatchEvent(new Event('submit'));
        logResult('registroResults', 'Email inválido',
            form.querySelector('.error-list') !== null,
            'Debería detectar email sin @');

        // Test 4: Age validation
        email.value = 'valid@email.com';
        const today = new Date();
        fecha.value = `${today.getFullYear() - 17}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
        form.dispatchEvent(new Event('submit'));
        logResult('registroResults', 'Menor de edad',
            form.querySelector('.error-list') !== null,
            'Debería rechazar menores de 18 años');

        // Test 5: Valid registration
        fecha.value = '2000-01-01';
        const originalSubmit = form.onsubmit;
        form.onsubmit = (e) => {
            e.preventDefault();
            logResult('registroResults', 'Registro válido',
                form.querySelector('.error-list') === null,
                'No debería mostrar errores');
        };
        form.dispatchEvent(new Event('submit'));
        form.onsubmit = originalSubmit;
    }

    function runFolletoTests() {
        clearResults('folletoResults');
        const form = document.getElementById('solicitarFolletoTest');
        const nombre = document.getElementById('folletoNombre');
        const email = document.getElementById('folletoEmail');
        const copias = document.getElementById('folletoCopias');

        // Test 1: Table toggle
        const toggle = document.getElementById('toggleTarifas');
        const container = document.getElementById('tarifasContainer');
        toggle.click();
        logResult('folletoResults', 'Generar tabla',
            container.querySelector('table') !== null,
            'Debería generar tabla de tarifas');
        toggle.click();
        logResult('folletoResults', 'Ocultar tabla',
            container.innerHTML === '',
            'Debería eliminar tabla al ocultar');

        // Test 2: Invalid copies
        nombre.value = 'Nombre';
        email.value = 'valid@email.com';
        copias.value = '100'; // más del máximo
        form.dispatchEvent(new Event('submit'));
        logResult('folletoResults', 'Copias inválidas',
            form.querySelector('.error-list') !== null,
            'Debería rechazar más de 99 copias');

        // Test 3: Valid submission
        copias.value = '50';
        const originalSubmit = form.onsubmit;
        form.onsubmit = (e) => {
            e.preventDefault();
            logResult('folletoResults', 'Datos válidos',
                form.querySelector('.error-list') === null,
                'No debería mostrar errores');
        };
        form.dispatchEvent(new Event('submit'));
        form.onsubmit = originalSubmit;
    }

    // Small helper to toggle tarifas table if validations.js provides it
    document.getElementById('toggleTarifas')?.addEventListener('click', () => {
        const container = document.getElementById('tarifasContainer');
        if (!container) return;
        if (container.innerHTML.trim() === '') {
            // simple generated table for tests
            container.innerHTML = '<table><thead><tr><th>Opc</th><th>Precio</th></tr></thead><tbody><tr><td>1</td><td>0.12</td></tr></tbody></table>';
            container.setAttribute('aria-hidden', 'false');
        } else {
            container.innerHTML = '';
            container.setAttribute('aria-hidden', 'true');
        }
    });
</script>

<?php require_once __DIR__ . '/inc/footer.php'; ?>