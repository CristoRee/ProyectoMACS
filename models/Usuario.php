<?php
class Usuario {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }

    public function verificar($usuario, $password) {
        $usuario = $this->db->real_escape_string($usuario);
        $sql = "SELECT * FROM usuarios WHERE nombre_usuario='$usuario' LIMIT 1";
        $res = $this->db->query($sql);
        if ($row = $res->fetch_assoc()) {
            if ($row['password_hash'] === $password) {
                return header("Location: views/inicio.php");
            }
        }
        return false;
    }
}