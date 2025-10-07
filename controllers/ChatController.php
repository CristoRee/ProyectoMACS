<?php
require_once 'models/Chat.php';

class ChatController {
    private $model;

    public function __construct() {
        $this->model = new Chat();
    }

    /**
     * MODIFICADO: Ahora maneja un parámetro 'target' para diferenciar los chats.
     */
    public function cargarChat() {
        $id_ticket = $_GET['id_ticket'];
        $target = $_GET['target'] ?? 'ticket'; // 'ticket' (público) o 'tecnico' (privado)
        $id_usuario_actual = $_SESSION['id_usuario'];
        
        $infoTicket = $this->model->obtenerInfoTicketParaChat($id_ticket);
        
        $id_conversacion = 0;
        $id_receptor = 0;

        // Si el admin quiere chatear en privado con el técnico
        if ($target === 'tecnico' && $_SESSION['rol'] == 1) {
            $id_conversacion = $this->model->obtenerOCrearConversacion($id_ticket, 'PRIVADA', $id_usuario_actual, $infoTicket['id_tecnico_asignado']);
            $id_receptor = $infoTicket['id_tecnico_asignado'];
        } else { // Para todos los demás casos, es un chat de TICKET (cliente-técnico-admin)
            $id_conversacion = $this->model->obtenerOCrearConversacion($id_ticket, 'TICKET');
            if ($_SESSION['rol'] == 3) { // Si el Cliente escribe
                $id_receptor = $infoTicket['id_tecnico_asignado'];
            } else { // Si el Técnico o Admin escriben
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