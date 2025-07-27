<?php
// Se añade el require_once para asegurar que la función conectar() esté disponible.
// La ruta __DIR__ . '/../config/conexion.php' asume que la carpeta 'models' y 'config'
// están al mismo nivel en la raíz de tu proyecto.
require_once __DIR__ . '/../config/conexion.php';

class Producto {
    private $db;

    public function __construct() {
        // Ahora la función conectar() existirá cuando se llame aquí.
        $this->db = conectar();
    }

    /**
     * Crea una solicitud completa (Producto, Ticket y Fotos) usando una transacción.
     * Esto asegura la integridad de los datos.
     *
     * @param array $datosProducto Datos del dispositivo a registrar.
     * @param array $datosTicket Datos del ticket de reparación.
     * @param array $rutasFotos Un array con las rutas de las imágenes guardadas.
     * @return bool Devuelve true si toda la operación fue exitosa, false si algo falló.
     */
    public function crearSolicitudCompleta($datosProducto, $datosTicket, $rutasFotos) {
        // Iniciar la transacción para asegurar la integridad de los datos.
        $this->db->begin_transaction();

        try {
            // Paso 1: Insertar en la tabla Productos
            $sqlProducto = "INSERT INTO Productos (tipo_producto, marca, modelo, id_cliente) VALUES (?, ?, ?, ?)";
            $stmtProducto = $this->db->prepare($sqlProducto);
            $stmtProducto->bind_param(
                "sssi",
                $datosProducto['tipo_producto'],
                $datosProducto['marca'],
                $datosProducto['modelo'],
                $datosProducto['id_cliente']
            );
            $stmtProducto->execute();
            $id_producto = $this->db->insert_id; // Obtener el ID del producto recién creado

            // Si no se pudo crear el producto, lanzamos una excepción para detener todo.
            if ($id_producto === 0) {
                throw new Exception("No se pudo crear el producto en la base de datos.");
            }

            // Paso 2: Insertar en la tabla Tickets
            $sqlTicket = "INSERT INTO Tickets (descripcion_problema, id_cliente, id_producto, id_estado) VALUES (?, ?, ?, ?)";
            $stmtTicket = $this->db->prepare($sqlTicket);
            $estado_inicial = 1; // Asumimos que el ID 1 corresponde a 'Ingresado'
            $stmtTicket->bind_param(
                "siii",
                $datosTicket['descripcion_problema'],
                $datosTicket['id_cliente'],
                $id_producto,
                $estado_inicial
            );
            $stmtTicket->execute();
            $id_ticket = $this->db->insert_id; // Obtener el ID del ticket recién creado

            if ($id_ticket === 0) {
                throw new Exception("No se pudo crear el ticket en la base de datos.");
            }

            // Paso 3: Insertar en la tabla Fotos_Ticket (solo si hay fotos)
            if (!empty($rutasFotos)) {
                $sqlFoto = "INSERT INTO Fotos_Ticket (url_imagen, id_ticket) VALUES (?, ?)";
                $stmtFoto = $this->db->prepare($sqlFoto);
                foreach ($rutasFotos as $ruta) {
                    $stmtFoto->bind_param("si", $ruta, $id_ticket);
                    $stmtFoto->execute();
                }
            }

            // Si todos los pasos fueron exitosos, confirmamos los cambios en la base de datos.
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            // Si algo falló en cualquier punto, deshacemos todos los cambios.
            $this->db->rollback();
            // Opcional: puedes registrar el error para depuración. error_log($e->getMessage());
            return false;
        }
    }
}
