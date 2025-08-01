<?php
require_once __DIR__ . '/../config/conexion.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos) {
        $this->db->begin_transaction();

        try {
            // Paso 1: Insertar en la tabla Productos
            $sqlProducto = "INSERT INTO Productos (tipo_producto, marca, modelo, id_cliente) VALUES (?, ?, ?, ?)";
            $stmtProducto = $this->db->prepare($sqlProducto);
            if ($stmtProducto === false) {
                throw new Exception("Error al preparar la consulta de Producto: " . $this->db->error);
            }
            $stmtProducto->bind_param(
                "sssi",
                $datosProducto['tipo_producto'],
                $datosProducto['marca'],
                $datosProducto['modelo'],
                $datosProducto['id_cliente']
            );
            $stmtProducto->execute();
            $id_producto = $this->db->insert_id;

            if ($id_producto === 0) {
                throw new Exception("Fallo al ejecutar la inserción en Productos: " . $stmtProducto->error);
            }

            // Paso 2: Insertar en la tabla Tickets
            $sqlTicket = "INSERT INTO Tickets (descripcion_problema, id_cliente, id_producto, id_estado) VALUES (?, ?, ?, ?)";
            $stmtTicket = $this->db->prepare($sqlTicket);
            if ($stmtTicket === false) {
                throw new Exception("Error al preparar la consulta de Ticket: " . $this->db->error);
            }
            $estado_inicial = 1;
            $stmtTicket->bind_param(
                "siii",
                $datosTicket['descripcion_problema'],
                $datosTicket['id_cliente'],
                $id_producto,
                $estado_inicial
            );
            $stmtTicket->execute();
            $id_ticket = $this->db->insert_id;

            if ($id_ticket === 0) {
                throw new Exception("Fallo al ejecutar la inserción en Tickets: " . $stmtTicket->error);
            }

            // Paso 3: Insertar en la tabla Fotos_Ticket
            if (!empty($rutasFotos)) {
                $sqlFoto = "INSERT INTO Fotos_Ticket (url_imagen, id_ticket) VALUES (?, ?)";
                $stmtFoto = $this->db->prepare($sqlFoto);
                if ($stmtFoto === false) {
                    throw new Exception("Error al preparar la consulta de Foto: " . $this->db->error);
                }
                foreach ($rutasFotos as $ruta) {
                    $stmtFoto->bind_param("si", $ruta, $id_ticket);
                    $stmtFoto->execute();
                }
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollback();
            // --- CAMBIO IMPORTANTE PARA DEPURACIÓN ---
            // Registramos el error específico en el log de errores de PHP.
            error_log("Error en transacción crearSolicitudCompleta: " . $e->getMessage());
            return false;
        }
    }
    
    public function listarPorCliente($idCliente) {
        $sql = "SELECT 
                    t.id_ticket,
                    t.descripcion_problema,
                    t.fecha_ingreso,
                    p.tipo_producto,
                    p.marca,
                    p.modelo,
                    e.nombre_estado
                FROM Tickets as t
                JOIN Productos as p ON t.id_producto = p.id_producto
                JOIN Estados as e ON t.id_estado = e.id_estado
                WHERE t.id_cliente = ?
                ORDER BY t.fecha_ingreso DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $idCliente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
