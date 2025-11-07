# PI - Pisos & Inmuebles

## 📋 Descripción del Proyecto

**PI - Pisos & Inmuebles** es una aplicación web desarrollada en PHP para la gestión de anuncios de propiedades inmobiliarias. La plataforma permite a los usuarios registrarse, publicar anuncios de venta o alquiler de inmuebles, buscar propiedades, gestionar mensajes y solicitar folletos publicitarios.

**Autores:** Antonio Alfaro y Laura Lillo

---

## ✨ Características Principales

### 🔐 Sistema de Autenticación
- **Registro de usuarios** con validación de datos
- **Inicio de sesión** con opción "Recordar usuario"
- **Control de acceso** a funcionalidades premium
- **Gestión de cookies** para sesiones persistentes
- **Cierre de sesión** seguro

### 🏠 Gestión de Anuncios
- **Crear anuncios** de venta o alquiler
- **Tipos de propiedades:** vivienda, chalet, ático, apartamento, oficina, garaje
- **Añadir fotos** a los anuncios
- **Ver mis anuncios** publicados
- **Detalle completo** de cada propiedad con características
- **Búsqueda** de inmuebles

### 👤 Perfil de Usuario
- **Mi perfil** - Gestión de información personal
- **Personalización** de estilos visuales
- **Historial** de últimos anuncios visitados
- **Registro de última visita**

### 💬 Sistema de Mensajería
- **Enviar mensajes** a otros usuarios
- **Ver mensajes** recibidos y enviados
- **Gestión** de comunicaciones

### 📄 Folletos Publicitarios
- **Solicitar folletos** personalizados
- **Formulario** con validación completa
- **Tabla de tarifas** dinámica

---

## 🗂️ Estructura del Proyecto

```
pipisos/
├── css/                          # Hojas de estilo
│   ├── estilos.css              # Estilo principal
│   ├── oscuro.css               # Modo oscuro
│   ├── contrastes.css           # Alto contraste
│   ├── letraGrande.css          # Texto grande
│   ├── contrasteGrande.css      # Contraste + letra grande
│   ├── impresion.css            # Estilos de impresión
│   ├── validation.css           # Estilos de validación
│   └── fontello.css             # Iconos
│
├── js/                           # Scripts JavaScript
│   ├── validations.js           # Validaciones del lado cliente
│   ├── mensajes.js              # Funcionalidad de mensajes
│   └── respuestaFolleto.js      # Formulario de folletos
│
├── img/                          # Imágenes y recursos visuales
│   ├── logo.png / logo.svg      # Logotipos
│   └── [propiedades].svg/jpg    # Imágenes de inmuebles
│
├── inc/                          # Archivos de inclusión
│   ├── config.php               # Configuración de sesiones
│   ├── header.php               # Cabecera común
│   ├── menu.php                 # Menú de navegación
│   └── footer.php               # Pie de página
│
├── data/                         # Datos de la aplicación
│   ├── usuarios.php             # Base de datos de usuarios
│   └── anuncios.php             # Base de datos de anuncios
│
├── font/                         # Fuentes personalizadas
│
├── index.php                     # Página principal
├── index-Log.php                 # Inicio (usuario autenticado)
├── index-NoLog.php               # Inicio (usuario no autenticado)
│
├── login.php                     # Página de inicio de sesión
├── registro.php                  # Formulario de registro
├── respuestaRegistro.php         # Procesamiento de registro
├── logout.php                    # Cierre de sesión
│
├── crear-anuncio.php             # Formulario para crear anuncios
├── respuestaCrearAnuncio.php     # Procesamiento de anuncios
├── añadir-foto.php               # Subida de fotos
├── respuestaAñadirFoto.php       # Procesamiento de fotos
├── mis-anuncios.php              # Lista de anuncios del usuario
├── ver-anuncio.php               # Vista detallada de anuncio
├── detalle.php                   # Detalles de propiedad
│
├── busqueda.php                  # Buscador de propiedades
├── resultados.php                # Resultados de búsqueda
│
├── mensajes.php                  # Bandeja de mensajes
├── enviar-mensaje.php            # Formulario de mensajes
├── respuestaMensaje.php          # Procesamiento de mensajes
│
├── solicitar-folleto.php         # Formulario de folleto
├── respuestaFolleto.php          # Procesamiento de folleto
│
├── mi-perfil.php                 # Perfil del usuario
├── control_acceso.php            # Control de permisos
│
└── test-validaciones.php         # Tests de validación
```

---

## 🛠️ Tecnologías Utilizadas

- **PHP** - Lenguaje del lado servidor
- **HTML5** - Estructura de páginas
- **CSS3** - Estilos y diseño responsive
- **JavaScript** - Validaciones y interactividad
- **Cookies & Sesiones** - Gestión de estado de usuario
- **SVG/JPG** - Gráficos e imágenes

---

## 🎨 Características de Accesibilidad

El proyecto incluye múltiples temas visuales para mejorar la accesibilidad:

1. **Estilo estándar** (`estilos.css`)
2. **Modo oscuro** (`oscuro.css`)
3. **Alto contraste** (`contrastes.css`)
4. **Letra grande** (`letraGrande.css`)
5. **Contraste + Letra grande** (`contrasteGrande.css`)
6. **Modo impresión** (`impresion.css`)

