<?php
// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(__DIR__ . '/../config/Language.php');

// Inicializar el sistema de idiomas
Language::init();

// Obtener el idioma actual (puede venir del login o de la sesión activa)
$currentLang = Language::getCurrentLanguage();

// Log para debugging (opcional)
error_log("Manual solicitado en idioma: " . $currentLang);

// Definir los archivos de manual según el idioma
$manuals = [
    'es' => 'Manual_Usuario_ProyectoMACS_Usuario.html',
    'en' => 'Manual_Usuario_ProyectoMACS_Usuario_EN.html',
    'pt' => 'Manual_Usuario_ProyectoMACS_Usuario_PT.html'
];

// Seleccionar el manual correcto
$manualFile = $manuals[$currentLang] ?? $manuals['es']; // Español por defecto

// Construir la ruta completa
$manualPath = __DIR__ . '/' . $manualFile;

// Verificar si el archivo existe y servirlo
if (file_exists($manualPath)) {
    // Establecer headers apropiados
    header('Content-Type: text/html; charset=UTF-8');
    
    // Leer y mostrar el contenido
    readfile($manualPath);
} else {
    // Si no existe el manual en el idioma solicitado, mostrar el español
    $defaultPath = __DIR__ . '/' . $manuals['es'];
    if (file_exists($defaultPath)) {
        header('Content-Type: text/html; charset=UTF-8');
        readfile($defaultPath);
    } else {
        // Error de fallback
        http_response_code(404);
        echo '<h1>Manual no encontrado</h1>';
        echo '<p>El archivo del manual no existe. Contacte al administrador.</p>';
    }
}
?>