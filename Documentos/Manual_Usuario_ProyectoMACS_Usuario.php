<?php
// Este archivo sirve el manual de usuario para abrirlo via PHP
$path = __DIR__ . '/Manual_Usuario_ProyectoMACS_Usuario.html';
if (file_exists($path)) {
    header('Content-Type: text/html; charset=utf-8');
    echo file_get_contents($path);
    exit;
} else {
    http_response_code(404);
    echo '<h1>Manual no encontrado</h1><p>El archivo del manual no existe. Verifica la ruta.</p>';
}
