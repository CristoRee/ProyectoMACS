<?php
session_start();


require_once("controllers/ProductoController.php");
require_once("controllers/UsuarioController.php");
require_once("controllers/TicketController.php");


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

    case 'listarUsuarios':
        $controller = new UsuarioController();
        $controller->listarUsuarios();
        break;

    case 'actualizarUsuario':
        $controller = new UsuarioController();
        $controller->actualizarUsuario();
        break;

    case 'eliminarUsuario':
        $controller = new UsuarioController();
        $controller->eliminarUsuario();
        break;
    
    case 'guardarSolicitud':
        $controller = new ProductoController();
        $controller->guardarSolicitud();
        break;

    case 'misSolicitudes':
        $controller = new ProductoController();
        $controller->misSolicitudes();
        break;

  
    case 'misTickets':
        $controller = new TicketController();
        $controller->mostrarMisTickets();
        break;
    
    case 'actualizarTicketEstado':
        $controller = new TicketController();
        $controller->actualizarEstado();
        break;
    
     case 'gestionarTickets':
        $controller = new TicketController();
        $controller->mostrarGestionTickets();
        break;

    case 'asignarTecnico':
        $controller = new TicketController();
        $controller->asignarTecnico();
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
