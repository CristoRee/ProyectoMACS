<?php
require_once __DIR__ . '/../config/conexion.php';

class Estado {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function getAll() {
        $resultado = $this->db->query("SELECT * FROM Estados ORDER BY id_estado");
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

   
    public function getById($id_estado) {
        $stmt = $this->db->prepare("SELECT * FROM Estados WHERE id_estado = ?");
        $stmt->bind_param("i", $id_estado);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function create($nombre_estado) {
        $stmt = $this->db->prepare("INSERT INTO Estados (nombre_estado) VALUES (?)");
        if ($stmt === false) {
            error_log("Error al preparar la consulta de Estado: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("s", $nombre_estado);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) { 
                return "duplicado";
            }
            return false;
        }
        return true;
    }
    
    public function update($id_estado, $nombre_estado, $color) {
        $stmt = $this->db->prepare("UPDATE Estados SET nombre_estado = ?, color = ? WHERE id_estado = ?");
        $stmt->bind_param("ssi", $nombre_estado, $color, $id_estado);
        return $stmt->execute();
    }
    
    public function delete($id_estado) {
        $stmt = $this->db->prepare("DELETE FROM Estados WHERE id_estado = ?");
        $stmt->bind_param("i", $id_estado);
        return $stmt->execute();
    }

   
    public function actualizarNotificaciones($ids_a_notificar) {
       
        $this->db->query("UPDATE Estados SET notificar_cliente = 0");

  
        if (!empty($ids_a_notificar)) {
         
            $ids_placeholder = implode(',', array_fill(0, count($ids_a_notificar), '?'));
            $tipos = str_repeat('i', count($ids_a_notificar));
            
            $stmt = $this->db->prepare("UPDATE Estados SET notificar_cliente = 1 WHERE id_estado IN ($ids_placeholder)");
            $stmt->bind_param($tipos, ...$ids_a_notificar);
            $stmt->execute();
        }
        return true;
    }
    
  
    public function debeNotificar($id_estado) {
        $stmt = $this->db->prepare("SELECT notificar_cliente FROM Estados WHERE id_estado = ?");
        $stmt->bind_param("i", $id_estado);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        
        return $resultado ? (bool)$resultado['notificar_cliente'] : false;
    }
    
    public function obtenerNombreEstadoPorId($id_estado) {
        $stmt = $this->db->prepare("SELECT nombre_estado FROM Estados WHERE id_estado = ?");
        $stmt->bind_param("i", $id_estado);
        $stmt->execute();
        $resultado = $stmt->get_result()->fetch_assoc();
        return $resultado['nombre_estado'] ?? 'Desconocido';
    }
}