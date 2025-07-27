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
        include 'views/producto/crear.php';
        include 'views/includes/footer.php';
    }

    // Procesa y guarda la nueva solicitud de reparación
    public function guardarSolicitud() {
        // Verificamos que los datos lleguen por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // 1. Recoger datos del formulario
            $datosProducto = [
                'tipo_producto' => $_POST['tipo_producto'] ?? '',
                'marca' => $_POST['marca'] ?? '',
                'modelo' => $_POST['modelo'] ?? '',
                'id_cliente' => $_SESSION['id_usuario'] // El ID del cliente logueado
            ];

            $datosTicket = [
                'descripcion_problema' => $_POST['descripcion_problema'] ?? '',
                'id_cliente' => $_SESSION['id_usuario'] // El ID del cliente logueado
            ];

            // 2. Procesar las imágenes subidas
            $rutasFotos = [];
            // Verificamos si se subieron archivos y si no hay errores
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

            // 3. Llamar al modelo para que guarde todo en la base de datos
            $exito = $this->model->crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos);

            // 4. Redirigir según el resultado
            if ($exito) {
                // Redirige a la página de inicio con el parámetro de éxito para activar el modal.
                header("Location: index.php?accion=inicio&status=success");
                exit();
            } else {
                // Redirige de vuelta al formulario con un mensaje de error.
                header("Location: index.php?accion=crear&status=error");
                exit();
            }
        }
    }

    // Muestra la lista de solicitudes del cliente actual.
    public function misSolicitudes() {
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?accion=login");
            exit();
        }
        
        $idCliente = $_SESSION['id_usuario'];
        $solicitudes = $this->model->listarPorCliente($idCliente);
        
        include 'views/includes/header.php';
        include 'views/producto/listar.php';
        include 'views/includes/footer.php';
    }
}
