    
    
<?php
require_once __DIR__ . '/../models/Estado.php';

class EstadoController {
    private $modeloEstado;

    public function __construct() {
        $this->modeloEstado = new Estado();
    }

    // Muestra el formulario para crear un nuevo estado (solo admin)
    public function crearEstadoForm() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        include 'views/includes/header.php';
        include 'views/estado/crear_estado.php';
        include 'views/includes/footer.php';
    }

    // Procesa el guardado del nuevo estado
    public function guardarEstado() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre_estado'])) {
            $nombre = trim($_POST['nombre_estado']);
            $resultado = $this->modeloEstado->create($nombre);
            if ($resultado === true) {
                header('Location: index.php?accion=gestionarEstados&status=success');
                exit();
            } elseif ($resultado === "duplicado") {
                echo "<div class='alert alert-warning m-4'>Ya existe un estado con ese nombre.</div>";
            } else {
                echo "Error al crear el estado.";
            }
        } else {
            echo "Nombre de estado requerido.";
        }
    }

    public function listar() {
        $estados = $this->modeloEstado->getAll();
    }

    public function crear() {
        $nombre = "Pendiente de Piezas";
        if ($this->modeloEstado->create($nombre)) {
            echo "Estado creado con éxito.";
        } else {
            echo "Error al crear el estado.";
        }
    }

    public function eliminar($id) {
        if ($this->modeloEstado->delete($id)) {
            echo "Estado con ID $id eliminado.";
        } else {
            echo "Error al eliminar el estado.";
        }
    }

    public function editar($id,$nombre) {
        if ($this->modeloEstado->update($id,$nombre)) {
            echo "Estado con ID $id Actualizado.";
        } else {
            echo "Error al Actualizar el estado.";
        }
    }

    // Método para actualizar el estado (usado en index.php)
    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_estado = $_POST['id_estado'] ?? null;
            $nombre_estado = $_POST['nombre_estado'] ?? null;
            if ($id_estado && $nombre_estado) {
                if ($this->modeloEstado->update($id_estado, $nombre_estado)) {
                    header('Location: index.php?accion=gestionarEstados&status=success');
                    exit();
                } else {
                    echo "Error al actualizar el estado.";
                }
            } else {
                echo "Datos incompletos para actualizar el estado.";
            }
        }
    }

    // Eliminar estado solo para admin
    public function eliminarEstado() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_estado'])) {
            $id_estado = intval($_POST['id_estado']);
            if ($this->modeloEstado->delete($id_estado)) {
                header('Location: index.php?accion=gestionarEstados&status=deleted');
                exit();
            } else {
                echo "Error al eliminar el estado.";
            }
        } else {
            echo "ID de estado requerido.";
        }
    }

    // Muestra la vista de gestión de estados solo para admin
    public function mostrarGestionEstados() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        $estados = $this->modeloEstado->getAll();
        include 'views/includes/header.php';
        include 'views/estado/gestionar_estados.php';
        include 'views/includes/footer.php';
    }
}

$controller = new EstadoController();
$controller->listar();

