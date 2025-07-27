<?php
require_once __DIR__ . '/../config/conexion.php';

class Producto {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    // ... (tu función crearSolicitudCompleta que ya funciona) ...
    public function crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos) {
        // ...
    }

    // ===== FUNCIÓN NUEVA =====
    /**
     * Obtiene todos los tickets de un cliente específico desde la base de datos.
     *
     * @param int $idCliente El ID del cliente logueado.
     * @return array Un array con todas las solicitudes del cliente.
     */
    public function listarPorCliente($idCliente) {
        // Preparamos una consulta que une la información de Tickets, Productos y Estados.
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
        
        // Devolvemos todos los resultados como un array asociativo.
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
