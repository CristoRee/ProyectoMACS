<?php
// El controlador siempre debe requerir el modelo que va a utilizar.
require_once 'models/Usuario.php';

class UsuarioController {
    
    private $model;

    // El constructor prepara el modelo para que todas las funciones lo usen.
    public function __construct() {
        $this->model = new Usuario();
    }

    // Muestra la vista del formulario de login.
    public function login() {
        include 'views/includes/header.php';
        include 'views/usuario/login.php';
        include 'views/includes/footer.php';
    }

    // ===== ¡FUNCIÓN AÑADIDA! =====
    // Muestra la vista del formulario de registro.
    public function mostrarRegistro() {
        include 'views/includes/header.php';
        include 'views/usuario/crear.php'; // Carga la vista de registro
        include 'views/includes/footer.php';
    }
    // ===== FIN DE LA FUNCIÓN AÑADIDA =====

    // Procesa el registro de un nuevo usuario.
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre_usuario'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $exito = $this->model->crear($nombre, $email, $password);

            if ($exito) {
                header("Location: index.php?accion=login&registro=exitoso");
                exit();
            } else {
                echo "Hubo un error al registrar el usuario.";
            }
        }
    }

    // Procesa la autenticación del usuario.
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

    // Cierra la sesión del usuario.
    public function logout() {
        session_destroy();
        header("Location: index.php?accion=login");
        exit();
    }
}