<?php
class Usuario {
    private $db;

    public function __construct() {
        
        $this->db = conectar();
    }

    
    public function crear($nombre, $email, $password_plana) {
        
        $hash_seguro = password_hash($password_plana, PASSWORD_DEFAULT);

        
        $stmt = $this->db->prepare(
            "INSERT INTO Usuarios (nombre_usuario, email, password_hash, id_rol) VALUES (?, ?, ?, ?)"
        );
        
        
        if (!$stmt) {
            return false;
        }

        
        $rol_por_defecto = 3; 

        
        $stmt->bind_param("sssi", $nombre, $email, $hash_seguro, $rol_por_defecto);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    
    public function verificar($nombre_usuario, $password_plana) {
        
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE nombre_usuario = ? LIMIT 1");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

           
            if (password_verify($password_plana, $usuario['password_hash'])) {
               
                return $usuario;
            }
        }
        
      
        return false;
    }
}
