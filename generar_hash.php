<?php
/**
 * Script auxiliar para generar hashes de contraseñas
 * Uso: Accede a este archivo desde el navegador con ?pass=tucontraseña
 * Ejemplo: http://localhost/pipisos/generar_hash.php?pass=admin123
 * 
 * IMPORTANTE: Elimina este archivo en producción por seguridad
 */

if (!isset($_GET['pass'])) {
    echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Generador de Hash - Pipisos</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        input[type='password'], input[type='text'] { width: 100%; padding: 10px; font-size: 16px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; }
        button:hover { background: #0056b3; }
        .result { background: #f8f9fa; padding: 15px; border-left: 4px solid #28a745; margin-top: 20px; }
        .warning { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin-bottom: 20px; }
        code { background: #e9ecef; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <h1>🔒 Generador de Hash de Contraseñas</h1>
    
    <div class='warning'>
        <strong>⚠️ ADVERTENCIA DE SEGURIDAD:</strong><br>
        Este archivo debe eliminarse en producción. Solo úsalo en desarrollo local.
    </div>
    
    <form method='get'>
        <div class='form-group'>
            <label for='pass'><strong>Contraseña a hashear:</strong></label>
            <input type='password' id='pass' name='pass' placeholder='Introduce la contraseña' required>
        </div>
        <button type='submit'>Generar Hash</button>
    </form>
    
    <h3>📝 Instrucciones:</h3>
    <ol>
        <li>Introduce la contraseña que quieres hashear</li>
        <li>Copia el hash generado</li>
        <li>Pégalo en <code>data/usuarios.php</code> en el campo <code>'pass'</code></li>
        <li>El login usará <code>password_verify()</code> automáticamente</li>
    </ol>
    
    <h3>🔐 Contraseñas actuales del sistema:</h3>
    <ul>
        <li><strong>admin</strong> → admin123</li>
        <li><strong>usuario1</strong> → pass1</li>
        <li><strong>usuario2</strong> → pass2</li>
        <li><strong>usuario3</strong> → pass3</li>
    </ul>
</body>
</html>";
    exit;
}

$password = $_GET['pass'];
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <title>Hash Generado - Pipisos</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .result { background: #d4edda; padding: 20px; border-left: 4px solid #28a745; margin: 20px 0; }
        .hash { background: #f8f9fa; padding: 15px; border-radius: 5px; font-family: monospace; word-break: break-all; margin: 10px 0; font-size: 14px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; }
        button:hover { background: #0056b3; }
        .copy-btn { background: #28a745; margin-left: 10px; }
        .copy-btn:hover { background: #218838; }
    </style>
    <script>
        function copiarHash() {
            const hash = document.getElementById('hashText').textContent;
            navigator.clipboard.writeText(hash).then(() => {
                alert('✓ Hash copiado al portapapeles');
            });
        }
    </script>
</head>
<body>
    <h1>✅ Hash Generado Correctamente</h1>
    
    <div class='result'>
        <p><strong>Contraseña original:</strong> " . htmlspecialchars($password, ENT_QUOTES, 'UTF-8') . "</p>
        <p><strong>Hash generado (cópialo):</strong></p>
        <div class='hash' id='hashText'>" . htmlspecialchars($hash, ENT_QUOTES, 'UTF-8') . "</div>
        <button onclick='copiarHash()' class='copy-btn'>📋 Copiar Hash</button>
    </div>
    
    <h3>📌 Ejemplo de uso en data/usuarios.php:</h3>
    <pre style='background: #f8f9fa; padding: 15px; border-radius: 5px; overflow-x: auto;'>
['user' => 'miusuario', 'pass' => '" . htmlspecialchars($hash, ENT_QUOTES, 'UTF-8') . "', 'estilo' => 'estilos.css'],
    </pre>
    
    <a href='generar_hash.php'><button>← Generar otro hash</button></a>
    <a href='login.php'><button style='background: #6c757d;'>Ir al Login</button></a>
</body>
</html>";
?>
