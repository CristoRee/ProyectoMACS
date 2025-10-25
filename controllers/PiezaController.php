<?php
require_once __DIR__ . '/../models/Pieza.php';
require_once __DIR__ . '/../models/Ticket.php';
require_once __DIR__ . '/../models/Usuario.php';

class PiezaController {
    private $piezaModel;
    private $ticketModel;
    private $usuarioModel;

    public function __construct() {
        $this->piezaModel = new Pieza();
        $this->ticketModel = new Ticket();
        $this->usuarioModel = new Usuario();
    }

    public function mostrarPiezas() {
        $piezas = $this->piezaModel->obtenerTodasLasPiezas();
        include 'views/includes/header.php';
        include 'views/pieza/listar.php';
        include 'views/includes/footer.php';
    }

    public function crearPieza() {
        if ($_SESSION['rol'] != 1) {
            header('Location: index.php?accion=mostrarPiezas');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $stock = $_POST['stock'];
            $precio = $_POST['precio'];
            $imagen = null;

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $target_dir = __DIR__ . '/../uploads/piezas/';
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }
                $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowed_types) && $_FILES["imagen"]["size"] < 5000000) { // 5MB
                    $target_file = $target_dir . uniqid() . '.' . $imageFileType;
                    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                        $imagen = 'uploads/piezas/' . basename($target_file);
                    } else {
                        $_SESSION['error'] = 'Error al subir la imagen.';
                    }
                } else {
                    $_SESSION['error'] = 'Tipo de archivo no permitido o archivo demasiado grande.';
                }
            }

            if ($this->piezaModel->crearPieza($nombre, $descripcion, $stock, $precio, $imagen)) {
                $_SESSION['success'] = 'Pieza creada exitosamente.';
            } else {
                $_SESSION['error'] = 'Error al crear la pieza.';
            }
            header('Location: index.php?accion=mostrarPiezas');
        } else {
            include 'views/includes/header.php';
            include 'views/pieza/crear.php';
            include 'views/includes/footer.php';
        }
    }

    public function verTicketConPiezas() {
        $id_tecnico = $_SESSION['id_usuario'];
        $tickets = $this->ticketModel->obtenerTicketsPorTecnico($id_tecnico);
        $piezas_usadas = [];

        foreach ($tickets as $ticket) {
            $piezas_usadas[$ticket['id_ticket']] = $this->piezaModel->obtenerPiezasUsadasEnTicket($ticket['id_ticket']);
        }

        include 'views/includes/header.php';
        include 'views/pieza/ver_tickets.php';
        include 'views/includes/footer.php';
    }

    public function asignarPieza() {
        $id_ticket = $_GET['id_ticket'] ?? null;
        if (!$id_ticket) {
            header('Location: index.php?accion=verTicketConPiezas');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_repuesto = $_POST['id_repuesto'];
            $cantidad = $_POST['cantidad'];

            // Verificar si ya existe
            $existe = $this->piezaModel->verificarPiezaEnTicket($id_ticket, $id_repuesto);
            if ($existe) {
                // Actualizar cantidad
                $this->piezaModel->actualizarCantidadPiezaEnTicket($id_ticket, $id_repuesto, $cantidad);
            } else {
                // Insertar nueva
                $this->piezaModel->asignarPiezaATicket($id_ticket, $id_repuesto, $cantidad);
            }
            $_SESSION['success'] = 'Pieza asignada exitosamente.';
            header('Location: index.php?accion=verTicketConPiezas');
        } else {
            $piezas = $this->piezaModel->obtenerTodasLasPiezas();
            include 'views/includes/header.php';
            include 'views/pieza/asignar_pieza.php';
            include 'views/includes/footer.php';
        }
    }

    public function editarPieza() {
        if ($_SESSION['rol'] != 1) {
            header('Location: index.php?accion=mostrarPiezas');
            exit;
        }
        $id_pieza = $_GET['id'] ?? null;
        if (!$id_pieza) {
            header('Location: index.php?accion=mostrarPiezas');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $stock = $_POST['stock'];
            $precio = $_POST['precio'];
            $imagen = $_POST['imagen_actual']; // Mantener actual si no se cambia

            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
                $target_dir = __DIR__ . '/../uploads/piezas/';
                $imageFileType = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
                $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
                if (in_array($imageFileType, $allowed_types) && $_FILES["imagen"]["size"] < 5000000) {
                    $target_file = $target_dir . uniqid() . '.' . $imageFileType;
                    if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $target_file)) {
                        $imagen = 'uploads/piezas/' . basename($target_file);
                    } else {
                        $_SESSION['error'] = 'Error al subir la imagen.';
                    }
                } else {
                    $_SESSION['error'] = 'Tipo de archivo no permitido o archivo demasiado grande.';
                }
            }

            if ($this->piezaModel->actualizarPieza($id_pieza, $nombre, $descripcion, $stock, $precio, $imagen)) {
                $_SESSION['success'] = 'Pieza actualizada exitosamente.';
            } else {
                $_SESSION['error'] = 'Error al actualizar la pieza.';
            }
            header('Location: index.php?accion=mostrarPiezas');
        } else {
            $pieza = $this->piezaModel->obtenerPiezaPorId($id_pieza);
            include 'views/includes/header.php';
            include 'views/pieza/editar.php';
            include 'views/includes/footer.php';
        }
    }

    public function eliminarPieza() {
        if ($_SESSION['rol'] != 1) {
            header('Location: index.php?accion=mostrarPiezas');
            exit;
        }
        $id_pieza = $_GET['id'] ?? null;
        if ($id_pieza && $this->piezaModel->eliminarPieza($id_pieza)) {
            $_SESSION['success'] = 'Pieza eliminada exitosamente.';
        } else {
            $_SESSION['error'] = 'Error al eliminar la pieza.';
        }
        header('Location: index.php?accion=mostrarPiezas');
    }

    public function desasignarPieza() {
        $id_ticket = $_GET['id_ticket'] ?? null;
        $id_repuesto = $_GET['id_repuesto'] ?? null;
        if ($id_ticket && $id_repuesto) {
            if ($this->piezaModel->desasignarPiezaDeTicket($id_ticket, $id_repuesto)) {
                $_SESSION['success'] = 'Pieza desasignada exitosamente.';
            } else {
                $_SESSION['error'] = 'Error al desasignar la pieza.';
            }
        }
        header('Location: index.php?accion=verTicketConPiezas');
    }
}
