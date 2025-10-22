<?php
require_once __DIR__ . '/../config/conexion.php';

class Ticket {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function obtenerTicketsPorTecnico($id_tecnico) {
        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    p.tipo_producto, p.marca, p.modelo,
                    u.nombre_usuario AS nombre_cliente,
                    e.nombre_estado, e.id_estado
                FROM Tickets t
                JOIN Productos p ON t.id_producto = p.id_producto
                JOIN Usuarios u ON t.id_cliente = u.id_usuario
                JOIN Estados e ON t.id_estado = e.id_estado
                WHERE t.id_tecnico_asignado = ?
                ORDER BY t.fecha_ingreso DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_tecnico);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $tickets = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tickets[] = $fila;
        }
        return $tickets;
    }

  
    public function obtenerTodosLosEstados() {
        $sql = "SELECT id_estado, nombre_estado FROM Estados ORDER BY id_estado";
        $resultado = $this->db->query($sql);
        $estados = [];
        while ($fila = $resultado->fetch_assoc()) {
            $estados[] = $fila;
        }
        return $estados;
    }

    
    public function actualizarEstadoTicket($id_ticket, $id_estado) {
        $sql = "UPDATE Tickets SET id_estado = ? WHERE id_ticket = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_estado, $id_ticket);
        return $stmt->execute();
    }

    public function obtenerTodosLosTickets() {
        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    p.tipo_producto, p.marca,
                    cliente.nombre_usuario AS nombre_cliente,
                    tecnico.nombre_usuario AS nombre_tecnico,
                    tecnico.id_usuario AS id_tecnico_asignado,
                    e.nombre_estado
                FROM Tickets t
                JOIN Productos p ON t.id_producto = p.id_producto
                JOIN Usuarios cliente ON t.id_cliente = cliente.id_usuario
                JOIN Estados e ON t.id_estado = e.id_estado
                LEFT JOIN Usuarios tecnico ON t.id_tecnico_asignado = tecnico.id_usuario
                ORDER BY t.fecha_ingreso DESC";
        
        $resultado = $this->db->query($sql);
        $tickets = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tickets[] = $fila;
        }
        return $tickets;
    }

    
    public function asignarTecnicoTicket($id_ticket, $id_tecnico) {
        
        if (empty($id_tecnico)) {
            $id_tecnico = null;
        }
        
        $sql = "UPDATE Tickets SET id_tecnico_asignado = ? WHERE id_ticket = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_tecnico, $id_ticket);
        return $stmt->execute();
    }

    public function obtenerInfoSimpleTicket($id_ticket) {
        $stmt = $this->db->prepare("SELECT t.*, e.nombre_estado FROM Tickets t JOIN Estados e ON t.id_estado = e.id_estado WHERE t.id_ticket = ?");
        $stmt->bind_param("i", $id_ticket);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function obtenerNombreEstadoPorId($id_estado) {
        $stmt = $this->db->prepare("SELECT nombre_estado FROM Estados WHERE id_estado = ?");
        $stmt->bind_param("i", $id_estado);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['nombre_estado'] ?? 'Desconocido';
    }
}
?>