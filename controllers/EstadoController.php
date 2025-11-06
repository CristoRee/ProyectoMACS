<?php
require_once __DIR__ . '/../models/Estado.php';
require_once __DIR__ . '/../models/HistorialLogger.php'; 

class EstadoController {
    private $modeloEstado;

    public function __construct() {
        $this->modeloEstado = new Estado();
    }

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

    public function guardarEstado() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nombre_estado'])) {
            $nombre = trim($_POST['nombre_estado']);
            $resultado = $this->modeloEstado->create($nombre);
            if ($resultado === true) {
                HistorialLogger::registrar("El admin '{$_SESSION['usuario']}' creó el nuevo estado: '{$nombre}'.");
                header('Location: index.php?accion=gestionarEstados&status=created');
                exit();
            } else {
                
                header('Location: index.php?accion=gestionarEstados&status=error');
                exit();
            }
        }
    }
    
   
    public function guardarCambiosEstado() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_estado = $_POST['id_estado'] ?? null;
            $nombre_estado = $_POST['nombre_estado'] ?? null;
            $color = $_POST['color'] ?? '#6c757d';

            if ($id_estado && $nombre_estado) {
                if ($this->modeloEstado->update($id_estado, $nombre_estado, $color)) {
                    HistorialLogger::registrar("El admin '{$_SESSION['usuario']}' actualizó el estado #{$id_estado} a '{$nombre_estado}'.");
                    header('Location: index.php?accion=gestionarEstados&status=updated');
                    exit();
                }
            }
        }
       
        header('Location: index.php?accion=gestionarEstados&status=error');
        exit();
    }

    public function eliminarEstado() {
        if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
            header('Location: index.php?accion=inicio');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id_estado'])) {
            $id_estado = intval($_POST['id_estado']);
            if ($this->modeloEstado->delete($id_estado)) {
                HistorialLogger::registrar("El admin '{$_SESSION['usuario']}' eliminó el estado #{$id_estado}.");
                header('Location: index.php?accion=gestionarEstados&status=deleted');
                exit();
            }
        }
        header('Location: index.php?accion=gestionarEstados&status=error');
        exit();
    }
}