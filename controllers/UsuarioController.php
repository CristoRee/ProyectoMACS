<?php
require_once 'models/Usuario.php';

class UsuarioController {
    private $model;

    public function __construct() {
        $this->model = new Usuario();
    }
    
   

    public function mostrarRegistro() {
        include 'views/includes/header.php';
        include 'views/usuario/crear.php'; 
        include 'views/includes/footer.php';
    }
    
 
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre_usuario'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm']; 

            
            if ($password !== $password_confirm) {
                
                header("Location: index.php?accion=mostrarRegistro&error=password");
                exit();
            }

            $exito = $this->model->crear($nombre, $email, $password);

            if ($exito) {
              
                header("Location: index.php?accion=login&registro=exitoso");
                exit();
            } else {
                
                header("Location: index.php?accion=mostrarRegistro&error=db");
                exit();
            }
        }
    }

    
    public function login() {
        include 'views/includes/header.php';
        include 'views/usuario/login.php';
        include 'views/includes/footer.php';
    }
    
    public function listarUsuarios() {
        $todosLosUsuarios = $this->model->obtenerTodos();
        include 'views/includes/header.php';
        include 'views/usuario/listar.php'; 
        include 'views/includes/footer.php';
    }
    
    public function actualizarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];
            $nombre = $_POST['nombre_usuario'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $id_rol = $_POST['id_rol'];
            $this->model->actualizar($id, $nombre, $email, $telefono, $id_rol);
            header("Location: index.php?accion=listarUsuarios&status=edit_success");
            exit();
        }
    }
    
    public function eliminarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];
            $this->model->eliminar($id);
            header("Location: index.php?accion=listarUsuarios&status=delete_success");
            exit();
        }
    }
    
    public function autenticar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre_usuario = $_POST['usuario']; 
            $password = $_POST['password'];
            $usuario_validado = $this->model->verificar($nombre_usuario, $password);
            if ($usuario_validado) {
                $_SESSION['id_usuario'] = $usuario_validado['id_usuario'];
                $_SESSION['usuario'] = $usuario_validado['nombre_usuario'];
                $_SESSION['rol'] = $usuario_validado['id_rol'];
                header("Location: index.php?accion=inicio");
                exit();
            } else {
                header("Location: index.php?accion=login&error=1");
                exit();
            }
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?accion=login");
        exit();
    }
}