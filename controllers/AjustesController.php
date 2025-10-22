<?php
require_once __DIR__ . '/../models/Estado.php'; 

class AjustesController {
    private $estadoModel;

    public function __construct() {
        $this->estadoModel = new Estado();
    }

    public function mostrar() {
        $estados = $this->estadoModel->getAll(); 
        include 'views/includes/header.php';
        include 'views/ajustes/notificaciones.php'; 
        include 'views/includes/footer.php';
    }

    public function guardarNotificaciones() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $estados_a_notificar = $_POST['notificar'] ?? [];
            $this->estadoModel->actualizarNotificaciones($estados_a_notificar);

            header("Location: index.php?accion=ajustes&status=success");
            exit();
        }
    }
}
?>