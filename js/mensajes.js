// Función para gestionar mensajes
(function() {
    'use strict';

    // Función para almacenar un mensaje en localStorage
    function guardarMensaje(tipo, texto) {
        const fecha = new Date().toISOString().split('T')[0];
        const mensaje = {
            tipo: tipo,
            texto: texto,
            fecha: fecha,
            usuario: 'usuario1', // Usuario actual (ejemplo)
            estado: 'Enviado'
        };

        // Obtener mensajes existentes o inicializar array
        let mensajes = JSON.parse(localStorage.getItem('mensajes') || '[]');
        mensajes.push(mensaje);
        localStorage.setItem('mensajes', JSON.stringify(mensajes));
    }

    // Función para mostrar mensajes en la tabla
    function mostrarMensajes() {
        const tabla = document.querySelector('table tbody');
        if (!tabla) return;

        // Obtener mensajes del localStorage
        const mensajes = JSON.parse(localStorage.getItem('mensajes') || '[]');
        const urlParams = new URLSearchParams(window.location.search);
        const nuevoTipo = urlParams.get('tipo');
        const nuevoMensaje = urlParams.get('mensaje');

        // Si hay parámetros en la URL, agregar el nuevo mensaje
        if (nuevoTipo && nuevoMensaje) {
            guardarMensaje(nuevoTipo, nuevoMensaje);
            // Limpiar la URL sin recargar la página
            window.history.replaceState({}, document.title, window.location.pathname);
        }

        // Mostrar todos los mensajes
        const todosLosMensajes = JSON.parse(localStorage.getItem('mensajes') || '[]');
        todosLosMensajes.reverse().forEach(msg => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${msg.estado}</td>
                <td>${msg.texto}</td>
                <td>${msg.fecha}</td>
                <td>${msg.usuario}</td>
            `;
            tabla.appendChild(tr);
        });
    }

    // Inicializar validación del formulario de envío
    function initEnviarMensaje() {
        const form = document.querySelector('form[action="confirmacion.html"]');
        if (!form) return;

        form.action = 'mensajes.html';
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const tipo = document.getElementById('tipo').value;
            const mensaje = document.getElementById('mensaje').value;

            if (!mensaje.trim()) {
                alert('El mensaje no puede estar vacío');
                return;
            }

            // Redirigir a mensajes.html con los parámetros
            window.location.href = `mensajes.html?tipo=${encodeURIComponent(tipo)}&mensaje=${encodeURIComponent(mensaje)}`;
        });
    }

    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        if (document.querySelector('form[action="confirmacion.html"]')) {
            initEnviarMensaje();
        } else if (document.querySelector('table')) {
            mostrarMensajes();
        }
    });
})();