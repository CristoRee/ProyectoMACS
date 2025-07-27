<?php
session_start();

// Incluir controladores
require_once("controllers/ProductoController.php");
require_once("controllers/UsuarioController.php");

// Obtener la acción solicitada
$accion = $_GET['accion'] ?? 'index';

// Definir acciones públicas (que no requieren autenticación)
$acciones_publicas = ['login', 'autenticar', 'mostrarRegistro', 'registrar'];

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

    case 'mostrarRegistro':
        $controller = new UsuarioController();
        $controller->mostrarRegistro();
        break;

    case 'registrar':
        $controller = new UsuarioController();
        $controller->registrar();
        break;
    
    // === ACCIONES DE PRODUCTOS ===
    case 'crear':
        $controller = new ProductoController();
        $controller->crear();
        break;
    
    case 'guardarSolicitud':
        $controller = new ProductoController();
        $controller->guardarSolicitud();
        break;

    case 'misSolicitudes':
        $controller = new ProductoController();
        $controller->misSolicitudes();
        break;
        
    // === ACCIÓN POR DEFECTO Y DE INICIO ===
    case 'inicio':
        // Carga el header, la vista de inicio y el footer
        include 'views/includes/header.php';
        include 'views/inicio.php';
        include 'views/includes/footer.php';
        break;

    case 'index':
    default:
        // Si el usuario está logueado, lo mandamos a inicio. Si no, a login.
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=inicio");
        } else {
            header("Location: index.php?accion=login");
        }
        exit;
}
?>
