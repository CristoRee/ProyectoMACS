<?php
class Rol {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function listar() {
        $query = "SELECT * FROM Roles";
        $resultado = $this->db->query($query);
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

 public function crear($nombre_rol) {
        $stmt = $this->db->prepare("INSERT INTO Roles (nombre_rol) VALUES (?)");
        $stmt->bind_param("s", $nombre_rol);
        return $stmt->execute();
    }

    public function obtenerPorId($id_rol) {
        $stmt = $this->db->prepare("SELECT * FROM Roles WHERE id_rol = ?");
        $stmt->bind_param("i", $id_rol);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function actualizar($id_rol, $nombre_rol) {
        $stmt = $this->db->prepare("UPDATE Roles SET nombre_rol = ? WHERE id_rol = ?");
        $stmt->bind_param("si", $nombre_rol, $id_rol);
        return $stmt->execute();
    }
    public function eliminar($id_rol) {
        $stmt = $this->db->prepare("DELETE FROM Roles WHERE id_rol = ?");
        $stmt->bind_param("i", $id_rol);
        return $stmt->execute();
    }
}
?>

