<?php
require_once 'models/Ticket.php';
require_once 'models/Usuario.php';

class TicketController {
    private $model;
     private $usuarioModel;

    public function __construct() {
        $this->model = new Ticket();
        $this->usuarioModel = new Usuario();
    }

    
    public function mostrarMisTickets() {
        
        $id_tecnico = $_SESSION['id_usuario'];
        
        
        $misTickets = $this->model->obtenerTicketsPorTecnico($id_tecnico);
        
       
        $todosLosEstados = $this->model->obtenerTodosLosEstados();
        
        
        include 'views/includes/header.php';
        include 'views/ticket/mis_tickets.php';
        include 'views/includes/footer.php';
    }

   
    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $id_estado = $_POST['id_estado'];
            
            $this->model->actualizarEstadoTicket($id_ticket, $id_estado);

            
            header("Location: index.php?accion=misTickets&status=success");
            exit();
        }
    }

   
   public function mostrarGestionTickets() {
       
        $todosLosTickets = $this->model->obtenerTodosLosTickets();
        $listaDeTecnicos = $this->usuarioModel->obtenerTodosLosTecnicos();
        
        include 'views/includes/header.php';
        include 'views/ticket/gestionar_tickets.php';
        include 'views/includes/footer.php';
    }

    public function asignarTecnico() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $id_tecnico = $_POST['id_tecnico'];
            
            
            $this->model->asignarTecnicoTicket($id_ticket, $id_tecnico);
            
            header("Location: index.php?accion=gestionarTickets&status=assign_success");
            exit();
        }
    }


}
?>