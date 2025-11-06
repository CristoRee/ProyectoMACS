<?php
require_once 'models/Ticket.php';
require_once 'models/Usuario.php';
require_once 'models/HistorialLogger.php';
require_once 'models/Estado.php';
require_once 'services/EmailService.php'; // <-- Se incluye el nuevo servicio de Email

class TicketController {
    private $ticketModel; 
    private $usuarioModel;
    private $estadoModel;
    private $emailService; // <-- NUEVO: Propiedad para el servicio de email
    private $adminEmail;   // (Esta propiedad no la usaremos aquí, pero está bien en tu constructor)

    public function __construct() {
        $this->ticketModel = new Ticket();
        $this->usuarioModel = new Usuario();
        $this->estadoModel = new Estado(); 
        $this->emailService = new EmailService(); // <-- NUEVO: Se instancia el servicio de email
        
        // Esta parte es correcta para cargar la configuración
        $config = include __DIR__ . '/../config/email_config.php';
        $this->adminEmail = $config['notifications']['admin_email'] ?? null;
    }

    public function mostrarMisTickets() {
        $id_tecnico = $_SESSION['id_usuario'];
        $vista = $_GET['vista'] ?? 'activos';
        
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? max(10, intval($_GET['per_page'])) : 15;
        
        $paginacion = $this->ticketModel->obtenerTicketsPorTecnicoConPaginacion($id_tecnico, $vista, $page, $perPage);
        
        $misTickets = $paginacion['tickets'];
        $totalRecords = $paginacion['total'];
        $totalPages = $paginacion['totalPages'];
        $currentPage = $paginacion['currentPage'];
        $recordsPerPage = $paginacion['perPage'];
        $startRecord = $paginacion['startRecord'];
        $endRecord = $paginacion['endRecord'];
        
        $baseUrl = 'index.php?accion=misTickets&vista=' . $vista;
        if (isset($_GET['per_page'])) {
            $baseUrl .= '&per_page=' . $recordsPerPage;
        }
        
        $todosLosEstados = $this->estadoModel->getAll();
        
        include 'views/includes/header.php';
        include 'views/ticket/mis_tickets.php';
        include 'views/includes/footer.php';
    }
 
    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $id_estado_nuevo = $_POST['id_estado'];
            
            $debe_notificar = $this->estadoModel->debeNotificar($id_estado_nuevo);
            $info_ticket_anterior = $this->ticketModel->obtenerInfoSimpleTicket($id_ticket);
            $nombre_estado_anterior = $info_ticket_anterior['nombre_estado'];
            $nombre_estado_nuevo = $this->estadoModel->obtenerNombreEstadoPorId($id_estado_nuevo);

            $exito = $this->ticketModel->actualizarEstadoTicket($id_ticket, $id_estado_nuevo);

            if ($exito) {
                $nombre_usuario = $_SESSION['usuario'];
                $mensaje_historial = "El usuario '{$nombre_usuario}' cambió el estado del ticket #{$id_ticket} de '{$nombre_estado_anterior}' a '{$nombre_estado_nuevo}'.";
                HistorialLogger::registrar($mensaje_historial, null, $id_ticket);
                
                // =============================================
                // LÓGICA DE EMAIL ACTUALIZADA
                // =============================================
                if ($debe_notificar) {
                    try {
                        // Ya no se llama a configurarMailer()
                        $info_cliente = $this->ticketModel->obtenerInfoParaEmail($id_ticket);
                        
                        $asunto = "Actualización de tu Ticket de Reparación #" . $id_ticket;
                        $mensaje = "Hola " . htmlspecialchars($info_cliente['nombre_usuario']) . ",<br><br>Te informamos que el estado de tu ticket de reparación <strong>#" . $id_ticket . "</strong> ha sido actualizado a: <strong>" . htmlspecialchars($nombre_estado_nuevo) . "</strong>.<br><br>Gracias por confiar en BinaryTEC.";

                        // Usamos el nuevo servicio de email que ya está en $this->emailService
                        $this->emailService->enviarNotificacion($info_cliente['email'], $asunto, $mensaje);

                    } catch (Exception $e) {
                        error_log("Error al enviar email de notificación: " . $e->getMessage());
                    }
                }
            }

            $redirect_url = ($_SESSION['rol'] == 2) ? 'index.php?accion=misTickets' : 'index.php?accion=gestionarTickets';
            header("Location: {$redirect_url}&status=" . ($exito ? 'success' : 'error'));
            exit();
        }
    }
    
    public function mostrarGestionTickets() {
        $vista = $_GET['vista'] ?? 'activos';
        
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? max(10, intval($_GET['per_page'])) : 20;
        
        $paginacion = $this->ticketModel->obtenerTodosLosTicketsConPaginacion($vista, $page, $perPage);
        
        $todosLosTickets = $paginacion['tickets'];
        $totalRecords = $paginacion['total'];
        $totalPages = $paginacion['totalPages'];
        $currentPage = $paginacion['currentPage'];
        $recordsPerPage = $paginacion['perPage'];
        $startRecord = $paginacion['startRecord'];
        $endRecord = $paginacion['endRecord'];
        
        $baseUrl = 'index.php?accion=gestionarTickets&vista=' . $vista;
        if (isset($_GET['per_page'])) {
            $baseUrl .= '&per_page=' . $recordsPerPage;
        }
        
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
                $tecnico = $id_tecnico ? $this->usuarioModel->obtenerPorId($id_tecnico) : null;
                $nombre_tecnico = $tecnico ? $tecnico['nombre_usuario'] : 'nadie (se ha desasignado)';
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