<?php
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/HistorialLogger.php';

class TicketController {
    private $ticketModel; 
    private $usuarioModel;

    public function __construct() {
        $this->ticketModel = new Ticket();
        $this->usuarioModel = new Usuario();
    }

    public function mostrarMisTickets() {
        $id_tecnico = $_SESSION['id_usuario'];
        $misTickets = $this->ticketModel->obtenerTicketsPorTecnico($id_tecnico);
        $todosLosEstados = $this->ticketModel->obtenerTodosLosEstados();
        
        include 'views/includes/header.php';
        include 'views/ticket/mis_tickets.php';
        include 'views/includes/footer.php';
    }

  
   public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $id_estado_nuevo = $_POST['id_estado'];
            
            require_once __DIR__ . '/../models/Estado.php';
            $estadoModel = new Estado();
            
            $debe_notificar = $estadoModel->debeNotificar($id_estado_nuevo);

            $info_ticket_anterior = $this->ticketModel->obtenerInfoSimpleTicket($id_ticket);
            $nombre_estado_anterior = $info_ticket_anterior['nombre_estado'];
            $nombre_estado_nuevo = $estadoModel->obtenerNombreEstadoPorId($id_estado_nuevo);

          
            $exito = $this->ticketModel->actualizarEstadoTicket($id_ticket, $id_estado_nuevo);

            if ($exito) {
             
                $nombre_usuario = $_SESSION['usuario'];
                $mensaje_historial = "El usuario '{$nombre_usuario}' cambió el estado del ticket #{$id_ticket} de '{$nombre_estado_anterior}' a '{$nombre_estado_nuevo}'.";
                HistorialLogger::registrar($mensaje_historial, null, $id_ticket);
                
           
                if ($debe_notificar) {
                    try {
                        require_once 'config/email_config.php';
                        $info_cliente = $this->ticketModel->obtenerInfoParaEmail($id_ticket);
                        
                        $mail = configurarMailer();
                        $mail->addAddress($info_cliente['email'], $info_cliente['nombre_usuario']);
                        
                        $mail->Subject = "Actualización de tu Ticket de Reparación #" . $id_ticket;
                        $mail->Body    = "Hola " . htmlspecialchars($info_cliente['nombre_usuario']) . ",<br><br>Te informamos que el estado de tu ticket de reparación <strong>#" . $id_ticket . "</strong> ha sido actualizado a: <strong>" . htmlspecialchars($nombre_estado_nuevo) . "</strong>.<br><br>Gracias por confiar en BinaryTEC.";
                        $mail->AltBody = "Hola " . htmlspecialchars($info_cliente['nombre_usuario']) . ",\n\nTe informamos que el estado de tu ticket de reparación #" . $id_ticket . " ha sido actualizado a: " . htmlspecialchars($nombre_estado_nuevo) . ".\n\nGracias por confiar en BinaryTEC.";

                        $mail->send();
                    } catch (Exception $e) {
                       
                        error_log("Error al enviar email de notificación: " . $mail->ErrorInfo);
                    }
                }
            }

            $redirect_url = ($_SESSION['rol'] == 1) ? 'index.php?accion=gestionarTickets' : 'index.php?accion=misTickets';
            header("Location: {$redirect_url}&status=success");
            exit();
        }
    }
    
    public function mostrarGestionTickets() {
        $todosLosTickets = $this->ticketModel->obtenerTodosLosTickets();
        $listaDeTecnicos = $this->usuarioModel->obtenerTodosLosTecnicos();
        
        include 'views/includes/header.php';
        include 'views/ticket/gestionar_tickets.php';
        include 'views/includes/footer.php';
    }

    public function asignarTecnico() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $id_tecnico = $_POST['id_tecnico'];
            
            $exito = $this->ticketModel->asignarTecnicoTicket($id_ticket, $id_tecnico);
            
            if ($exito) {
                $nombre_admin = $_SESSION['usuario'];
                $tecnico = $this->usuarioModel->obtenerPorId($id_tecnico);
                $nombre_tecnico = $tecnico ? $tecnico['nombre_usuario'] : 'nadie';
                $mensaje_historial = "El admin '{$nombre_admin}' asignó el ticket #{$id_ticket} al técnico '{$nombre_tecnico}'.";
                HistorialLogger::registrar($mensaje_historial, null, $id_ticket);

                header("Location: index.php?accion=gestionarTickets&status=assign_success");
            } else {
                header("Location: index.php?accion=gestionarTickets&status=assign_error");
            }
            exit();
        }
    }
}
?>