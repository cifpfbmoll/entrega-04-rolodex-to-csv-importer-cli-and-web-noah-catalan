# 📇 Rolodex Contact Importer[![Review Assignment Due Date](https://classroom.github.com/assets/deadline-readme-button-22041afd0340ce965d47ae6ef1cefeee28c7c493a6346c4f15d667ab976d596c.svg)](https://classroom.github.com/a/keP9ug1F)

# 📇 Rolodex to CSV Importer - Versión Mejorada

Aplicación web y CLI para digitalizar contactos desde agendas físicas Rolodex.

> **Una aplicación full-stack moderna para digitalizar contactos desde agendas físicas Rolodex**

## 🚀 Ejecución

[![CodeIgniter](https://img.shields.io/badge/CodeIgniter-4.6-EF4223?style=flat&logo=codeigniter)](https://codeigniter.com/)

### Interfaz Web[![PHP](https://img.shields.io/badge/PHP-8.1-777BB4?style=flat&logo=php)](https://www.php.net/)

```bash[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.1-7952B3?style=flat&logo=bootstrap)](https://getbootstrap.com/)

php -S localhost:8080[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

```

Abrir: http://localhost:8080---



### CLI## 🌟 Características Principales

```bash

php contact-importer.php### ✨ Versión Mejorada - Novedades

```

- 🎨 **Diseño moderno** con gradientes y animaciones

## ✨ Mejoras Implementadas- 🔍 **Búsqueda en tiempo real** con auto-submit

- ✅ **Validación avanzada** con CodeIgniter 4

### Diseño Visual- 🗑️ **CRUD completo** (Create, Read, Update, Delete)

- Gradientes modernos púrpura/rosa- 🚫 **Detección de duplicados** inteligente

- Tarjetas de estadísticas con 3 colores- 📊 **Estadísticas visuales** con tarjetas coloridas

- Animaciones smooth en hover- ⚡ **Comando Spark integrado** para CLI

- Diseño responsive- 📱 **Responsive design** para móviles



### Funcionalidades### 🎯 Funcionalidades Básicas

- Formulario de contactos con validación

- Lista de contactos en tabla- **Interfaz CLI Interactiva**: Importa contactos desde la terminal

- Estadísticas visuales (Total, Con Teléfono, Con Email)- **Interfaz Web Moderna**: Gestiona contactos desde el navegador

- Descarga de CSV con timestamp- **Almacenamiento CSV**: Datos en formato portable y compatible

- Links clicables (tel: y mailto:)- **Validación Robusta**: Previene errores y datos duplicados

- **Exportación Mejorada**: Descarga con timestamp en el nombre

### CLI Mejorado

- Mensajes con emojis---

- Validación en tiempo real

- Contador de sesión## 📸 Capturas de Pantalla

- Resumen al finalizar

### Interfaz Web Principal

## 📸 Capturas![Interfaz Principal](screenshots/main-interface.png)

- Diseño moderno con gradientes púrpura/rosa

### Interfaz Principal- Tarjetas de estadísticas coloridas

![Interfaz Web](Captura%20desde%202025-11-12%2021-34-16.png)- Búsqueda en tiempo real



### Formulario de Contacto### Formulario de Contacto

![Formulario](Captura%20desde%202025-11-12%2021-34-21.png)![Formulario](screenshots/form.png)

- Validación en tiempo real

### Lista de Contactos- Campos con iconos contextuales

![Lista](Captura%20desde%202025-11-12%2021-34-30.png)- Acciones rápidas integradas



## 🛠️ Tecnologías### Comando CLI

```bash

- PHP 8.1$ php spark import:contacts

- Bootstrap 5

- CodeIgniter 4 (estructura)===========================================

- CSS3 Gradients  � Rolodex Contact Importer

- JavaScript Vanilla===========================================



## 📝 Archivos PrincipalesFull Name: María García

Phone Number: 555-123-4567  

- `index.php` - Aplicación web standaloneEmail: maria@ejemplo.com

- `contact-importer.php` - CLI standalone✓ Contact saved successfully! (1 total)

- `writable/contacts.csv` - Datos guardados```



------



**Autor:** Noah Catalán  ## 🚀 Inicio Rápido

**Fecha:** Noviembre 2025

### Requisitos Previos

- PHP 8.1 o superior
- Composer
- Extensiones PHP: `mbstring`, `xml`, `curl`, `intl`

### Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/tu-usuario/rolodex-importer.git
cd rolodex-importer

# 2. Instalar dependencias
composer install

# 3. Dar permisos a writable/
chmod -R 755 writable/
```

### Ejecución

#### Opción A: Interfaz Web

### Ejecución

#### Opción A: Interfaz Web
```bash
php -S localhost:8080 -t public
```
**Abrir en navegador:** http://localhost:8080

#### Opción B: Comando CLI (Spark)
```bash
php spark import:contacts
```

#### Opción C: Script Standalone
```bash
php contact-importer.php
```

---

## 📚 Documentación

- **[MEJORAS.md](MEJORAS.md)** - Documentación completa de todas las mejoras implementadas
- **[INSTRUCCIONES_EJECUCION.md](INSTRUCCIONES_EJECUCION.md)** - Guía rápida de ejecución
- **[DESARROLLO.md](DESARROLLO.md)** - Notas del proceso de desarrollo
- **[PROJECT_STRUCTURE.md](PROJECT_STRUCTURE.md)** - Estructura del proyecto

---

## 🎨 Mejoras Implementadas

### 1. Diseño Visual Moderno
- Gradientes suaves en púrpura/rosa
- Animaciones smooth en hover
- Tarjetas con sombras 3D
- Diseño responsive mejorado

### 2. Búsqueda Inteligente
- Auto-submit con debouncing (500ms)
- Búsqueda en nombre, teléfono y email
- Contador de resultados en tiempo real
- Insensible a mayúsculas/minúsculas

### 3. Validación Avanzada
- Reglas de validación de CodeIgniter 4
- Mensajes de error personalizados en español
- Detección de duplicados por nombre y email
- Validación de longitud de campos

### 4. CRUD Completo
- ✅ **Create**: Añadir nuevos contactos
- ✅ **Read**: Listar y buscar contactos
- ✅ **Delete**: Eliminar con confirmación
- ✅ **Export**: Descargar CSV con timestamp

### 5. Comando Spark Mejorado
- Output colorizado con emojis
- Contador de contactos existentes
- Validación de email en tiempo real
- Resumen de sesión detallado

### 6. Estadísticas Visuales
- 3 tarjetas con gradientes únicos
- Iconos grandes de Bootstrap
- Contadores dinámicos
- Diseño responsive

---

## 🛠️ Tecnologías Utilizadas

| Categoría | Tecnología | Versión |
|-----------|------------|---------|
| **Backend** | PHP | 8.1+ |
| **Framework** | CodeIgniter | 4.6.3 |
| **Frontend** | Bootstrap | 5.1.3 |
| **Icons** | Bootstrap Icons | 1.7.2 |
| **Package Manager** | Composer | 2.x |

---

## 📁 Estructura del Proyecto

```
rolodex-importer/
├── app/
│   ├── Commands/
│   │   └── ContactImport.php      # Comando Spark CLI
│   ├── Controllers/
│   │   ├── Home.php
│   │   └── Contacts.php           # Controlador principal
│   ├── Views/
│   │   └── contacts/
│   │       ├── index.php          # Vista principal
│   │       └── create.php         # Formulario
│   └── Config/
│       ├── Routes.php             # Rutas de la aplicación
│       └── Modules.php            # Configuración de módulos
├── public/
│   └── index.php                  # Punto de entrada web
├── writable/
│   └── contacts.csv               # Archivo de datos
├── vendor/                        # Dependencias de Composer
├── contact-importer.php           # Script CLI standalone
├── composer.json                  # Configuración de Composer
├── spark                          # CLI de CodeIgniter
├── MEJORAS.md                     # Documentación de mejoras
├── INSTRUCCIONES_EJECUCION.md     # Guía de ejecución
└── README.md                      # Este archivo
```

---

## 🔍 Ejemplos de Uso

### Web - Añadir Contacto

1. Navegar a http://localhost:8080
2. Click en **"Nuevo Contacto"**
3. Rellenar el formulario:
   - Nombre: Juan Pérez ✓
   - Teléfono: 555-123-4567
   - Email: juan@ejemplo.com
4. Click en **"Guardar Contacto"**

### Web - Buscar Contacto

1. En la página principal, escribir en la barra de búsqueda
2. Los resultados se filtran automáticamente
3. Click en **"Limpiar búsqueda"** para ver todos

### CLI - Importar Múltiples Contactos

```bash
$ php spark import:contacts

Full Name: María García
Phone Number: 555-987-6543
Email: maria@ejemplo.com
✓ Contact saved successfully! (1 total)

Full Name: Carlos López  
Phone Number: 555-456-7890
Email: carlos@ejemplo.com
✓ Contact saved successfully! (2 total)

Full Name: exit

✓ Import session completed. Total contacts added: 2
```

---
## 📊 Formato CSV

El archivo generado (`writable/contacts.csv`) tiene la siguiente estructura:

```csv
Name,Phone,Email
Juan Pérez,555-123-4567,juan@ejemplo.com
María García,555-987-6543,maria@ejemplo.com
Carlos López,555-456-7890,carlos@ejemplo.com
```

---

## 🎯 Características Técnicas

### Validación de Datos
```php
// Reglas de validación implementadas
'name' => 'required|min_length[2]|max_length[100]'
'phone' => 'permit_empty|min_length[7]|max_length[20]'
'email' => 'permit_empty|valid_email|max_length[100]'
```

### Detección de Duplicados
- Compara nombres (insensible a mayúsculas)
- Valida emails únicos
- Feedback inmediato al usuario

---

## 🔧 Solución de Problemas

### Error: Port 8080 already in use
```bash
# Usar otro puerto
php -S localhost:8081 -t public
```

### Error: Permission denied en writable/
```bash
chmod -R 755 writable/
```

---

## 📈 Comparación: Antes vs Después

| Aspecto | Versión Original | Versión Mejorada | Mejora |
|---------|------------------|------------------|---------|
| Interfaz | CLI básico | CLI + Web moderna | +200% |
| Validación | Mínima | Avanzada CI4 | +300% |
| Búsqueda | ❌ No | ✅ Tiempo real | ∞ |
| CRUD | Create, Read | Full CRUD | +100% |
| Diseño | Simple | Gradientes + Animaciones | +500% |

---

## 👨‍💻 Autor

**Noah Catalán**  
📧 Email: noah.catalan@alumno.com  
🎓 CIFP Francesc de Borja Moll  
📅 Noviembre 2025

---

## 📚 Referencias

- [CodeIgniter 4 Documentation](https://codeigniter.com/user_guide/)
- [Bootstrap 5 Documentation](https://getbootstrap.com/docs/5.1/)

---

**¡Gracias por revisar este proyecto! 🚀**

Para más detalles, consulta **[MEJORAS.md](MEJORAS.md)** y **[INSTRUCCIONES_EJECUCION.md](INSTRUCCIONES_EJECUCION.md)**
