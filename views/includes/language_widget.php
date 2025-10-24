<?php
require_once(__DIR__ . '/../../config/Language.php');
Language::init();
$currentLang = strtoupper(Language::getCurrentLanguage());

// Solo mostrar en la página de inicio
$accion = $_REQUEST['accion'] ?? 'index';
if ($accion !== 'inicio') {
    return;
}
?>

<div class="language-widget">
    <a href="?accion=miPerfil#language-section" class="current-lang-btn" title="Cambiar idioma en perfil">
        <?= $currentLang ?>
    </a>
</div>

<style>
.language-widget {
    display: inline-block;
}

.current-lang-btn {
    display: inline-block;
    padding: 4px 8px;
    background: rgba(255, 255, 255, 0.1);
    border: none !important;
    border-radius: 4px;
    color: white !important;
    text-decoration: none !important;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 1px;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none !important;
    box-shadow: none !important;
}

.current-lang-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    color: white !important;
    text-decoration: none !important;
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
}

.current-lang-btn:focus {
    outline: none !important;
    box-shadow: none !important;
    border: none !important;
    background: rgba(255, 255, 255, 0.15) !important;
    color: white !important;
    text-decoration: none !important;
}

/* Modo oscuro */
[data-theme="dark"] .current-lang-btn {
    color: #f8f9fa;
    background: rgba(255, 255, 255, 0.1);
}

[data-theme="dark"] .current-lang-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: #f8f9fa;
}

[data-theme="dark"] .current-lang-btn:focus {
    background: rgba(255, 255, 255, 0.15);
    outline: none !important;
    box-shadow: none !important;
}

/* Responsive */
@media (max-width: 768px) {
    .language-widget {
        right: 45%;
    }
    
    .current-lang-btn {
        font-size: 12px;
    }
}
</style>