Los usuarios pueden seleccionar su estilo preferido, que se guarda en sus preferencias.

---

## 🚀 Instalación y Configuración

### Requisitos Previos

- **Servidor web** con soporte PHP (Apache, Nginx, etc.)
- **PHP 7.4+** o superior
- **Navegador web** moderno

### Pasos de Instalación

1. **Clonar o descargar** el repositorio:
   ```bash
   git clone https://github.com/aaa173alu/pipisos.git
   ```

2. **Configurar el servidor web:**
   - Colocar los archivos en el directorio del servidor (ej: `/var/www/html/pipisos/` o `htdocs/pipisos/`)
   - Asegurar que el servidor tenga permisos de lectura en todos los archivos
   - Verificar que PHP esté habilitado

3. **Configurar rutas:**
   - El proyecto está configurado para ejecutarse en `/pipisos/`
   - Si necesitas cambiar la ruta base, actualiza las referencias en los archivos PHP

4. **Acceder a la aplicación:**
   - Abrir navegador en: `http://localhost/pipisos/` (o la ruta configurada)

### Usuarios de Prueba

El sistema incluye usuarios predefinidos para testing (ver `data/usuarios.php`):

| Usuario   | Contraseña | Estilo Visual          |
|-----------|------------|------------------------|
| admin     | admin123   | estilos.css            |
| usuario1  | pass1      | oscuro.css             |
| usuario2  | pass2      | contrastes.css         |
| usuario3  | pass3      | contrasteGrande.css    |

---

## 📱 Funcionalidades Principales

### Para Usuarios No Registrados
- ✅ Ver anuncios destacados en la página principal
- ✅ Buscar propiedades
- ✅ Ver detalles de anuncios
- ✅ Registro en la plataforma

### Para Usuarios Registrados
- ✅ Todas las funcionalidades anteriores
- ✅ Publicar nuevos anuncios
- ✅ Añadir fotos a anuncios
- ✅ Gestionar anuncios propios
- ✅ Enviar y recibir mensajes
- ✅ Solicitar folletos publicitarios
- ✅ Personalizar perfil
- ✅ Ver historial de anuncios visitados

---

## 🔍 Validaciones

El proyecto incluye validaciones tanto del lado cliente (JavaScript) como del lado servidor (PHP):

### Validaciones de Registro
- Usuario: obligatorio, máximo 200 caracteres
- Contraseña: mínimo 6 caracteres, debe incluir letras y números
- Email: formato válido
- Fecha de nacimiento: mayor de 18 años
- Campos opcionales: sexo, ciudad, país, foto de perfil

### Validaciones de Anuncios
- Tipo de anuncio: venta o alquiler
- Tipo de vivienda: obligatorio
- Título: obligatorio, máximo 200 caracteres
- Descripción: obligatoria
- Precio: obligatorio, número positivo
- Ubicación: ciudad y país obligatorios

### Validaciones de Folletos
- Nombre: obligatorio
- Email: formato válido
- Dirección: obligatoria
- Productos: al menos uno seleccionado

---

## 🔒 Seguridad

El proyecto implementa varias medidas de seguridad:

- ✅ **Escape de HTML** con `htmlspecialchars()` para prevenir XSS
- ✅ **Regeneración de ID de sesión** al iniciar sesión
- ✅ **Cookies HttpOnly** para mayor seguridad
- ✅ **Validación de datos** en cliente y servidor
- ✅ **Control de acceso** a páginas protegidas
- ✅ **Sanitización de inputs** de usuario

---

## 📝 Notas de Desarrollo

### Convenciones de Código
- Archivos de respuesta usan el prefijo `respuesta*` (ej: `respuestaRegistro.php`)
- Archivos de inclusión están en el directorio `/inc/`
- Los datos simulados están en `/data/`
- Todas las rutas son absolutas comenzando con `/pipisos/`

### Estructura de Datos
Los anuncios incluyen:
- Información básica (título, descripción, precio)
- Características (superficie, habitaciones, baños, planta, año)
- Fotos (principal y galería)
- Datos de ubicación (ciudad, país)
- Usuario propietario

---

## 🐛 Testing

El archivo `test-validaciones.php` incluye tests para:
- Validaciones de formulario de login
- Validaciones de registro
- Validaciones de creación de anuncios
- Validaciones de folletos

---

## 📄 Licencia

Este proyecto es un trabajo académico desarrollado por Antonio Alfaro y Laura Lillo.

---

## 📞 Contacto

Para dudas o sugerencias sobre el proyecto, contactar a los autores.

---

## 🎯 Roadmap Futuro

Posibles mejoras para futuras versiones:
- [ ] Base de datos real (MySQL/PostgreSQL)
- [ ] Sistema de favoritos
- [ ] Mapa interactivo de propiedades
- [ ] Chat en tiempo real
- [ ] Notificaciones por email
- [ ] Panel de administración
- [ ] API REST
- [ ] Subida múltiple de imágenes con drag & drop
- [ ] Comparador de propiedades
- [ ] Sistema de valoraciones y reseñas

---

**¡Gracias por usar PI - Pisos & Inmuebles!** 🏠
