<?php
require_once __DIR__ . '/../config/conexion.php';

class Ticket {
    private $db;
    
    const ID_ESTADO_FINALIZADO = 7;

    public function __construct() {
        $this->db = conectar();
    }

    public function obtenerTicketsPorTecnico($id_tecnico, $vista = 'activos') {
      
        $id_estado_finalizado = 7;

        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    p.tipo_producto, p.marca, p.modelo,
                    u.nombre_usuario AS nombre_cliente,
                    e.nombre_estado, e.id_estado, e.color as estado_color
                FROM Tickets t
                JOIN Productos p ON t.id_producto = p.id_producto
                JOIN Usuarios u ON t.id_cliente = u.id_usuario
                JOIN Estados e ON t.id_estado = e.id_estado
                WHERE t.id_tecnico_asignado = ?";
        
        if ($vista === 'activos') {
            $sql .= " AND t.id_estado != ?";
        } else { 
            $sql .= " AND t.id_estado = ?";
        }
        
        $sql .= " ORDER BY t.fecha_ingreso DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_tecnico, $id_estado_finalizado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $tickets = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tickets[] = $fila;
        }
        return $tickets;
    }

    /**
     * Obtener tickets por técnico con paginación
     */
    public function obtenerTicketsPorTecnicoConPaginacion($id_tecnico, $vista = 'activos', $page = 1, $perPage = 15) {
        $offset = ($page - 1) * $perPage;
        $id_estado_finalizado = 7;

        // Consulta para obtener tickets paginados
        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    p.tipo_producto, p.marca, p.modelo,
                    u.nombre_usuario AS nombre_cliente,
                    e.nombre_estado, e.id_estado, e.color as estado_color
                FROM Tickets t
                JOIN Productos p ON t.id_producto = p.id_producto
                JOIN Usuarios u ON t.id_cliente = u.id_usuario
                JOIN Estados e ON t.id_estado = e.id_estado
                WHERE t.id_tecnico_asignado = ?";
        
        if ($vista === 'activos') {
            $sql .= " AND t.id_estado != ?";
        } else { 
            $sql .= " AND t.id_estado = ?";
        }
        
        $sql .= " ORDER BY t.fecha_ingreso DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiii", $id_tecnico, $id_estado_finalizado, $perPage, $offset);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $tickets = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tickets[] = $fila;
        }
        
        // Consulta para obtener total de tickets
        $sqlCount = "SELECT COUNT(*) as total
                    FROM Tickets t
                    JOIN Productos p ON t.id_producto = p.id_producto
                    JOIN Usuarios u ON t.id_cliente = u.id_usuario
                    JOIN Estados e ON t.id_estado = e.id_estado
                    WHERE t.id_tecnico_asignado = ?";
        
        if ($vista === 'activos') {
            $sqlCount .= " AND t.id_estado != ?";
        } else { 
            $sqlCount .= " AND t.id_estado = ?";
        }

        $stmtCount = $this->db->prepare($sqlCount);
        $stmtCount->bind_param("ii", $id_tecnico, $id_estado_finalizado);
        $stmtCount->execute();
        $total = $stmtCount->get_result()->fetch_assoc()['total'];
        
        return [
            'tickets' => $tickets,
            'total' => $total,
            'totalPages' => ceil($total / $perPage),
            'currentPage' => $page,
            'perPage' => $perPage,
            'startRecord' => $offset + 1,
            'endRecord' => min($offset + $perPage, $total)
        ];
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

   
   public function obtenerTodosLosTickets($vista = 'activos') {
        $id_estado_finalizado = 7;

        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    p.tipo_producto, p.marca,
                    cliente.nombre_usuario AS nombre_cliente,
                    tecnico.nombre_usuario AS nombre_tecnico,
                    tecnico.id_usuario AS id_tecnico_asignado,
                    e.nombre_estado, e.color as estado_color
                FROM Tickets t
                JOIN Productos p ON t.id_producto = p.id_producto
                JOIN Usuarios cliente ON t.id_cliente = cliente.id_usuario
                JOIN Estados e ON t.id_estado = e.id_estado
                LEFT JOIN Usuarios tecnico ON t.id_tecnico_asignado = tecnico.id_usuario";

        if ($vista === 'activos') {
            $sql .= " WHERE t.id_estado != ?";
        } else { 
            $sql .= " WHERE t.id_estado = ?";
        }

        $sql .= " ORDER BY t.fecha_ingreso DESC";
        
        $stmt = $this->db->prepare($sql);
        
        $stmt->bind_param("i", $id_estado_finalizado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $tickets = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tickets[] = $fila;
        }
        return $tickets;
    }

    /**
     * Obtener todos los tickets con paginación
     */
    public function obtenerTodosLosTicketsConPaginacion($vista = 'activos', $page = 1, $perPage = 10) {
        $offset = ($page - 1) * $perPage;
        $id_estado_finalizado = 7;

        // Consulta para obtener tickets paginados
        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    p.tipo_producto, p.marca,
                    cliente.nombre_usuario AS nombre_cliente,
                    tecnico.nombre_usuario AS nombre_tecnico,
                    tecnico.id_usuario AS id_tecnico_asignado,
                    e.nombre_estado, e.color as estado_color
                FROM Tickets t
                JOIN Productos p ON t.id_producto = p.id_producto
                JOIN Usuarios cliente ON t.id_cliente = cliente.id_usuario
                JOIN Estados e ON t.id_estado = e.id_estado
                LEFT JOIN Usuarios tecnico ON t.id_tecnico_asignado = tecnico.id_usuario";

        if ($vista === 'activos') {
            $sql .= " WHERE t.id_estado != ?";
        } else { 
            $sql .= " WHERE t.id_estado = ?";
        }

        $sql .= " ORDER BY t.fecha_ingreso DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $id_estado_finalizado, $perPage, $offset);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $tickets = [];
        while ($fila = $resultado->fetch_assoc()) {
            $tickets[] = $fila;
        }
        
        // Consulta para obtener total de tickets
        $sqlCount = "SELECT COUNT(*) as total
                    FROM Tickets t
                    JOIN Productos p ON t.id_producto = p.id_producto
                    JOIN Usuarios cliente ON t.id_cliente = cliente.id_usuario
                    JOIN Estados e ON t.id_estado = e.id_estado
                    LEFT JOIN Usuarios tecnico ON t.id_tecnico_asignado = tecnico.id_usuario";

        if ($vista === 'activos') {
            $sqlCount .= " WHERE t.id_estado != ?";
        } else { 
            $sqlCount .= " WHERE t.id_estado = ?";
        }

        $stmtCount = $this->db->prepare($sqlCount);
        $stmtCount->bind_param("i", $id_estado_finalizado);
        $stmtCount->execute();
        $total = $stmtCount->get_result()->fetch_assoc()['total'];
        
        return [
            'tickets' => $tickets,
            'total' => $total,
            'totalPages' => ceil($total / $perPage),
            'currentPage' => $page,
            'perPage' => $perPage,
            'startRecord' => $offset + 1,
            'endRecord' => min($offset + $perPage, $total)
        ];
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

    public function obtenerInfoParaEmail($id_ticket) {
        $sql = "SELECT t.id_ticket, u.nombre_usuario, u.email 
                FROM Tickets t 
                JOIN Usuarios u ON t.id_cliente = u.id_usuario 
                WHERE t.id_ticket = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_ticket);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>