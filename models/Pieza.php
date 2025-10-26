<?php
require_once __DIR__ . '/../config/conexion.php';

/**
 * Pieza - Modelo para gestión de inventario de hardware
 * Gestiona componentes de hardware, repuestos y accesorios
 * utilizados en reparaciones de dispositivos electrónicos.
 */
class Pieza {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function obtenerTodasLasPiezas() {
        $sql = "SELECT * FROM Repuestos ORDER BY nombre";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPiezaPorId($id_pieza) {
        $sql = "SELECT * FROM Repuestos WHERE id_repuesto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pieza);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function crearPieza($nombre, $descripcion, $stock, $precio, $imagen = null) {
        $sql = "INSERT INTO Repuestos (nombre, descripcion, stock, precio" . ($imagen ? ", imagen" : "") . ") VALUES (?, ?, ?, ?" . ($imagen ? ", ?" : "") . ")";
        $stmt = $this->db->prepare($sql);
        if ($imagen) {
            $stmt->bind_param("ssids", $nombre, $descripcion, $stock, $precio, $imagen);
        } else {
            $stmt->bind_param("ssid", $nombre, $descripcion, $stock, $precio);
        }
        return $stmt->execute();
    }

    public function actualizarPieza($id_pieza, $nombre, $descripcion, $stock, $precio, $imagen = null) {
        $sql = "UPDATE Repuestos SET nombre = ?, descripcion = ?, stock = ?, precio = ?" . ($imagen ? ", imagen = ?" : "") . " WHERE id_repuesto = ?";
        $stmt = $this->db->prepare($sql);
        if ($imagen) {
            $stmt->bind_param("ssidsi", $nombre, $descripcion, $stock, $precio, $imagen, $id_pieza);
        } else {
            $stmt->bind_param("ssidi", $nombre, $descripcion, $stock, $precio, $id_pieza);
        }
        return $stmt->execute();
    }

    public function eliminarPieza($id_pieza) {
        $sql = "DELETE FROM Repuestos WHERE id_repuesto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_pieza);
        return $stmt->execute();
    }

    public function obtenerPiezasUsadasEnTicket($id_ticket) {
        $sql = "SELECT r.*, tur.cantidad_usada FROM Repuestos r JOIN Ticket_Usa_Repuesto tur ON r.id_repuesto = tur.id_repuesto WHERE tur.id_ticket = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_ticket);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function verificarPiezaEnTicket($id_ticket, $id_repuesto) {
        $sql = "SELECT COUNT(*) as count FROM Ticket_Usa_Repuesto WHERE id_ticket = ? AND id_repuesto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_ticket, $id_repuesto);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'] > 0;
    }

    public function actualizarCantidadPiezaEnTicket($id_ticket, $id_repuesto, $cantidad) {
        $sql = "UPDATE Ticket_Usa_Repuesto SET cantidad_usada = ? WHERE id_ticket = ? AND id_repuesto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $cantidad, $id_ticket, $id_repuesto);
        return $stmt->execute();
    }

    public function asignarPiezaATicket($id_ticket, $id_repuesto, $cantidad) {
        $sql = "INSERT INTO Ticket_Usa_Repuesto (id_ticket, id_repuesto, cantidad_usada) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $id_ticket, $id_repuesto, $cantidad);
        return $stmt->execute();
    }

    public function desasignarPiezaDeTicket($id_ticket, $id_repuesto) {
        $sql = "DELETE FROM Ticket_Usa_Repuesto WHERE id_ticket = ? AND id_repuesto = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_ticket, $id_repuesto);
        return $stmt->execute();
    }
}
