<?php
require_once 'models/Producto.php'; 

class ProductoController {

    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    // Muestra el formulario de creación de solicitud
    public function crear() {
        include 'views/includes/header.php';
        include 'views/productos/crear.php';
        include 'views/includes/footer.php';
    }

    // Procesa y guarda la nueva solicitud de reparación
    public function guardarSolicitud() {
        // ... (tu código para guardar la solicitud que ya funciona)
    }

    // ===== FUNCIÓN NUEVA =====
    // Muestra la lista de solicitudes del cliente actual.
    public function misSolicitudes() {
        // Nos aseguramos de que el usuario haya iniciado sesión.
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?accion=login");
            exit();
        }
        
        $idCliente = $_SESSION['id_usuario'];
        // Llamamos a una nueva función en el modelo para obtener los datos.
        $solicitudes = $this->model->listarPorCliente($idCliente);
        
        // Cargamos la vista que mostrará la lista.
        include 'views/includes/header.php';
        include 'views/producto/listar.php';
        include 'views/includes/footer.php';
    }
}
