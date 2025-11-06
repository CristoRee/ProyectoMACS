<?php
require_once 'models/Historial.php';

class HistorialController {
    private $model;

    public function __construct() {
        $this->model = new Historial();
    }

    public function listar() {
        $id_ticket_filtro = $_GET['id_ticket'] ?? null;
        
        // Obtener parámetros de paginación
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? max(10, intval($_GET['per_page'])) : 30;
        
        // Obtener datos con paginación
        $paginacion = $this->model->listarConPaginacion($id_ticket_filtro, $page, $perPage);
        
        // Extraer variables para la vista
        $historial = $paginacion['historial'];
        $totalRecords = $paginacion['total'];
        $totalPages = $paginacion['totalPages'];
        $currentPage = $paginacion['currentPage'];
        $recordsPerPage = $paginacion['perPage'];
        $startRecord = $paginacion['startRecord'];
        $endRecord = $paginacion['endRecord'];
        
        // URL base para paginación
        $baseUrl = 'index.php?accion=verHistorial';
        if ($id_ticket_filtro) {
            $baseUrl .= '&id_ticket=' . $id_ticket_filtro;
        }
        if (isset($_GET['per_page'])) {
            $baseUrl .= '&per_page=' . $recordsPerPage;
        }
        
        include 'views/includes/header.php';
        include 'views/historial/listar.php';
        include 'views/includes/footer.php';
    }
}
?>