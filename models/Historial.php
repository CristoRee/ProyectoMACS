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
}
?>