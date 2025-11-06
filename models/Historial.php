<?php
require_once __DIR__ . '/../config/conexion.php';

class Historial {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }


    public function listar($id_ticket_filtro = null) {
        $sql = "SELECT h.fecha, h.accion, u.nombre_usuario, h.id_ticket
                FROM Historial h
                LEFT JOIN Usuarios u ON h.id_usuario = u.id_usuario";
        
        if ($id_ticket_filtro) {
            $sql .= " WHERE h.id_ticket = ?";
        }
        
        $sql .= " ORDER BY h.fecha DESC";

        $stmt = $this->db->prepare($sql);

        if ($id_ticket_filtro) {
            $stmt->bind_param("i", $id_ticket_filtro);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Listar historial con paginación
     */
    public function listarConPaginacion($id_ticket_filtro = null, $page = 1, $perPage = 30) {
        $offset = ($page - 1) * $perPage;
        
        // Consulta para obtener historial paginado
        $sql = "SELECT h.fecha, h.accion, u.nombre_usuario, h.id_ticket
                FROM Historial h
                LEFT JOIN Usuarios u ON h.id_usuario = u.id_usuario";
        
        if ($id_ticket_filtro) {
            $sql .= " WHERE h.id_ticket = ?";
        }
        
        $sql .= " ORDER BY h.fecha DESC LIMIT ? OFFSET ?";

        $stmt = $this->db->prepare($sql);

        if ($id_ticket_filtro) {
            $stmt->bind_param("iii", $id_ticket_filtro, $perPage, $offset);
        } else {
            $stmt->bind_param("ii", $perPage, $offset);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        $historial = $resultado->fetch_all(MYSQLI_ASSOC);
        
        // Consulta para obtener total de registros
        $sqlCount = "SELECT COUNT(*) as total FROM Historial h LEFT JOIN Usuarios u ON h.id_usuario = u.id_usuario";
        
        if ($id_ticket_filtro) {
            $sqlCount .= " WHERE h.id_ticket = ?";
        }

        $stmtCount = $this->db->prepare($sqlCount);

        if ($id_ticket_filtro) {
            $stmtCount->bind_param("i", $id_ticket_filtro);
        }

        $stmtCount->execute(); 
        $total = $stmtCount->get_result()->fetch_assoc()['total'];
        
        return [
            'historial' => $historial,
            'total' => $total,
            'totalPages' => ceil($total / $perPage),
            'currentPage' => $page,
            'perPage' => $perPage,
            'startRecord' => $offset + 1,
            'endRecord' => min($offset + $perPage, $total)
        ];
    }
}
?>