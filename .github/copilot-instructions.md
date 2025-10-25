# ProyectoMACS - Copilot Instructions

## Architecture Overview

**ProyectoMACS** is a multilingual (Spanish/English/Portuguese) ticket management system built with vanilla PHP following an MVC pattern. The application manages device repair tickets with user roles, chat functionality, and parts inventory.

### Core Components

- **Language System**: All text is internationalized using `Language::get()` or `__()` function. Translations in `/lang/{es,en,pt}.json`
- **Session Management**: User authentication stored in `$_SESSION['usuario']`, roles in `$_SESSION['rol']`
- **Database**: MySQL with PDO connections via `config/conexion.php`
- **Routing**: Single `index.php` with action-based routing (`?accion=controller_action`)

### Key Directories

```
controllers/    # Business logic (UsuarioController, TicketController, etc.)
models/        # Data access layer (Usuario, Ticket, Chat, etc.) 
views/         # UI templates with PHP includes
config/        # Database connection and Language class
lang/          # JSON translation files
assets/        # CSS, JS, images, sounds
```

## Development Patterns

### Controller Pattern
Controllers handle HTTP requests and coordinate between models/views:
```php
// In index.php
case 'crearTicket':
    $controller = new TicketController();
    $controller->crear();
    break;
```

### Language Switching
When changing language via forms, always redirect to scroll to page top:
```php
// Always append lang_changed=1 parameter for scroll-to-top behavior
$redirect .= $separator . 'lang_changed=1';
header("Location: " . $redirect);
```

### Model Operations
Models use prepared statements and return structured data:
```php
$stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE id_usuario = ?");
$stmt->bind_param("i", $id_usuario);
```

### View Structure
Views include header/footer and use translation functions:
```php
include 'views/includes/header.php';
// View content with __('translation_key')
include 'views/includes/footer.php';
```

## Critical Development Workflows

### Adding New Translations
1. Add keys to all three files: `/lang/{es,en,pt}.json`
2. Use `<?php echo __('new_key'); ?>` in templates
3. Test language switching maintains scroll position

### Role-Based Access
Check user roles before sensitive operations:
```php
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?accion=inicio");
    exit;
}
```

### Chat System
Real-time chat uses AJAX polling to `ChatController`. Each ticket can have multiple chat conversations (public ticket chat + private user-tech chats).

### File Uploads
Profile photos and ticket attachments go to `/uploads/{perfiles,fotos_tickets}/` with security validation.

## Database Integration

- Use `HistorialLogger::registrar()` for audit logging of user actions
- All timestamp fields use MySQL DATETIME format
- Foreign keys maintain referential integrity between tickets, users, parts

## Frontend Patterns

### Bootstrap 5 + Custom CSS
- Dark mode toggle in `footer.php` with localStorage persistence
- Mobile-responsive navigation and forms
- Custom animations for language switching and notifications

### JavaScript Organization
- Main scripts in `footer.php` within DOMContentLoaded
- Language change detection scrolls page to top via URL parameter
- Chat functionality uses fetch API for real-time updates

## Testing & Debugging

Access via XAMPP at `http://localhost/ProyectoMACS/`
- Default login credentials in database seeding files
- Check `Documentos/` for SQL schema and sample data
- Error logging in PHP error log and custom HistorialLogger

## Common Gotchas

- Always use `htmlspecialchars()` on user input in views
- Language parameter cleanup in URL after redirect to prevent clutter
- Chat popover positioning requires Bootstrap JS initialization
- File upload validation for security (size, type, directory traversal)