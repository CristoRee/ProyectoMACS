<?php
require_once __DIR__ . '/../config/conexion.php';

class Estado {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }


    public function getAll() {
        $sql = "SELECT * FROM Estados ORDER BY id_estado ASC";
        $stmt = $this->db->query($sql);
        return $stmt;
    }


    public function getById($id_estado) {
        $sql = "SELECT * FROM Estados WHERE id_estado = :id_estado";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_estado', $id_estado, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    
    public function create($nombre_estado) {
        $sql = "INSERT INTO Estados (nombre_estado) VALUES (?)";
        $stmt = $this->db->prepare($sql);
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

    
    public function update($id_estado, $nombre_estado) {
        $sql = "UPDATE Estados SET nombre_estado = ? WHERE id_estado = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            error_log("Error al preparar la consulta de Estado: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("si", $nombre_estado, $id_estado);
        return $stmt->execute();
    }

    
    public function delete($id_estado) {
        $sql = "DELETE FROM Estados WHERE id_estado = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            error_log("Error al preparar la consulta de Estado: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("i", $id_estado);
        return $stmt->execute();
    }
}