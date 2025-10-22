<?php


function conectar() {
    $host = 'localhost';
    $usuario = 'binary';
    $clave = 'admin123';
    $base_datos = 'basemacs';

    $conexion = new mysqli($host, $usuario, $clave, $base_datos);

    if ($conexion->connect_error) {
        die('Error de conexión: ' . $conexion->connect_error);
    }

    return $conexion;
}
?>
