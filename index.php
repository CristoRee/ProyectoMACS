<?php
session_start();


require_once("controllers/ProductoController.php");
require_once("controllers/UsuarioController.php");


$accion = $_GET['accion'] ?? 'index';


$acciones_publicas = ['login', 'autenticar', 'mostrarRegistro', 'registrar'];


if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=login");
        exit;
    }
}


switch ($accion) {
   
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
        
 
    case 'inicio':
        
        include 'views/includes/header.php';
        include 'views/inicio.php';
        include 'views/includes/footer.php';
        break;

    case 'index':
    default:
        
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?accion=inicio");
        } else {
            header("Location: index.php?accion=login");
        }
        exit;
}
?>
