<?php
require_once __DIR__ . '/../models/Historial.php';

class HistorialController {
    private $model;

    public function __construct() {
        $this->model = new Historial();
    }

    public function listar() {
       
        $id_ticket_filtro = $_GET['id_ticket'] ?? null;
        
        $historial = $this->model->listar($id_ticket_filtro);
        
        include 'views/includes/header.php';
        include 'views/historial/listar.php';
        include 'views/includes/footer.php';
    }
}
?>