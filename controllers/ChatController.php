<?php
require_once __DIR__ . '/../models/Chat.php';
require_once __DIR__ . '/../models/Usuario.php'; 

class ChatController {
    private $model;
    private $usuarioModel;

    public function __construct() {
        $this->model = new Chat();
    }

    
    public function cargarChat() {
        $id_ticket = $_GET['id_ticket'] ?? null;
        $id_conversacion = $_GET['id_conversacion'] ?? null;
        $target = $_GET['target'] ?? 'ticket'; 
        $id_usuario_actual = $_SESSION['id_usuario'];
        
        $info = [];
        $id_conversacion_final = 0;
        $id_receptor = 0;

        if ($target === 'privado') {
            $id_tecnico = $_GET['id_tecnico'] ?? null;
            if (!$id_conversacion) {
                if ($_SESSION['rol'] == 2) {
                    // Técnico inicia con admin
                    $this->usuarioModel = new Usuario();
                    $id_admin = $this->usuarioModel->obtenerPrimerAdminId();
                    if (!$id_admin) {
                        header('HTTP/1.1 500 Internal Server Error');
                        echo json_encode(['error' => 'No se pudo encontrar admin.']);
                        exit;
                    }
                    $id_conversacion_final = $this->model->obtenerOCrearConversacionPrivada($id_usuario_actual, $id_admin);
                    $id_receptor = $id_admin;
                    $nombres = $this->model->obtenerNombresUsuarios([$id_usuario_actual, $id_admin]);
                    $info = [
                        'nombre_cliente' => $nombres[$id_usuario_actual] . ' - ' . $nombres[$id_admin],
                        'tipo_producto' => '',
                        'marca' => '',
                        'nombre_tecnico' => ''
                    ];
                } elseif ($_SESSION['rol'] == 1 && $id_tecnico) {
                    // Admin inicia con técnico
                    $id_conversacion_final = $this->model->obtenerOCrearConversacionPrivada($id_usuario_actual, $id_tecnico);
                    $id_receptor = $id_tecnico;
                    $nombres = $this->model->obtenerNombresUsuarios([$id_usuario_actual, $id_tecnico]);
                    $info = [
                        'nombre_cliente' => $nombres[$id_usuario_actual] . ' - ' . $nombres[$id_tecnico],
                        'tipo_producto' => '',
                        'marca' => '',
                        'nombre_tecnico' => ''
                    ];
                } else {
                    header('HTTP/1.1 500 Internal Server Error');
                    echo json_encode(['error' => 'No autorizado para iniciar chat privado.']);
                    exit;
                }
            } else {
                $id_conversacion_final = $id_conversacion;
                $conv = $this->model->obtenerParticipantesConversacion($id_conversacion);
                $id_receptor = ($id_usuario_actual == $conv['id_participante1']) ? $conv['id_participante2'] : $conv['id_participante1'];
                $nombres = $this->model->obtenerNombresUsuarios([$conv['id_participante1'], $conv['id_participante2']]);
                $info = [
                    'nombre_cliente' => $nombres[$conv['id_participante1']] . ' - ' . $nombres[$conv['id_participante2']],
                    'tipo_producto' => '',
                    'marca' => '',
                    'nombre_tecnico' => ''
                ];
            }
        } elseif ($target === 'tecnico' && ($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2)) {
            $infoTicket = $this->model->obtenerInfoTicketParaChat($id_ticket);
            $this->usuarioModel = new Usuario();
            $id_admin = $this->usuarioModel->obtenerPrimerAdminId();
            $id_tecnico = $infoTicket['id_tecnico_asignado'];

            if (!$id_admin || !$id_tecnico) {
                header('HTTP/1.1 500 Internal Server Error');
                echo json_encode(['error' => 'No se pudo determinar los participantes del chat.']);
                exit;
            }

            $id_conversacion_final = $this->model->obtenerOCrearConversacion($id_ticket, 'PRIVADA', $id_tecnico, $id_admin);
            
           
            $id_receptor = ($id_usuario_actual == $id_tecnico) ? $id_admin : $id_tecnico;
            $info = $infoTicket;
        } else { 
            $infoTicket = $this->model->obtenerInfoTicketParaChat($id_ticket);
            $id_conversacion_final = $this->model->obtenerOCrearConversacion($id_ticket, 'TICKET');
            
           
            if ($id_usuario_actual == $infoTicket['id_cliente']) {
                $id_receptor = $infoTicket['id_tecnico_asignado'];
            } else { 
                $id_receptor = $infoTicket['id_cliente'];
            }
            $info = $infoTicket;
        }
        
        $mensajes = $this->model->obtenerMensajes($id_conversacion_final);

        // Marcar mensajes como leídos para el usuario actual
        $this->model->marcarComoLeidos($id_conversacion_final, $id_usuario_actual);

        header('Content-Type: application/json');
        echo json_encode([
            'mensajes' => $mensajes,
            'id_conversacion' => $id_conversacion_final,
            'id_receptor' => $id_receptor,
            'info' => $info,
            'tecnico_asignado' => !empty($info['id_tecnico_asignado'])
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

    public function cargarTecnicos() {
        $this->usuarioModel = new Usuario();
        $tecnicos = $this->usuarioModel->obtenerTodosLosTecnicos();
        header('Content-Type: application/json');
        echo json_encode($tecnicos);
    }
}
?>