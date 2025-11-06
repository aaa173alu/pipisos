// === Validaciones y generación dinámica de tarifas ===
// Autor: Antonio Alfaro Aparicio y Laura Lillo
// Práctica 6 - Desarrollo de Aplicaciones Web
// Validaciones sin expresiones regulares ni validaciones HTML5

(() => {
  'use strict';

  /* =========================================================
     FUNCIONES AUXILIARES
  ========================================================== */

  // Comprueba si una cadena está vacía o solo contiene espacios/tabuladores
  const esVacio = (str) => {
    if (!str) return true;
    for (const ch of str) {
      if (ch !== ' ' && ch !== '\t' && ch !== '\n' && ch !== '\r') return false;
    }
    return true;
  };

  // Valida un email sin usar expresiones regulares
  const emailValido = (email) => {
    if (!email) return false;

    // Debe contener exactamente un '@'
    let atCount = 0, atPos = -1;
    for (let i = 0; i < email.length; i++) {
      if (email[i] === '@') { atCount++; atPos = i; }
    }
    if (atCount !== 1 || atPos === 0 || atPos === email.length - 1) return false;

    const local = email.substring(0, atPos);
    const dominio = email.substring(atPos + 1);

    // Dominio debe tener al menos un punto, no al inicio ni final
    let dotCount = 0, dotPos = -1;
    for (let i = 0; i < dominio.length; i++) {
      if (dominio[i] === '.') { dotCount++; if (dotPos === -1) dotPos = i; }
    }
    if (dotCount < 1 || dotPos === 0 || dotPos === dominio.length - 1) return false;

    // No puede contener espacios
    for (const c of email) {
      if (c === ' ' || c === '\t' || c === '\n' || c === '\r') return false;
    }

    return true;
  };

  // Comprueba si una fecha indica al menos 18 años
  const esMayorDeEdad = (fechaStr) => {
    if (!fechaStr) return false;
    const [y, m, d] = fechaStr.split('-').map(Number);
    if (!y || !m || !d) return false;

    const nacimiento = new Date(y, m - 1, d);
    const hoy = new Date();

    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mesDif = hoy.getMonth() - nacimiento.getMonth();
    if (mesDif < 0 || (mesDif === 0 && hoy.getDate() < nacimiento.getDate())) edad--;

    return edad >= 18;
  };

  // Limpia errores previos
  const limpiarErrores = (form) => {
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    const anterior = form.querySelector('.error-list');
    if (anterior) anterior.remove();
  };

  // Muestra lista de errores en el formulario
  const mostrarErrores = (form, errores) => {
    limpiarErrores(form);
    if (!errores.length) return;

    const div = document.createElement('div');
    div.className = 'error-list';
    const ul = document.createElement('ul');

    errores.forEach(err => {
      const li = document.createElement('li');
      li.textContent = err.texto;
      ul.appendChild(li);
      if (err.campo) err.campo.classList.add('input-error');
    });

    div.appendChild(ul);
    form.prepend(div);

    // Enfoca el primer campo erróneo
    const primerCampo = errores.find(e => e.campo);
    if (primerCampo) primerCampo.campo.focus();
  };

  /* =========================================================
     VALIDACIÓN LOGIN
  ========================================================== */

  const validarLogin = (e) => {
    e.preventDefault();
    const form = e.target;
    const userInput = form.querySelector('#user');
    const passInput = form.querySelector('#pass');
    let isValid = true;

    // Guardar los placeholders originales si no existen
    if (!userInput.dataset.originalPlaceholder) {
      userInput.dataset.originalPlaceholder = 'Introduce tu usuario';
    }
    if (!passInput.dataset.originalPlaceholder) {
      passInput.dataset.originalPlaceholder = 'Introduce tu contraseña';
    }

    // Limpiar errores previos
    userInput.classList.remove('input-error');
    passInput.classList.remove('input-error');
    limpiarErrores(form);

    // Validar usuario
    if (esVacio(userInput.value)) {
      // Forzar un reflow para reiniciar la animación
      void userInput.offsetWidth;
      userInput.placeholder = 'Necesitas escribir un usuario';
      userInput.classList.add('input-error');
      isValid = false;
    }

    // Validar contraseña
    if (esVacio(passInput.value)) {
      // Forzar un reflow para reiniciar la animación
      void passInput.offsetWidth;
      passInput.placeholder = 'Necesitas escribir una contraseña';
      passInput.classList.add('input-error');
      isValid = false;
    }

    if (isValid) {
      form.submit();
    }
  };

  // Restaurar placeholder original al escribir
  const restaurarPlaceholder = (input) => {
    if (input.dataset.originalPlaceholder) {
      input.placeholder = input.dataset.originalPlaceholder;
    }
    input.classList.remove('input-error');
  };

  // Agregar validación al formulario de login cuando exista
  const loginForm = document.querySelector('form[action="/pipisos/control_acceso.php"]');
  if (loginForm) {
    const userInput = loginForm.querySelector('#user');
    const passInput = loginForm.querySelector('#pass');

    loginForm.addEventListener('submit', validarLogin);
    userInput.addEventListener('input', () => restaurarPlaceholder(userInput));
    passInput.addEventListener('input', () => restaurarPlaceholder(passInput));
  }

  const prepararLogin = () => {
    const form = document.querySelector('form[action="menu.html"]');
    if (!form) return;

    form.addEventListener('submit', (e) => {
      const usuario = document.getElementById('usuario');
      const clave = document.getElementById('password');
      const errores = [];

      if (!usuario || esVacio(usuario.value)) errores.push({ texto: 'El usuario no puede estar vacío.', campo: usuario });
      if (!clave || esVacio(clave.value)) errores.push({ texto: 'La contraseña no puede estar vacía.', campo: clave });

      if (errores.length) { e.preventDefault(); mostrarErrores(form, errores); }
    });
  };

  /* =========================================================
     VALIDACIÓN REGISTRO
  ========================================================== */

  const prepararRegistro = () => {
    const form = document.getElementById('registroForm');
    if (!form) return;

    // Guardar placeholders originales
    const campos = ['usuario', 'clave', 'clave2', 'email', 'fecha'];
    const placeholdersOriginales = {};
    campos.forEach(id => {
      const campo = document.getElementById(id);
      if (campo) {
        placeholdersOriginales[id] = campo.placeholder;
        campo.addEventListener('input', () => {
          campo.placeholder = placeholdersOriginales[id];
          campo.classList.remove('input-error');
        });
      }
    });

    form.addEventListener('submit', (e) => {
      const usuario = document.getElementById('usuario');
      const clave = document.getElementById('clave');
      const clave2 = document.getElementById('clave2');
      const email = document.getElementById('email');
      const fecha = document.getElementById('fecha');
      const sexos = form.querySelectorAll('input[name="sexo"]');
      let hayError = false;

      // Limpiar errores previos
      limpiarErrores(form);

      // Usuario
      if (!usuario || esVacio(usuario.value)) {
        usuario.placeholder = 'Debes escribir un nombre de usuario';
        usuario.classList.remove('input-error');
        void usuario.offsetWidth;
        usuario.classList.add('input-error');
        hayError = true;
      }

      // Contraseña
      if (!clave || esVacio(clave.value)) {
        clave.placeholder = 'La contraseña es obligatoria';
        clave.classList.remove('input-error');
        void clave.offsetWidth;
        clave.classList.add('input-error');
        hayError = true;
      } else {
        const pw = clave.value;
        let tieneLetra = false, tieneNumero = false;
        for (const ch of pw) {
          if (/[A-Za-z]/.test(ch)) tieneLetra = true;
          if (/[0-9]/.test(ch)) tieneNumero = true;
        }
        if (pw.length < 6 || !tieneLetra || !tieneNumero) {
          clave.placeholder = 'Mínimo 6 caracteres, con letra y número';
          clave.classList.remove('input-error');
          void clave.offsetWidth;
          clave.classList.add('input-error');
          hayError = true;
        }
      }

      // Repetir contraseña
      if (!clave2 || clave.value !== clave2.value) {
        clave2.placeholder = 'Las contraseñas no coinciden';
        clave2.classList.remove('input-error');
        void clave2.offsetWidth;
        clave2.classList.add('input-error');
        hayError = true;
      }

      // Email
      if (!email || esVacio(email.value) || !emailValido(email.value)) {
        email.placeholder = 'Introduce un email válido';
        email.classList.remove('input-error');
        void email.offsetWidth;
        email.classList.add('input-error');
        hayError = true;
      }

      // Sexo
      const seleccionado = Array.from(sexos).some(s => s.checked);
      if (!seleccionado) {
        const contenedorSexo = sexos[0].closest('p');
        if (contenedorSexo) {
          contenedorSexo.classList.remove('input-error');
          void contenedorSexo.offsetWidth;
          contenedorSexo.classList.add('input-error');
        }
        hayError = true;
      }

      // Fecha
      if (!esMayorDeEdad(fecha.value)) {
        fecha.placeholder = 'Debes tener al menos 18 años';
        fecha.classList.remove('input-error');
        void fecha.offsetWidth;
        fecha.classList.add('input-error');
        hayError = true;
      }

      if (hayError) {
        e.preventDefault();
      }
    });
  };

  /* =========================================================
     VALIDACIÓN CREAR ANUNCIO
  ========================================================== */

  const validarCrearAnuncio = () => {
    const form = document.querySelector('form[action="/pipisos/respuestaCrearAnuncio.php"]');
    if (!form) return;

    // Guardar placeholders originales
    const campos = ['vivienda', 'titulo', 'texto', 'precio', 'ciudad', 'pais'];
    const placeholdersOriginales = {};

    campos.forEach(id => {
      const campo = document.getElementById(id);
      if (campo) {
        placeholdersOriginales[id] = campo.placeholder || '';
        campo.addEventListener('input', () => {
          campo.placeholder = placeholdersOriginales[id];
          campo.classList.remove('input-error');
        });
        // Limpiar error también al cambiar el select
        if (campo.tagName === 'SELECT') {
          campo.addEventListener('change', () => {
            campo.classList.remove('input-error');
          });
        }
      }
    });

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let isValid = true;

      // Restaurar todos los campos primero
      campos.forEach(id => {
        const campo = document.getElementById(id);
        if (campo) {
          campo.classList.remove('input-error');
          campo.placeholder = placeholdersOriginales[id] || '';
        }
      });

      // Validar tipo de vivienda
      const vivienda = document.getElementById('vivienda');
      if (!vivienda.value) {
        vivienda.classList.remove('input-error');
        void vivienda.offsetWidth;
        vivienda.classList.add('input-error');
        const firstOption = vivienda.querySelector('option');
        if (firstOption) {
          firstOption.textContent = 'Debes seleccionar un tipo de vivienda';
        }
        isValid = false;
      }

      // Validar título
      const titulo = document.getElementById('titulo');
      if (esVacio(titulo.value)) {
        titulo.value = '';
        titulo.placeholder = 'El título es obligatorio';
        titulo.classList.remove('input-error');
        void titulo.offsetWidth;
        titulo.classList.add('input-error');
        isValid = false;
      }

      // Validar precio
      const precio = document.getElementById('precio');
      if (!precio.value || parseFloat(precio.value) < 0) {
        precio.value = '';
        precio.placeholder = 'Introduce un precio válido';
        precio.classList.remove('input-error');
        void precio.offsetWidth;
        precio.classList.add('input-error');
        isValid = false;
      }

      if (isValid) {
        form.submit();
      }
    });
  };

  /* =========================================================
     SOLICITAR FOLLETO (TABLA Y FORMULARIO)
  ========================================================== */

  const prepararFolleto = () => {
    const tarifas = [
      { paginas: 1, fotos: 3, bn150: 12.00, bn450: 12.60, col150: 13.50, col450: 14.10 },
      { paginas: 2, fotos: 6, bn150: 14.00, bn450: 15.20, col150: 17.00, col450: 18.20 },
      { paginas: 3, fotos: 9, bn150: 16.00, bn450: 17.80, col150: 20.50, col450: 22.30 },
      { paginas: 4, fotos: 12, bn150: 18.00, bn450: 20.40, col150: 24.00, col450: 26.40 },
      { paginas: 5, fotos: 15, bn150: 19.80, bn450: 22.80, col150: 27.30, col450: 30.30 },
      { paginas: 6, fotos: 18, bn150: 21.60, bn450: 25.20, col150: 30.70, col450: 34.20 },
      { paginas: 7, fotos: 21, bn150: 23.40, bn450: 27.60, col150: 33.90, col450: 38.10 },
      { paginas: 8, fotos: 24, bn150: 25.20, bn450: 30.00, col150: 37.20, col450: 42.00 },
      { paginas: 9, fotos: 27, bn150: 27.00, bn450: 32.40, col150: 40.50, col450: 45.90 },
      { paginas: 10, fotos: 30, bn150: 28.80, bn450: 34.80, col150: 43.80, col450: 49.80 },
      { paginas: 11, fotos: 33, bn150: 30.40, bn450: 37.00, col150: 46.90, col450: 53.50 },
      { paginas: 12, fotos: 36, bn150: 32.00, bn450: 39.20, col150: 50.00, col450: 57.20 },
      { paginas: 13, fotos: 39, bn150: 33.60, bn450: 41.40, col150: 53.10, col450: 60.90 },
      { paginas: 14, fotos: 42, bn150: 35.20, bn450: 43.60, col150: 56.20, col450: 64.60 },
      { paginas: 15, fotos: 45, bn150: 36.80, bn450: 45.80, col150: 59.30, col450: 68.30 },
    ];

    const toggle = document.getElementById('toggleTarifas');
    const contenedor = document.getElementById('tarifasContainer');
    let visible = false;

    if (toggle && contenedor) {
      toggle.addEventListener('click', () => {
        if (visible) {
          contenedor.innerHTML = '';
          toggle.textContent = 'Mostrar tarifas';
        } else {
          const tabla = document.createElement('table');
          tabla.innerHTML = `
          <caption>Tarifas de impresión de folletos</caption>
          <thead>
            <tr>
              <th rowspan="2">Número de páginas</th>
              <th rowspan="2">Número de fotos</th>
              <th colspan="2">Blanco y negro</th>
              <th colspan="2">Color</th>
            </tr>
            <tr>
              <th>150–300 dpi</th>
              <th>450–900 dpi</th>
              <th>150–300 dpi</th>
              <th>450–900 dpi</th>
            </tr>
          </thead>
        `;

          const tbody = document.createElement('tbody');
          tarifas.forEach(t => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
            <td>${t.paginas}</td>
            <td>${t.fotos}</td>
            <td>${t.bn150.toFixed(2)} €</td>
            <td>${t.bn450.toFixed(2)} €</td>
            <td>${t.col150.toFixed(2)} €</td>
            <td>${t.col450.toFixed(2)} €</td>
          `;
            tbody.appendChild(fila);
          });

          tabla.appendChild(tbody);
          contenedor.appendChild(tabla);
          toggle.textContent = 'Ocultar tarifas';
        }
        visible = !visible
      });
    }

    // Validación del formulario
    const form = document.getElementById('solicitarFolletoForm');
    if (!form) return;

    // Guardar placeholders originales y configurar eventos de input
    const camposObligatorios = ['nombre', 'email', 'direccion', 'paginas', 'copias', 'anuncio'];
    const placeholdersOriginales = {};

    camposObligatorios.forEach(id => {
      const campo = document.getElementById(id);
      if (campo) {
        placeholdersOriginales[id] = campo.placeholder || '';
        campo.addEventListener('input', () => {
          campo.placeholder = placeholdersOriginales[id];
          campo.classList.remove('input-error');
        });
      }
    });

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      let isValid = true;

      // Limpiar errores previos
      const errorList = form.querySelector('.error-list');
      if (errorList) {
        errorList.remove();
      }

      // Validar nombre
      const nombre = document.getElementById('nombre');
      if (esVacio(nombre.value)) {
        nombre.placeholder = 'El nombre es obligatorio';
        nombre.classList.remove('input-error');
        void nombre.offsetWidth;
        nombre.classList.add('input-error');
        isValid = false;
      }

      // Validar email
      const email = document.getElementById('email');
      if (esVacio(email.value) || !emailValido(email.value)) {
        email.placeholder = 'Introduce un email válido';
        email.classList.remove('input-error');
        void email.offsetWidth;
        email.classList.add('input-error');
        isValid = false;
      }

      // Validar dirección
      const direccion = document.getElementById('direccion');
      if (esVacio(direccion.value)) {
        direccion.placeholder = 'La dirección es obligatoria';
        direccion.classList.remove('input-error');
        void direccion.offsetWidth;
        direccion.classList.add('input-error');
        isValid = false;
      }

      // Validar páginas
      const paginas = document.getElementById('paginas');
      if (!paginas.value || parseInt(paginas.value) < 1) {
        paginas.placeholder = 'Mínimo 1 página';
        paginas.classList.remove('input-error');
        void paginas.offsetWidth;
        paginas.classList.add('input-error');
        isValid = false;
      }

      // Validar copias
      const copias = document.getElementById('copias');
      const numCopias = parseInt(copias.value);
      if (isNaN(numCopias) || numCopias < 1 || numCopias > 99) {
        copias.placeholder = 'Entre 1 y 99 copias';
        copias.classList.remove('input-error');
        void copias.offsetWidth;
        copias.classList.add('input-error');
        isValid = false;
      }

      // Validar anuncio
      const anuncio = document.getElementById('anuncio');
      if (!anuncio.value) {
        // Para select, podemos añadir una opción temporal
        const tempOption = document.createElement('option');
        tempOption.textContent = 'Selecciona un anuncio';
        tempOption.value = '';
        anuncio.insertBefore(tempOption, anuncio.firstChild);
        anuncio.value = '';
        anuncio.classList.remove('input-error');
        void anuncio.offsetWidth;
        anuncio.classList.add('input-error');
        isValid = false;
      }

      if (isValid) {
        form.submit();
      }

      if (errores.length) { e.preventDefault(); mostrarErrores(form, errores); }
    });
  };

  /* =========================================================
     INICIALIZACIÓN
  ========================================================== */

  document.addEventListener('DOMContentLoaded', () => {
    prepararLogin();
    prepararRegistro();
    prepararFolleto();
  });

})();
