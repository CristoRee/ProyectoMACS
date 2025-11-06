<?php

?>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        
        const timeoutId = setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            
            setTimeout(() => successAlert.remove(), 500);
        }, 2000);

        
        const closeBtn = successAlert.querySelector('.btn-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                clearTimeout(timeoutId);
                successAlert.style.transition = 'opacity 0.3s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 300);
            });
        }
    }
});

// Función para cambiar idioma de forma interactiva
function changeLanguageInteractive(langCode, flag, name) {
    // Mostrar indicador de carga en el botón
    const btn = document.getElementById('languageDropdownLogin');
    const currentText = document.getElementById('currentLanguageText');
    const originalContent = currentText.innerHTML;
    
    // Cambiar a estado de carga
    btn.disabled = true;
    currentText.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>Cambiando...';
    
    // Crear formulario oculto para cambiar idioma
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?accion=login';
    form.style.display = 'none';
    
    const langInput = document.createElement('input');
    langInput.type = 'hidden';
    langInput.name = 'change_language';
    langInput.value = langCode;
    
    // Agregar parámetro para actualizar también el manual
    const updateManualInput = document.createElement('input');
    updateManualInput.type = 'hidden';
    updateManualInput.name = 'update_manual';
    updateManualInput.value = '1';
    
    form.appendChild(langInput);
    form.appendChild(updateManualInput);
    document.body.appendChild(form);
    
    // Simular una pequeña pausa para mostrar el efecto de carga
    setTimeout(() => {
        form.submit();
    }, 300);
}

// Función de compatibilidad hacia atrás
function changeLanguage(lang) {
    changeLanguageInteractive(lang, '', '');
}
</script>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="card mt-5 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="text-center mb-0 flex-grow-1"><?php echo __('login'); ?></h3>
                <!-- Selector interactivo de idioma -->
                <div class="language-selector-login">
                    <div class="dropdown">
                        <button class="btn btn-light btn-sm dropdown-toggle" 
                                type="button" 
                                id="languageDropdownLogin" 
                                data-bs-toggle="dropdown" 
                                aria-expanded="false">
                            <i class="fas fa-globe me-1"></i>
                            <span id="currentLanguageText">
                                <?php
                                $currentLang = Language::getCurrentLanguage();
                                $languages = [
                                    'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
                                    'en' => ['name' => 'English', 'flag' => '🇺🇸'], 
                                    'pt' => ['name' => 'Português', 'flag' => '🇧🇷']
                                ];
                                echo $languages[$currentLang]['flag'] . ' ' . $languages[$currentLang]['name'];
                                ?>
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdownLogin">
                            <?php foreach ($languages as $code => $lang): ?>
                            <li>
                                <a class="dropdown-item d-flex justify-content-between align-items-center <?php echo $currentLang === $code ? 'active' : ''; ?>" 
                                   href="#" 
                                   onclick="changeLanguageInteractive('<?php echo $code; ?>', '<?php echo $lang['flag']; ?>', '<?php echo $lang['name']; ?>')"
                                   data-lang="<?php echo $code; ?>">
                                    <span><?php echo $lang['flag']; ?> <?php echo $lang['name']; ?></span>
                                    <?php if($currentLang === $code): ?>
                                        <span class="text-primary">✓</span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?php echo __('incorrect_credentials'); ?></div>
                <?php endif; ?>
                <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
                    <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                        <div><?php echo __('registration_successful'); ?></div>
                        <button type="button" class="btn-close" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?accion=autenticar">
                    <div class="mb-3">
                        <label for="usuario" class="form-label"><?php echo __('username'); ?></label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label"><?php echo __('password'); ?></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary"><?php echo __('enter'); ?></button>
                    </div>
                </form>
                
                <div class="text-center mt-3">
                    <p class="mb-2"><?php echo __('no_account'); ?> <a href="index.php?accion=mostrarRegistro"><?php echo __('register'); ?></a></p>
                    <p class="mb-0">
                        <a href="Documentos/manual.php" target="_blank" class="text-muted text-decoration-none" 
                           title="<?php echo __('user_manual'); ?> (<?php echo $languages[Language::getCurrentLanguage()]['name']; ?>)">
                            <i class="fas fa-book me-1"></i><?php echo __('user_manual'); ?>
                            <small class="text-muted">(<?php echo $languages[Language::getCurrentLanguage()]['flag']; ?>)</small>
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
/* Estilos para el selector de idioma en login */
.language-selector-login {
    position: relative;
}

.language-selector-login .dropdown-toggle {
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    font-size: 12px;
    padding: 4px 8px;
    min-width: 110px;
    transition: all 0.2s ease;
}

.language-selector-login .dropdown-toggle:hover {
    background: rgba(255, 255, 255, 1);
    border-color: rgba(255, 255, 255, 0.5);
}

.language-selector-login .dropdown-toggle:focus {
    background: rgba(255, 255, 255, 1);
    border-color: rgba(255, 255, 255, 0.7);
    outline: none;
    box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.3);
}

.language-selector-login .dropdown-menu {
    min-width: 160px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 8px 0;
    margin-top: 4px;
}

.language-selector-login .dropdown-item {
    padding: 8px 16px;
    font-size: 14px;
    transition: background-color 0.15s ease-in-out;
}

.language-selector-login .dropdown-item:hover {
    background-color: #f8f9fa;
}

.language-selector-login .dropdown-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
    font-weight: 500;
}

.language-selector-login .dropdown-item .text-primary {
    color: #1976d2 !important;
    font-weight: bold;
}

/* Responsive para móviles */
@media (max-width: 768px) {
    .language-selector-login .dropdown-toggle {
        font-size: 11px;
        padding: 3px 6px;
        min-width: 90px;
    }
    
    .language-selector-login .dropdown-menu {
        min-width: 140px;
    }
    
    .language-selector-login .dropdown-item {
        padding: 6px 12px;
        font-size: 13px;
    }
}

/* Animación para el dropdown */
.language-selector-login .dropdown-menu.show {
    animation: slideDownFade 0.3s ease;
}

@keyframes slideDownFade {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<?php

?>