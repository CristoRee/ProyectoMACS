<?php
require_once __DIR__ . '/../config/conexion.php';

class HistorialLogger {

    /**
     * Registra una nueva acción en el historial.
     * @param string $accion La descripción de lo que ocurrió.
     * @param int|null $id_usuario El ID del usuario que realizó la acción.
     * @param int|null $id_ticket El ID del ticket afectado (si lo hay).
     */
    public static function registrar($accion, $id_usuario = null, $id_ticket = null) {
        $db = conectar();
        $sql = "INSERT INTO Historial (id_usuario, id_ticket, accion) VALUES (?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        // Usamos la sesión si el id_usuario no se provee explícitamente
        $usuario_a_registrar = $id_usuario ?? $_SESSION['id_usuario'] ?? null;
        
        $stmt->bind_param("iis", $usuario_a_registrar, $id_ticket, $accion);
        $stmt->execute();
        $stmt->close();
        $db->close();
    }
}
?>