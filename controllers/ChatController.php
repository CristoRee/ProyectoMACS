<?php
require_once 'models/Chat.php';
require_once 'models/Usuario.php'; 

class ChatController {
    private $chatModel;
    private $usuarioModel;

    public function __construct() {
        $this->chatModel = new Chat();
        $this->usuarioModel = new Usuario();
    }

    public function cargarChat() {
        // La lógica de 'cargarChat' es la misma, se basa en id_ticket y target
        $id_ticket = $_GET['id_ticket'] ?? 0;
        if ($id_ticket == 0) {
             header('HTTP/1.1 400 Bad Request');
             echo json_encode(['error' => 'ID de ticket no proporcionado.']);
             exit;
        }

        $target = $_GET['target'] ?? 'ticket';
        $id_usuario_actual = $_SESSION['id_usuario'];
        $rol_usuario_actual = $_SESSION['rol'];
        
        $infoTicket = $this->chatModel->obtenerInfoTicketParaChat($id_ticket);
        
        $id_conversacion = 0;
        $id_receptor = 0;

        if ($target === 'tecnico') {
            $id_admin = $this->usuarioModel->obtenerAdminId();
            $id_tecnico = $infoTicket['id_tecnico_asignado'];
            $id_conversacion = $this->chatModel->obtenerOCrearConversacion($id_ticket, 'PRIVADA', $id_admin, $id_tecnico);
            $id_receptor = ($rol_usuario_actual == 1) ? $id_tecnico : $id_admin;
        } else { 
            $id_conversacion = $this->chatModel->obtenerOCrearConversacion($id_ticket, 'TICKET');
            if ($rol_usuario_actual == 3) {
                $id_receptor = $infoTicket['id_tecnico_asignado'];
            } else { 
                $id_receptor = $infoTicket['id_cliente'];
            }
        }
        
        $mensajes = $this->chatModel->obtenerMensajes($id_conversacion);

        header('Content-Type: application/json');
        echo json_encode([
            'mensajes' => $mensajes,
            'id_conversacion' => $id_conversacion,
            'id_receptor' => $id_receptor,
            'info' => $infoTicket,
            'tecnico_asignado' => !empty($infoTicket['id_tecnico_asignado'])
        ]);
    }
    
    public function enviarMensaje() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $target = $_POST['target'];
            $id_emisor = $_SESSION['id_usuario'];
            $rol_emisor = $_SESSION['rol'];
            $contenido = $_POST['contenido'];
            $infoTicket = $this->chatModel->obtenerInfoTicketParaChat($id_ticket);

            $id_conversacion = 0;
            $id_receptor = 0;
            
            if ($target === 'tecnico') {
                $id_tecnico = $infoTicket['id_tecnico_asignado'];
                $id_admin = $this->usuarioModel->obtenerAdminId();
                $id_receptor = ($rol_emisor == 1) ? $id_tecnico : $id_admin;
                $id_conversacion = $this->chatModel->obtenerOCrearConversacion($id_ticket, 'PRIVADA', $id_admin, $id_tecnico);
            } else {
                $id_conversacion = $this->chatModel->obtenerOCrearConversacion($id_ticket, 'TICKET');
                $id_receptor = ($rol_emisor == 3) ? $infoTicket['id_tecnico_asignado'] : $infoTicket['id_cliente'];
            }
            
            $this->chatModel->enviarMensaje($id_conversacion, $id_emisor, $id_receptor, $contenido);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        }
    }

    public function cargarListaChats() {
        $id_usuario = $_SESSION['id_usuario'];
        $id_rol = $_SESSION['rol'];
        $conversaciones = $this->chatModel->obtenerConversacionesActivas($id_usuario, $id_rol);
        header('Content-Type: application/json');
        echo json_encode($conversaciones);
    }

    public function marcarMensajesLeidos() {
        if (isset($_POST['id_conversacion'])) {
            $id_conversacion = $_POST['id_conversacion'];
            $id_receptor = $_SESSION['id_usuario'];
            $this->chatModel->marcarComoLeido($id_conversacion, $id_receptor);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        }
    }

    public function verificarNuevosMensajes() {
        $id_usuario = $_SESSION['id_usuario'];
        $total = $this->chatModel->contarNuevosMensajes($id_usuario);
        header('Content-Type: application/json');
        echo json_encode(['nuevos_mensajes' => $total]);
    }
}
?>