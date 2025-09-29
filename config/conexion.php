<?php
function conectar() {
    $host = 'localhost:3306';
    $usuario = 'root';
    $clave = '';
    $base_datos = 'basemacs';

    $conexion = new mysqli($host, $usuario, null, $base_datos);

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    return $conexion;
}
?>