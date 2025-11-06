<?php 
// Widget compacto de cambio de idioma
$currentLang = Language::getCurrentLanguage();
$languages = [
    'es' => ['name' => __('spanish'), 'flag' => '🇪🇸', 'icon' => '💃'],
    'en' => ['name' => __('english'), 'flag' => '🇺🇸', 'icon' => '🗽'],
    'pt' => ['name' => __('portuguese'), 'flag' => '🇧🇷', 'icon' => '⚽']
];
?>

<div class="language-switcher-widget">
    <form action="index.php?accion=cambiarIdioma" method="POST" id="languageWidgetForm">
        <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
        
        <!-- Botón desplegable del idioma actual -->
        <div class="dropdown">
            <button class="btn btn-outline-light dropdown-toggle language-widget-btn" type="button" 
                    data-bs-toggle="dropdown" aria-expanded="false">
                <span class="flag-emoji"><?php echo $languages[$currentLang]['flag']; ?></span>
                <span class="d-none d-md-inline ms-2"><?php echo $languages[$currentLang]['name']; ?></span>
            </button>
            
            <!-- Menú desplegable con opciones de idioma -->
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="min-width: 200px;">
                <li><h6 class="dropdown-header"><?php echo __('language'); ?></h6></li>
                <li><hr class="dropdown-divider"></li>
                
                <?php foreach ($languages as $code => $lang): ?>
                <li>
                    <button type="submit" name="language" value="<?php echo $code; ?>" 
                            class="dropdown-item language-option <?php echo $currentLang === $code ? 'active' : ''; ?>">
                        <div class="d-flex align-items-center">
                            <span class="me-3 fs-5"><?php echo $lang['flag']; ?></span>
                            <span class="flex-grow-1"><?php echo $lang['name']; ?></span>
                            <span class="ms-2 opacity-75"><?php echo $lang['icon']; ?></span>
                            <?php if($currentLang === $code): ?>
                            <i class="fas fa-check text-primary ms-2"></i>
                            <?php endif; ?>
                        </div>
                    </button>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </form>
</div>

<style>
.language-switcher-widget {
    position: relative;
}

.language-widget-btn {
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    background: rgba(255, 255, 255, 0.1) !important;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease !important;
    border-radius: 25px !important;
    padding: 8px 16px !important;
}

.language-widget-btn:hover {
    background: rgba(255, 255, 255, 0.2) !important;
    border-color: rgba(255, 255, 255, 0.5) !important;
    transform: translateY(-2px);
}

.language-widget-btn .flag-emoji {
    display: inline-block;
    transition: transform 0.3s ease;
    font-size: 1.1em;
}

.language-widget-btn:hover .flag-emoji {
    transform: scale(1.2);
}

.language-option {
    border: none !important;
    padding: 12px 16px !important;
    transition: all 0.3s ease !important;
    border-radius: 8px !important;
    margin: 2px 8px !important;
}

.language-option:hover {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef) !important;
    transform: translateX(5px);
}

.language-option.active {
    background: linear-gradient(135deg, #007bff, #0056b3) !important;
    color: white !important;
}

.language-option.active:hover {
    background: linear-gradient(135deg, #0056b3, #004085) !important;
}

.dropdown-menu {
    border-radius: 15px !important;
    padding: 8px !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2) !important;
}
</style>