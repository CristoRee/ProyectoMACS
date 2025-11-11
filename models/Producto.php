<?php
require_once __DIR__ . '/../config/conexion.php';

class Producto {
    private $db;
    const ID_ESTADO_FINALIZADO = 7;

    public function __construct() {
        $this->db = conectar();
    }

    public function crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos) {
        $this->db->begin_transaction();
        try {
            $sqlProducto = "INSERT INTO Productos (tipo_producto, marca, modelo, id_cliente) VALUES (?, ?, ?, ?)";
            $stmtProducto = $this->db->prepare($sqlProducto);
            if ($stmtProducto === false) throw new Exception("Error al preparar Producto: " . $this->db->error);
            $stmtProducto->bind_param("sssi", $datosProducto['tipo_producto'], $datosProducto['marca'], $datosProducto['modelo'], $datosProducto['id_cliente']);
            $stmtProducto->execute();
            $id_producto = $this->db->insert_id;
            if ($id_producto === 0) throw new Exception("Fallo al insertar Producto: " . $stmtProducto->error);

            $sqlTicket = "INSERT INTO Tickets (descripcion_problema, id_cliente, id_producto, id_estado) VALUES (?, ?, ?, ?)";
            $stmtTicket = $this->db->prepare($sqlTicket);
            if ($stmtTicket === false) throw new Exception("Error al preparar Ticket: " . $this->db->error);
            $estado_inicial = 1; 
            $stmtTicket->bind_param("siii", $datosTicket['descripcion_problema'], $datosTicket['id_cliente'], $id_producto, $estado_inicial);
            $stmtTicket->execute();
            $id_ticket = $this->db->insert_id;
            if ($id_ticket === 0) throw new Exception("Fallo al insertar Ticket: " . $stmtTicket->error);

            if (!empty($rutasFotos)) {
                $sqlFoto = "INSERT INTO Fotos_Ticket (url_imagen, id_ticket) VALUES (?, ?)";
                $stmtFoto = $this->db->prepare($sqlFoto);
                if ($stmtFoto === false) throw new Exception("Error al preparar Foto: " . $this->db->error);
                foreach ($rutasFotos as $ruta) {
                    $stmtFoto->bind_param("si", $ruta, $id_ticket);
                    $stmtFoto->execute();
                }
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Error en transacción crearSolicitudCompleta: " . $e->getMessage());
            return false;
        }
    }

    /**
     * MODIFICADO: Añadido p.modelo (ya lo tenías) y GROUP_CONCAT para fotos
     */
    public function listarPorCliente($idCliente, $vista = 'activos') {
        $id_estado_finalizado = self::ID_ESTADO_FINALIZADO;
        $sql = "SELECT 
                    t.id_ticket, t.descripcion_problema, t.fecha_ingreso,
                    t.id_tecnico_asignado, p.tipo_producto, p.marca, p.modelo,
                    e.nombre_estado, e.color AS estado_color,
                    tec.nombre_usuario AS nombre_tecnico,
                    GROUP_CONCAT(ft.url_imagen) AS fotos
                FROM Tickets as t
                JOIN Productos as p ON t.id_producto = p.id_producto
                JOIN Estados as e ON t.id_estado = e.id_estado
                LEFT JOIN Usuarios tec ON t.id_tecnico_asignado = tec.id_usuario
                LEFT JOIN Fotos_Ticket ft ON t.id_ticket = ft.id_ticket
                WHERE t.id_cliente = ?";

        if ($vista === 'activos') {
            $sql .= " AND t.id_estado != ?";
        } else {
            $sql .= " AND t.id_estado = ?";
        }
        
        $sql .= " GROUP BY t.id_ticket ORDER BY t.fecha_ingreso DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ii", $idCliente, $id_estado_finalizado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminarSolicitud($id_ticket, $id_cliente) {
        $sql = "DELETE FROM Tickets WHERE id_ticket = ? AND id_cliente = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            error_log("Error al preparar la consulta de eliminación: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("ii", $id_ticket, $id_cliente);
        return $stmt->execute();
    }
}
?>