<?php
require_once 'models/Rol.php';

class RolController {
    private $model;

    public function __construct() {
        $this->model = new Rol();
    }

    
    public function listarRoles() {
        $roles = $this->model->listar();
        include 'views/includes/header.php';
        include 'views/rol/listar.php';
        include 'views/includes/footer.php';
    }

    
    public function crearRol() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_rol = $_POST['nombre_rol'];
            if ($this->model->crear($nombre_rol)) {
                header("Location: index.php?accion=listarRoles");
                exit();
            }
        }
        include 'views/includes/header.php';
        include 'views/rol/crear.php';
        include 'views/includes/footer.php';
    }

    
    public function editarRol() {
        $id_rol = $_GET['id'] ?? null;
        if (!$id_rol) {
            header("Location: index.php?accion=listarRoles");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_rol = $_POST['nombre_rol'];
            if ($this->model->actualizar($id_rol, $nombre_rol)) {
                header("Location: index.php?accion=listarRoles");
                exit();
            }
        }

        $rol = $this->model->obtenerPorId($id_rol);
        include 'views/includes/header.php';
        include 'views/rol/editar.php';
        include 'views/includes/footer.php';
    }

  
    public function eliminarRol() {
        $id_rol = $_GET['id'] ?? null;
        if ($id_rol && $this->model->eliminar($id_rol)) {
            header("Location: index.php?accion=listarRoles");
            exit();
        }
    }
}
?>
