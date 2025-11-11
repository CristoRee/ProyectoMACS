<?php
require_once 'models/Producto.php'; 
require_once 'models/HistorialLogger.php'; // <-- AÑADIDO

class ProductoController {

    private $model;

    public function __construct() {
        $this->model = new Producto();
    }

    public function crear() {
        include 'views/includes/header.php';
        include 'views/producto/crear.php';
        include 'views/includes/footer.php';
    }

    public function guardarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datosProducto = [
                'tipo_producto' => $_POST['tipo_producto'] ?? '',
                'marca' => $_POST['marca'] ?? '',
                'modelo' => $_POST['modelo'] ?? '',
                'id_cliente' => $_SESSION['id_usuario'] 
            ];
            $datosTicket = [
                'descripcion_problema' => $_POST['descripcion_problema'] ?? '',
                'id_cliente' => $_SESSION['id_usuario'] 
            ];
            
            $rutasFotos = [];
            if (isset($_FILES['fotos']) && $_FILES['fotos']['error'][0] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/fotos_tickets/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                    $fileName = time() . '_' . uniqid() . '_' . basename($_FILES['fotos']['name'][$key]);
                    $targetFilePath = $uploadDir . $fileName;
                    if (move_uploaded_file($tmp_name, $targetFilePath)) {
                        $rutasFotos[] = $targetFilePath;
                    }
                }
            }

            $exito = $this->model->crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos);
            
            if ($exito) {
                // REGISTRAMOS LA ACCIÓN EN EL HISTORIAL
                $nombre_usuario = $_SESSION['usuario'];
                HistorialLogger::registrar("El cliente '{$nombre_usuario}' creó una nueva solicitud.");

                header("Location: index.php?accion=inicio&status=success");
                exit();
            } else {
                header("Location: index.php?accion=crear&status=error");
                exit();
            }
        }
    }

    /**
     * MODIFICADO: Ahora pasa el filtro 'vista' al modelo.
     */
    public function misSolicitudes() {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?accion=login");
            exit();
        }
        
        $idCliente = $_SESSION['id_usuario'];
        
        // 1. Lee el parámetro 'vista' de la URL.
        $vista = $_GET['vista'] ?? 'activos';

        // 2. Pasa el filtro 'vista' al método del modelo.
        $solicitudes = $this->model->listarPorCliente($idCliente, $vista);
        
        include 'views/includes/header.php';
        include 'views/producto/listar.php';
        include 'views/includes/footer.php';
    }

    public function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_ticket = $_POST['id_ticket'];
            $id_cliente = $_SESSION['id_usuario'];

            $exito = $this->model->eliminarSolicitud($id_ticket, $id_cliente);

            if ($exito) {
                // REGISTRAMOS LA ACCIÓN EN EL HISTORIAL
                $nombre_usuario = $_SESSION['usuario'];
                HistorialLogger::registrar("El cliente '{$nombre_usuario}' eliminó su solicitud #{$id_ticket}.");
            }

            header("Location: index.php?accion=misSolicitudes&status=deleted");
            exit();
        } else {
            header("Location: index.php?accion=inicio");
            exit();
        }
    }
}
?>