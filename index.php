<?php
session_start();

// Incluir controladores
require_once("controllers/ProductoController.php");
require_once("controllers/UsuarioController.php");

// Obtener la acción solicitada
$accion = $_GET['accion'] ?? 'index';

// Definir acciones públicas (que no requieren autenticación)
$acciones_publicas = ['login', 'autenticar'];

// Verificar autenticación para acciones privadas
if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
        exit;
    }
}

// Enrutamiento de acciones
switch ($accion) {
    // === ACCIONES DE USUARIO ===
    case 'login':
        $controller = new UsuarioController();
        $controller->login();
        break;
        
    case 'autenticar':
        $controller = new UsuarioController();
        $controller->autenticar();
        break;
        
    case 'logout':
        $controller = new UsuarioController();
        $controller->logout();
        break;
    
    // === ACCIONES DE PRODUCTOS ===
    case 'crear':
        $controller = new ProductoController();
        $controller->crear();
        break;
        
    case 'guardar':
        $controller = new ProductoController();
        $controller->guardar();
        break;
        
    case 'editar':
        $controller = new ProductoController();
        $controller->editar();
        break;
        
    case 'actualizar':
        $controller = new ProductoController();
        $controller->actualizar();
        break;
        
    // Ejemplo: solo los admin pueden borrar productos
    case 'borrar':
        if ($_SESSION['rol'] !== 'admin') {
            // Puedes mostrar un mensaje o redirigir
            header("Location: index.php?error=No tienes permisos para borrar");
            exit;
        }
        $controller = new ProductoController();
        $controller->borrar();
        break;
    
    // === ACCIÓN POR DEFECTO (LISTAR PRODUCTOS) ===
    case 'index':
    default:
        $controller = new ProductoController();
        $controller->index();
        break;

    case 'inicio':
        // Carga el header, la vista de inicio y el footer
        include 'views/includes/header.php';
        include 'views/inicio.php';
        include 'views/includes/footer.php';
        break;
}
?>

