<?php
class Usuario {
    private $db;

    public function __construct() {
        // Asumo que tienes una función global conectar() que devuelve la conexión.
        $this->db = conectar();
    }

    /**
     * ===== FUNCIÓN AÑADIDA AQUÍ =====
     * Crea un nuevo usuario en la base de datos con una contraseña segura.
     */
    public function crear($nombre, $email, $password_plana) {
        // 1. Hasheamos la contraseña para guardarla de forma segura.
        $hash_seguro = password_hash($password_plana, PASSWORD_DEFAULT);

        // 2. Preparamos la consulta para insertar el HASH, no la contraseña plana.
        $stmt = $this->db->prepare(
            "INSERT INTO Usuarios (nombre_usuario, email, password_hash, id_rol) VALUES (?, ?, ?, ?)"
        );
        
        // Si no se pudo preparar la consulta, devuelve false.
        if (!$stmt) {
            return false;
        }

        // Asumimos un rol por defecto para nuevos registros (ej: 3 para 'Cliente').
        // ¡Asegúrate de que el id_rol 3 exista en tu tabla Roles!
        $rol_por_defecto = 3; 

        // 3. Vinculamos los parámetros y ejecutamos.
        $stmt->bind_param("sssi", $nombre, $email, $hash_seguro, $rol_por_defecto);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Verifica las credenciales del usuario de forma segura.
     */
    public function verificar($nombre_usuario, $password_plana) {
        // Preparamos la consulta para obtener el usuario por su nombre
        $stmt = $this->db->prepare("SELECT * FROM Usuarios WHERE nombre_usuario = ? LIMIT 1");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            // Usamos password_verify para comparar la contraseña plana contra el hash.
            if (password_verify($password_plana, $usuario['password_hash'])) {
                // Si la contraseña es correcta, devolvemos los datos del usuario.
                return $usuario;
            }
        }
        
        // Si el usuario no existe o la contraseña es incorrecta, devuelve false.
        return false;
    }
}
