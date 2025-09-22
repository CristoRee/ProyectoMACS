<?php
require_once 'models/Chat.php';

class ChatController {
    private $model;

    public function __construct() {
        $this->model = new Chat();
    }

   
    public function cargarChat() {
        $id_ticket = $_GET['id_ticket'];
        $id_usuario_actual = $_SESSION['id_usuario'];
        
        $id_conversacion = $this->model->obtenerOCrearConversacion($id_ticket);
        $mensajes = $this->model->obtenerMensajes($id_conversacion);
        $infoTicket = $this->model->obtenerInfoTicketParaChat($id_ticket);
        
        $id_receptor = 0;
      
        if ($_SESSION['rol'] == 3) { 
           
            $id_receptor = $infoTicket['id_tecnico_asignado'] ?? null;
        } else {
            $id_receptor = $infoTicket['id_cliente'];
        }
        
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