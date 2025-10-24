    
   
    
<?php
session_start();

require_once("config/Language.php");
Language::init();

require_once("controllers/ProductoController.php");
require_once("controllers/UsuarioController.php");
require_once("controllers/TicketController.php");
require_once("controllers/ChatController.php");
require_once("controllers/EstadoController.php");
require_once("controllers/RolController.php");
require_once("controllers/HistorialController.php");
require_once("controllers/AjustesController.php");


$accion = $_REQUEST['accion'] ?? 'index';


$acciones_publicas = ['login', 'autenticar', 'mostrarRegistro', 'registrar', 'inicio'];


if (!in_array($accion, $acciones_publicas)) {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?accion=inicio");
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

    case 'eliminarSolicitud':
        $controller = new ProductoController();
        $controller->eliminar();
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

    case 'cargarChat':
        $controller = new ChatController();
        $controller->cargarChat();
        break;

    case 'enviarMensaje':
        $controller = new ChatController();
        $controller->enviarMensaje();
        break;

    case 'cargarListaChats':
        $controller = new ChatController();
        $controller->cargarListaChats();
        break;
     
     case 'actualizarEstado':
        $controller = new EstadoController();
        $controller->guardarCambiosEstado();
        break;  
          
   case 'crearEstado':
        $controller = new EstadoController();
        $controller->crearEstadoForm();
        break;

    case 'guardarEstado':
        $controller = new EstadoController();
        $controller->guardarEstado();
        break;

    case 'gestionarEstados':
        $controller = new EstadoController();
        $controller->mostrarGestionEstados();
        break;

    case 'eliminarEstado':
        $controller = new EstadoController();
        $controller->eliminarEstado();
        break;

    case 'listarRoles':
        $controller = new RolController();
        $controller->listarRoles();
        break;
    
    case 'crearRol':
        $controller = new RolController();
        $controller->crearRol();
        break;

    case 'editarRol':
        $controller = new RolController();
        $controller->editarRol();
        break;

    case 'eliminarRol':
        $controller = new RolController();
        $controller->eliminarRol();
        break;

    case 'miPerfil':
        $controller = new UsuarioController();
        $controller->miPerfil();
        break;

    case 'actualizarPerfil':
        $controller = new UsuarioController();
        $controller->actualizarPerfil();
        break;

    case 'cambiarPassword':
        $controller = new UsuarioController();
        $controller->cambiarPassword();
        break;

    case 'actualizarFotoPerfil':
        $controller = new UsuarioController();
        $controller->actualizarFotoPerfil();
        break;

    case 'verHistorial':
        $controller = new HistorialController();
        $controller->listar();
        break;

    case 'ajustes':
        $controller = new AjustesController();
        $controller->mostrar();
        break;
        
    case 'guardarAjustesNotificaciones':
        $controller = new AjustesController();
        $controller->guardarNotificaciones();
        break;
    

    
    case 'inicio':
        include 'views/includes/header.php';
        include 'views/inicio.php';
        include 'views/includes/footer.php';
        break;
        
    case 'cambiarIdioma':
        if (isset($_POST['language'])) {
            Language::setLanguage($_POST['language']);
        }
        // Redireccionar a la página anterior o a perfil
        $redirect = $_POST['redirect'] ?? 'index.php?accion=inicio';
        header("Location: " . $redirect);
        exit;
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
