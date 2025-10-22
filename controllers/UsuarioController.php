<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/HistorialLogger.php';

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
            if ($exito === true) {
               
                HistorialLogger::registrar("Se registró un nuevo usuario: '{$nombre}'.");
                header("Location: index.php?accion=login&registro=exitoso");
                exit();
            } elseif ($exito === 'duplicate') {
                header("Location: index.php?accion=mostrarRegistro&error=email_duplicate");
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
            $exito = $this->model->actualizar($id, $nombre, $email, $telefono, $id_rol);
            if ($exito) {
              
                $admin_nombre = $_SESSION['usuario'];
                HistorialLogger::registrar("El admin '{$admin_nombre}' actualizó el perfil del usuario #{$id}.");
                header("Location: index.php?accion=listarUsuarios&status=edit_success");
            } else {
                header("Location: index.php?accion=listarUsuarios&status=edit_error");
            }
            exit();
        }
    }
    
    public function eliminarUsuario() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id_usuario'];
            $exito = $this->model->eliminar($id);
            if ($exito) {
           
                $admin_nombre = $_SESSION['usuario'];
                HistorialLogger::registrar("El admin '{$admin_nombre}' eliminó al usuario #{$id}.");
                header("Location: index.php?accion=listarUsuarios&status=delete_success");
            } else {
                header("Location: index.php?accion=listarUsuarios&status=delete_error");
            }
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
                $_SESSION['foto_perfil'] = $usuario_validado['foto_perfil'];

                HistorialLogger::registrar("El usuario '{$usuario_validado['nombre_usuario']}' inició sesión.", $usuario_validado['id_usuario']);

                header("Location: index.php?accion=inicio");
                exit();
            } else {
                header("Location: index.php?accion=login&error=1");
                exit();
            }
        }
    }

    public function logout() {
      
        if (isset($_SESSION['usuario'])) {
            $nombre_usuario = $_SESSION['usuario'];
            HistorialLogger::registrar("El usuario '{$nombre_usuario}' cerró sesión.", $_SESSION['id_usuario']);
        }
        session_destroy();
        header("Location: index.php?accion=login");
        exit();
    }

    public function miPerfil() {
        $usuario = $this->model->obtenerPorId($_SESSION['id_usuario']);
        include 'views/includes/header.php';
        include 'views/usuario/perfil.php';
        include 'views/includes/footer.php';
    }

    public function actualizarFotoPerfil() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'];
            $ruta_foto = null;

            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = $_FILES['foto_perfil']['type'];
                
                if (!in_array($fileType, $allowedTypes)) {
                    header("Location: index.php?accion=miPerfil&status=invalid_file_type");
                    exit();
                }
                
                $maxSize = 5 * 1024 * 1024; // 5MB
                if ($_FILES['foto_perfil']['size'] > $maxSize) {
                    header("Location: index.php?accion=miPerfil&status=file_too_large");
                    exit();
                }
                
                $uploadDir = 'uploads/perfiles/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                
                $extension = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
                $extension = strtolower($extension);
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    header("Location: index.php?accion=miPerfil&status=invalid_extension");
                    exit();
                }
                
                $fileName = 'user_' . $id_usuario . '_' . uniqid() . '.' . $extension; 
                $targetFilePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $targetFilePath)) {
                    $ruta_foto = $targetFilePath;
                } else {
                    header("Location: index.php?accion=miPerfil&status=upload_error");
                    exit();
                }
            } else {
                header("Location: index.php?accion=miPerfil&status=no_file");
                exit();
            }
            
            if ($ruta_foto_actualizada = $this->model->actualizarFoto($id_usuario, $ruta_foto)) {
                $_SESSION['foto_perfil'] = $ruta_foto_actualizada; 

                HistorialLogger::registrar("El usuario '{$_SESSION['usuario']}' actualizó su foto de perfil.");

                header("Location: index.php?accion=miPerfil&status=photo_success");
            } else {
                header("Location: index.php?accion=miPerfil&status=error");
            }
            exit();
        }
    }
 
    public function actualizarPerfil() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'];
            $nombre = $_POST['nombre_usuario'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            
            if ($this->model->actualizarPerfil($id_usuario, $nombre, $email, $telefono, null)) {
                $_SESSION['usuario'] = $nombre;

               
                HistorialLogger::registrar("El usuario '{$nombre}' actualizó sus datos de perfil.");

                header("Location: index.php?accion=miPerfil&status=profile_success");
            } else {
                header("Location: index.php?accion=miPerfil&status=error");
            }
            exit();
        }
    }
    
    public function cambiarPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_usuario = $_SESSION['id_usuario'];
            $password_actual = $_POST['password_actual'];
            $password_nueva = $_POST['password_nueva'];
            $password_confirm = $_POST['password_confirm'];

            if ($password_nueva !== $password_confirm) {
                header("Location: index.php?accion=miPerfil&status=pwd_mismatch");
                exit();
            }

            $usuario_actual = $this->model->verificar($_SESSION['usuario'], $password_actual);
            if (!$usuario_actual) {
                header("Location: index.php?accion=miPerfil&status=pwd_incorrect");
                exit();
            }

            $nuevo_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
            if ($this->model->actualizarPassword($id_usuario, $nuevo_hash)) {
                
                HistorialLogger::registrar("El usuario '{$_SESSION['usuario']}' cambió su contraseña.");

                header("Location: index.php?accion=miPerfil&status=pwd_success");
            } else {
                header("Location: index.php?accion=miPerfil&status=error");
            }
            exit();
        }
    }
}
?>