<?php
require_once __DIR__ . '/../config/conexion.php';

class Chat {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }
    
    public function obtenerOCrearConversacion($id_ticket, $tipo = 'TICKET', $id_participante1 = null, $id_participante2 = null) {
        $id_conversacion = null;

        if ($tipo === 'TICKET') {
           
            $stmt = $this->db->prepare("SELECT id_conversacion FROM Conversaciones WHERE id_ticket = ? AND tipo = 'TICKET'");
            $stmt->bind_param("i", $id_ticket);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $id_conversacion = $resultado->fetch_assoc()['id_conversacion'];
            }
            
            if (!$id_conversacion) {
                
                $stmt_insert = $this->db->prepare("INSERT INTO Conversaciones (id_ticket, tipo) VALUES (?, 'TICKET')");
                $stmt_insert->bind_param("i", $id_ticket);
                $stmt_insert->execute();
                $id_conversacion = $this->db->insert_id;
            }

        } elseif ($tipo === 'PRIVADA' && $id_participante1 && $id_participante2) { 
           
            $stmt = $this->db->prepare("SELECT id_conversacion FROM Conversaciones WHERE id_ticket = ? AND tipo = 'PRIVADA' AND ((id_participante1 = ? AND id_participante2 = ?) OR (id_participante1 = ? AND id_participante2 = ?))");
            $stmt->bind_param("iiiii", $id_ticket, $id_participante1, $id_participante2, $id_participante2, $id_participante1);
            $stmt->execute();
            $resultado = $stmt->get_result();
            if ($resultado->num_rows > 0) {
                $id_conversacion = $resultado->fetch_assoc()['id_conversacion'];
            }

            if (!$id_conversacion) {
            
                $stmt_insert = $this->db->prepare("INSERT INTO Conversaciones (id_ticket, tipo, id_participante1, id_participante2) VALUES (?, 'PRIVADA', ?, ?)");
                $stmt_insert->bind_param("iii", $id_ticket, $id_participante1, $id_participante2);
                $stmt_insert->execute();
                $id_conversacion = $this->db->insert_id;
            }
        }
        
        return $id_conversacion;
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
        $queries = [];
        $params = [];
        $types = "";

      
        if ($rol_usuario === 'Cliente' || $rol_usuario === 'Técnico') {
            $queries[] = "(SELECT DISTINCT c.id_ticket, 
                                     (CASE WHEN t.id_cliente = ? THEN tec.nombre_usuario ELSE cli.nombre_usuario END) AS otro_participante,
                                     'ticket' AS target
                          FROM Conversaciones c
                          JOIN Tickets t ON c.id_ticket = t.id_ticket
                          JOIN Usuarios cli ON t.id_cliente = cli.id_usuario
                          LEFT JOIN Usuarios tec ON t.id_tecnico_asignado = tec.id_usuario
                          WHERE c.tipo = 'TICKET' AND (t.id_cliente = ? OR t.id_tecnico_asignado = ?))";
            $params = array_merge($params, [$id_usuario, $id_usuario, $id_usuario]);
            $types .= "iii";
        }


        if ($rol_usuario === 'Técnico' || $rol_usuario === 'Administrador') {
           
            $queries[] = "(SELECT t.id_ticket, 
                                  otro_usuario.nombre_usuario AS otro_participante, 
                                  'tecnico' as target
                           FROM Conversaciones c
                           JOIN Tickets t ON c.id_ticket = t.id_ticket
                           JOIN Usuarios otro_usuario ON otro_usuario.id_usuario = IF(c.id_participante1 = ?, c.id_participante2, c.id_participante1)
                           WHERE c.tipo = 'PRIVADA' AND (c.id_participante1 = ? OR c.id_participante2 = ?))";
            
            $params = array_merge($params, [$id_usuario, $id_usuario, $id_usuario]);
            $types .= "iii";
        }

        if (empty($queries)) {
            return []; 
        }

        $sql = implode(" UNION ", $queries);
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>