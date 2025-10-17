<?php
class Usuario {
    private $db;

    public function __construct() {
       
        $this->db = conectar();
    }

   
    public function crear($nombre, $email, $password_plana) {
       
        $hash_seguro = password_hash($password_plana, PASSWORD_DEFAULT);

     
        // Verificar si el email ya existe para evitar error de duplicado
        $stmt_check = $this->db->prepare("SELECT id_usuario FROM Usuarios WHERE email = ? LIMIT 1");
        if ($stmt_check) {
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $res = $stmt_check->get_result();
            if ($res && $res->num_rows > 0) {
                // Email duplicado
                return 'duplicate';
            }
        }
+
        $stmt = $this->db->prepare(
            "INSERT INTO Usuarios (nombre_usuario, email, password_hash, id_rol) VALUES (?, ?, ?, ?)"
        );

        if (!$stmt) {
            return false;
        }
+
        $rol_por_defecto = 3; 

        $stmt->bind_param("sssi", $nombre, $email, $hash_seguro, $rol_por_defecto);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



     public function actualizar($id, $nombre, $email, $telefono, $id_rol) {
        $stmt = $this->db->prepare(
            "UPDATE Usuarios SET nombre_usuario = ?, email = ?, telefono = ?, id_rol = ? WHERE id_usuario = ?"
        );
        $stmt->bind_param("sssii", $nombre, $email, $telefono, $id_rol, $id);
        return $stmt->execute();
    }

  
    public function eliminar($id) {
        
        $stmt_check = $this->db->prepare("SELECT id_rol FROM Usuarios WHERE id_usuario = ?");
        $stmt_check->bind_param("i", $id);
        $stmt_check->execute();
        $resultado = $stmt_check->get_result()->fetch_assoc();

        if ($resultado && $resultado['id_rol'] == 1) {
            
            return false;
        }

        
        $stmt = $this->db->prepare("DELETE FROM Usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }



     public function obtenerTodos() {
        $usuarios = [];

       
        $sql = "SELECT u.id_usuario, u.id_rol, u.nombre_usuario, u.email, u.telefono, r.nombre_rol 
                FROM Usuarios u
                JOIN Roles r ON u.id_rol = r.id_rol
                ORDER BY u.nombre_usuario ASC";

        $resultado = $this->db->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            while($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }
        }
        
        return $usuarios;
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

    public function obtenerTodosLosTecnicos() {
        $tecnicos = [];
        $id_rol_tecnico = 2;

        $sql = "SELECT id_usuario, nombre_usuario FROM Usuarios WHERE id_rol = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id_rol_tecnico);
        $stmt->execute();
        $resultado = $stmt->get_result();

        while($fila = $resultado->fetch_assoc()) {
            $tecnicos[] = $fila;
        }
        return $tecnicos;
    }
}
