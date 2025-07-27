<?php
// Requerimos el modelo al principio.
require_once 'models/Producto.php'; 

class ProductoController {

    private $model;

    // El constructor prepara el modelo para que lo usen todas las funciones.
    public function __construct() {
        $this->model = new Producto();
    }

    // Muestra el formulario de creación de solicitud
    public function crear() {
        // Es buena práctica que el controlador maneje el header y footer.
        include 'views/includes/header.php';
        include 'views/producto/crear.php'; // Tu vista del formulario
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
                
                // Ruta donde se guardarán las imágenes. ¡Asegúrate de que esta carpeta exista!
                $uploadDir = 'uploads/fotos_tickets/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); // Intenta crear la carpeta si no existe
                }

                // Recorremos cada archivo subido
                foreach ($_FILES['fotos']['tmp_name'] as $key => $tmp_name) {
                    // Creamos un nombre de archivo único para evitar sobreescribir
                    $fileName = time() . '_' . uniqid() . '_' . basename($_FILES['fotos']['name'][$key]);
                    $targetFilePath = $uploadDir . $fileName;

                    // Movemos el archivo de la carpeta temporal a nuestro directorio final
                    if (move_uploaded_file($tmp_name, $targetFilePath)) {
                        $rutasFotos[] = $targetFilePath; // Guardamos la ruta para la BD
                    }
                }
            }

            // 3. Llamar al modelo para que guarde todo en la base de datos
            $exito = $this->model->crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos);

            // 4. Redirigir según el resultado
            if ($exito) {
                // Redirigir a una página de éxito. Podríamos crear una página "misTickets".
                header("Location: index.php?accion=inicio&status=success");
                exit();
            } else {
                // Redirigir de vuelta al formulario con un mensaje de error
                header("Location: index.php?accion=crear&status=error");
                exit();
            }
        }
    }
    
    // Las funciones antiguas como index, guardar, editar, etc., ya no son necesarias
    // para este flujo y han sido eliminadas para mayor claridad.
}
