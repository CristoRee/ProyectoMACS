<?php
require_once __DIR__ . '/../config/conexion.php';

class Chat {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }
    
    public function obtenerOCrearConversacion($id_ticket, $tipo = 'TICKET', $id_participante1 = null, $id_participante2 = null) {
        if ($tipo === 'TICKET') {
            $stmt = $this->db->prepare("SELECT id_conversacion FROM Conversaciones WHERE id_ticket = ? AND tipo = 'TICKET'");
            $stmt->bind_param("i", $id_ticket);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                return $resultado->fetch_assoc()['id_conversacion'];
            }
            
            $stmt_insert = $this->db->prepare("INSERT INTO Conversaciones (id_ticket, tipo) VALUES (?, 'TICKET')");
            $stmt_insert->bind_param("i", $id_ticket);

        } else { 
            $stmt = $this->db->prepare("SELECT id_conversacion FROM Conversaciones WHERE id_ticket = ? AND tipo = 'PRIVADA' AND ((id_participante1 = ? AND id_participante2 = ?) OR (id_participante1 = ? AND id_participante2 = ?))");
            $stmt->bind_param("iiiii", $id_ticket, $id_participante1, $id_participante2, $id_participante2, $id_participante1);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                return $resultado->fetch_assoc()['id_conversacion'];
            }

            $stmt_insert = $this->db->prepare("INSERT INTO Conversaciones (id_ticket, tipo, id_participante1, id_participante2) VALUES (?, 'PRIVADA', ?, ?)");
            $stmt_insert->bind_param("iii", $id_ticket, $id_participante1, $id_participante2);
        }
        
        $stmt_insert->execute();
        return $this->db->insert_id;
    }

    public function obtenerMensajes($id_conversacion) {
        $sql = "SELECT m.contenido, m.fecha_envio, u.id_usuario AS id_emisor, u.nombre_usuario AS emisor, r.nombre_rol
                FROM Mensajes m
                JOIN Usuarios u ON m.id_emisor = u.id_usuario
                JOIN Roles r ON u.id_rol = r.id_rol
                WHERE m.id_conversacion = ?
                ORDER BY m.fecha_envio ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_conversacion);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function enviarMensaje($id_conversacion, $id_emisor, $id_receptor, $contenido) {
        $sql = "INSERT INTO Mensajes (id_conversacion, id_emisor, id_receptor, contenido) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiis", $id_conversacion, $id_emisor, $id_receptor, $contenido);
        return $stmt->execute();
    }
    
    public function obtenerInfoTicketParaChat($id_ticket) {
        $sql = "SELECT t.id_cliente, t.id_tecnico_asignado, c.nombre_usuario AS nombre_cliente, p.tipo_producto, p.marca
                FROM Tickets t
                JOIN Usuarios c ON t.id_cliente = c.id_usuario
                JOIN Productos p ON t.id_producto = p.id_producto
                WHERE t.id_ticket = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_ticket);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function obtenerConversacionesActivas($id_usuario, $rol_usuario) {
        $extra_join_condition = "";
        $other_user_column = "";
        if ($rol_usuario === 'Cliente') {
            $other_user_column = "tecnico.nombre_usuario AS otro_participante";
            $extra_join_condition = "LEFT JOIN Usuarios tecnico ON t.id_tecnico_asignado = tecnico.id_usuario";
        } else { 
            $other_user_column = "cliente.nombre_usuario AS otro_participante";
            $extra_join_condition = "JOIN Usuarios cliente ON t.id_cliente = cliente.id_usuario";
        }

        $sql = "SELECT DISTINCT c.id_ticket, {$other_user_column}
                FROM Conversaciones c
                JOIN Tickets t ON c.id_ticket = t.id_ticket
                {$extra_join_condition}
                WHERE (t.id_cliente = ? OR t.id_tecnico_asignado = ? OR ? = 1) AND c.tipo = 'TICKET'"; 
        
        $admin_rol_id = 1; 
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $id_usuario, $id_usuario, $_SESSION['rol']);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>