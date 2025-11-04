# 🏕️ Masaya Glamping - Sistema de Reservas

Sistema web completo para la gestión de reservas de cabañas en Masaya Glamping.

## 🚀 Características

### Para Usuarios
- ✨ Registro y autenticación de usuarios
- 🗺️ Mapa interactivo de cabañas
- 📅 Sistema de reservas con validación de fechas
- 👤 Panel de usuario para ver reservas
- 💳 Cálculo automático de precios

### Para Administradores
- 👨‍💼 Panel de administración completo
- 🏠 Gestión de cabañas (agregar, editar, eliminar)
- 📊 Gestión de reservas (confirmar, cancelar, eliminar)
- 👥 Gestión de usuarios y empleados
- 🖼️ Subida y gestión de imágenes

## 🛠️ Tecnologías Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap
- **Backend**: PHP, MySQL
- **Base de Datos**: MySQL con stored procedures
- **Seguridad**: Prepared statements, validación de sesiones

## 📦 Instalación

1. Clonar el repositorio
2. Importar la base de datos (`database.sql`)
3. Configurar conexión en `db.php`
4. Configurar servidor web (Apache/Nginx)

## 🗃️ Estructura de la Base de Datos

- `usuarios` - Registro de clientes
- `empleados` - Personal administrativo
- `cabanas` - Información de cabañas
- `reservas` - Sistema de reservaciones
- `glamping` - Configuración del establecimiento

## 👤 Credenciales de Prueba

**Administrador:**
- Usuario: admin
- Contraseña: [definida en la base de datos]

## 📄 Licencia

Este proyecto es para uso educativo y demostrativo.
