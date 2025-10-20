<?php
require_once 'models/Chat.php';
require_once 'models/Usuario.php'; 

class ChatController {
    private $model;
    private $usuarioModel;

    public function __construct() {
        $this->model = new Chat();
    }

    
    public function cargarChat() {
        $id_ticket = $_GET['id_ticket'];
        $target = $_GET['target'] ?? 'ticket'; 
        $id_usuario_actual = $_SESSION['id_usuario'];
        
        $infoTicket = $this->model->obtenerInfoTicketParaChat($id_ticket);
        
        $id_conversacion = 0;
        $id_receptor = 0;

     
       
        if ($target === 'tecnico' && ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)) {
            $this->usuarioModel = new Usuario();
            $id_admin = $this->usuarioModel->obtenerPrimerAdminId();
            $id_tecnico = $infoTicket['id_tecnico_asignado'];

            if (!$id_admin || !$id_tecnico) {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'No se pudo determinar los participantes del chat.']);
                exit;
            }

            $id_conversacion = $this->model->obtenerOCrearConversacion($id_ticket, 'PRIVADA', $id_tecnico, $id_admin);
            
           
            $id_receptor = ($id_usuario_actual == $id_tecnico) ? $id_admin : $id_tecnico;

        } else { 
            $id_conversacion = $this->model->obtenerOCrearConversacion($id_ticket, 'TICKET');
            
           
            if ($id_usuario_actual == $infoTicket['id_cliente']) {
                $id_receptor = $infoTicket['id_tecnico_asignado'];
            } else { 
                $id_receptor = $infoTicket['id_cliente'];
            }
        }
        
        $mensajes = $this->model->obtenerMensajes($id_conversacion);

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
            $id_conversacion = $_POST['id_conversacion'];
            $id_receptor = $_POST['id_receptor']; 
            $contenido = $_POST['contenido'];
            $id_emisor = $_SESSION['id_usuario'];

           
            $this->model->enviarMensaje($id_conversacion, $id_emisor, $id_receptor, $contenido);
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        }
    }

    public function cargarListaChats() {
        $id_usuario = $_SESSION['id_usuario'];
        $nombre_rol = '';
        if ($_SESSION['rol'] == 1) $nombre_rol = 'Administrador';
        if ($_SESSION['rol'] == 2) $nombre_rol = 'Técnico';
        if ($_SESSION['rol'] == 3) $nombre_rol = 'Cliente';
        $conversaciones = $this->model->obtenerConversacionesActivas($id_usuario, $nombre_rol);
        header('Content-Type: application/json');
        echo json_encode($conversaciones);
    }
}
?>