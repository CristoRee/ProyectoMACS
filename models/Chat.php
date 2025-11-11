<?php
require_once __DIR__ . '/../config/conexion.php';

class Chat {
    private $db;
    const ID_ROL_ADMIN = 1;

    public function __construct() {
        $this->db = conectar();
    }

    public function obtenerOCrearConversacion($id_ticket, $tipo = 'TICKET', $id_participante1 = null, $id_participante2 = null) {
        $sql_select = "";
        $params_select = [];
        $types_select = "";

        if ($tipo === 'TICKET') {
            $sql_select = "SELECT id_conversacion FROM Conversaciones WHERE id_ticket = ? AND tipo = 'TICKET'";
            $types_select = "i";
            $params_select[] = $id_ticket;
        } else {
            $sql_select = "SELECT id_conversacion FROM Conversaciones WHERE id_ticket = ? AND tipo = 'PRIVADA' AND ((id_participante1 = ? AND id_participante2 = ?) OR (id_participante1 = ? AND id_participante2 = ?))";
            $types_select = "iiiii";
            $params_select = [$id_ticket, $id_participante1, $id_participante2, $id_participante2, $id_participante1];
        }

        $stmt = $this->db->prepare($sql_select);
        $stmt->bind_param($types_select, ...$params_select);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_assoc()['id_conversacion'];
        } else {
            if ($tipo === 'TICKET') {
                $stmt_insert = $this->db->prepare("INSERT INTO Conversaciones (id_ticket, tipo) VALUES (?, 'TICKET')");
                $stmt_insert->bind_param("i", $id_ticket);
            } else {
                $stmt_insert = $this->db->prepare("INSERT INTO Conversaciones (id_ticket, tipo, id_participante1, id_participante2) VALUES (?, 'PRIVADA', ?, ?)");
                $stmt_insert->bind_param("iii", $id_ticket, $id_participante1, $id_participante2);
            }
            if ($stmt_insert->execute()) {
                return $this->db->insert_id;
            }
        }
        return false;
    }

    public function obtenerMensajes($id_conversacion) {
        $sql = "SELECT m.id_mensaje, m.contenido, m.fecha_envio, m.leido, u.id_usuario AS id_emisor, u.nombre_usuario AS emisor, r.nombre_rol
                FROM Mensajes m
                JOIN Usuarios u ON m.id_emisor = u.id_usuario
                JOIN Roles r ON u.id_rol = r.id_rol
                WHERE m.id_conversacion = ? ORDER BY m.fecha_envio ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_conversacion);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function enviarMensaje($id_conversacion, $id_emisor, $id_receptor, $contenido) {
        $sql = "INSERT INTO Mensajes (id_conversacion, id_emisor, id_receptor, contenido) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiis", $id_conversacion, $id_emisor, $id_receptor, $contenido);
        return $stmt->execute();
    }
    
    public function obtenerInfoTicketParaChat($id_ticket) {
        $sql = "SELECT t.id_cliente, t.id_tecnico_asignado, c.nombre_usuario AS nombre_cliente, p.tipo_producto, p.marca, tecnico.nombre_usuario AS nombre_tecnico
                FROM Tickets t
                JOIN Usuarios c ON t.id_cliente = c.id_usuario
                JOIN Productos p ON t.id_producto = p.id_producto
                LEFT JOIN Usuarios tecnico ON t.id_tecnico_asignado = tecnico.id_usuario
                WHERE t.id_ticket = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_ticket);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function obtenerConversacionesActivas($id_usuario_actual, $id_rol_actual) {
        $sql = "
            ( -- Chats de TICKET
                SELECT
                    c.id_ticket, c.tipo AS tipo_chat,
                    IF( ? = 3, IFNULL(tec.nombre_usuario, 'Técnico no asignado'), cli.nombre_usuario) AS otro_participante
                FROM Conversaciones c
                JOIN Tickets t ON c.id_ticket = t.id_ticket
                JOIN Usuarios cli ON t.id_cliente = cli.id_usuario
                LEFT JOIN Usuarios tec ON t.id_tecnico_asignado = tec.id_usuario
                WHERE c.tipo = 'TICKET' AND (t.id_cliente = ? OR t.id_tecnico_asignado = ? OR ? = self::ID_ROL_ADMIN)
            )
            UNION
            ( -- Chats PRIVADOS
                SELECT
                    c.id_ticket, c.tipo AS tipo_chat,
                    IF(c.id_participante1 = ?, u2.nombre_usuario, u1.nombre_usuario) AS otro_participante
                FROM Conversaciones c
                JOIN Tickets t ON c.id_ticket = t.id_ticket
                JOIN Usuarios u1 ON c.id_participante1 = u1.id_usuario
                JOIN Usuarios u2 ON c.id_participante2 = u2.id_usuario
                WHERE c.tipo = 'PRIVADA' AND (c.id_participante1 = ? OR c.id_participante2 = ?)
            )
            ORDER BY id_ticket DESC, tipo_chat ASC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiiiiii", $id_rol_actual, $id_usuario_actual, $id_usuario_actual, $id_rol_actual, $id_usuario_actual, $id_usuario_actual, $id_usuario_actual);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function marcarComoLeido($id_conversacion, $id_receptor) {
        $sql = "UPDATE Mensajes SET leido = TRUE WHERE id_conversacion = ? AND id_receptor = ? AND leido = FALSE";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $id_conversacion, $id_receptor);
        return $stmt->execute();
    }

    public function contarNuevosMensajes($id_receptor) {
        $stmt = $this->db->prepare("SELECT COUNT(id_mensaje) AS total FROM Mensajes WHERE id_receptor = ? AND leido = FALSE");
        $stmt->bind_param("i", $id_receptor);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['total'] ?? 0;
    }
}
?>