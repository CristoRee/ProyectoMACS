<div class="container my-5">
    <h2 class="pb-2 border-bottom mb-4"><?php echo __('profile_title'); ?></h2>

    <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] === 'profile_success'): ?>
            <div class="alert alert-success"><?php echo __('profile_updated'); ?></div>
        <?php elseif($_GET['status'] === 'pwd_success'): ?>
            <div class="alert alert-success"><?php echo __('password_updated'); ?></div>
        <?php elseif($_GET['status'] === 'pwd_mismatch'): ?>
            <div class="alert alert-danger"><?php echo __('password_mismatch'); ?></div>
        <?php elseif($_GET['status'] === 'pwd_incorrect'): ?>
            <div class="alert alert-danger"><?php echo __('password_incorrect'); ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4">
           <div class="card shadow-sm mb-4">
             <div class="card-header"><?php echo __('profile_photo'); ?></div>
                <div class="card-body text-center">
                     <img src="<?php echo !empty($usuario['foto_perfil']) ? htmlspecialchars($usuario['foto_perfil']) : 'assets/images/default-avatar.png'; ?>" 
                          alt="Foto de perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
        
            <form action="index.php?accion=actualizarFotoPerfil" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="file" name="foto_perfil" required>
                </div>
            <button type="submit" class="btn btn-primary btn-sm"><?php echo __('change_photo'); ?></button>
        </form>
    </div>
</div>

            <div class="card shadow-sm mb-4">
                <div class="card-header"><?php echo __('preferences'); ?></div>
                <div class="card-body">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch"><?php echo __('dark_mode'); ?></label>
                    </div>
                    
                    <!-- Selector de Idioma -->
                    <div class="mb-3" id="language-section">
                        <label class="form-label"><?php echo __('language'); ?></label>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle w-100 text-start" 
                                    type="button" 
                                    id="languageDropdown" 
                                    data-bs-toggle="dropdown" 
                                    aria-expanded="false">
                                <?php 
                                $currentLang = Language::getCurrentLanguage();
                                $languages = [
                                    'es' => ['name' => __('spanish'), 'flag' => '🇪🇸'],
                                    'en' => ['name' => __('english'), 'flag' => '🇺🇸'],
                                    'pt' => ['name' => __('portuguese'), 'flag' => '🇧🇷']
                                ];
                                echo $languages[$currentLang]['name'];
                                ?>
                            </button>
                            <ul class="dropdown-menu w-100" aria-labelledby="languageDropdown">
                                <?php foreach ($languages as $code => $lang): ?>
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center <?php echo $currentLang === $code ? 'active' : ''; ?>" 
                                       href="#" 
                                       onclick="changeLanguage('<?php echo $code; ?>')"
                                       data-lang="<?php echo $code; ?>">
                                        <span><?php echo $lang['name']; ?></span>
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
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header"><?php echo __('personal_data'); ?></div>
                <div class="card-body">
                    <form action="index.php?accion=actualizarPerfil" method="POST">
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label"><?php echo __('username'); ?></label>
                            <input type="text" class="form-control" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><?php echo __('email'); ?></label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label"><?php echo __('phone'); ?></label>
                            <input type="tel" class="form-control" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo __('save'); ?></button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header"><?php echo __('security'); ?></div>
                <div class="card-body">
                    <form action="index.php?accion=cambiarPassword" method="POST">
                        <div class="mb-3">
                            <label for="password_actual" class="form-label"><?php echo __('current_password'); ?></label>
                            <input type="password" class="form-control" name="password_actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_nueva" class="form-label"><?php echo __('new_password'); ?></label>
                            <input type="password" class="form-control" name="password_nueva" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label"><?php echo __('confirm_password'); ?></label>
                            <input type="password" class="form-control" name="password_confirm" required>
                        </div>
                        <button type="submit" class="btn btn-warning"><?php echo __('change_password'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
#language-section {
    scroll-margin-top: 20px;
}

.highlight-section {
    animation: highlightPulse 2s ease-in-out;
}

@keyframes highlightPulse {
    0% { background-color: transparent; }
    50% { background-color: rgba(0, 123, 255, 0.1); }
    100% { background-color: transparent; }
}

/* Estilos para el dropdown de idioma */
#languageDropdown {
    border: 1px solid #ced4da;
    border-radius: 6px;
    padding: 8px 12px;
    background-color: white;
    color: #333;
    font-size: 14px;
}

#languageDropdown:hover {
    border-color: #adb5bd;
    background-color: #f8f9fa;
}

#languageDropdown:focus {
    border-color: #86b7fe;
    outline: 0;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.dropdown-menu {
    border: 1px solid #dee2e6;
    border-radius: 6px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 4px 0;
    margin-top: 2px;
}

.dropdown-item {
    padding: 8px 16px;
    font-size: 14px;
    color: #333;
    transition: background-color 0.15s ease-in-out;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    color: #333;
}

.dropdown-item.active {
    background-color: #e3f2fd;
    color: #1976d2;
    font-weight: 500;
}

.dropdown-item .text-primary {
    color: #1976d2 !important;
    font-weight: bold;
}

/* Modo oscuro */
[data-theme="dark"] #languageDropdown {
    background-color: #495057;
    border-color: #6c757d;
    color: #f8f9fa;
}

[data-theme="dark"] #languageDropdown:hover {
    background-color: #5a6268;
    border-color: #7c8791;
}

[data-theme="dark"] .dropdown-menu {
    background-color: #343a40;
    border-color: #495057;
}

[data-theme="dark"] .dropdown-item {
    color: #f8f9fa;
}

[data-theme="dark"] .dropdown-item:hover {
    background-color: #495057;
    color: #f8f9fa;
}

[data-theme="dark"] .dropdown-item.active {
    background-color: #0d6efd;
    color: white;
}
</style>

<script>
function changeLanguage(langCode) {
    // Mostrar indicador de carga
    const btn = document.getElementById('languageDropdown');
    const originalText = btn.textContent;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Cambiando...';
    btn.disabled = true;
    
    // Crear formulario oculto para enviar el cambio de idioma
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?accion=cambiarIdioma';
    form.style.display = 'none';
    
    const langInput = document.createElement('input');
    langInput.type = 'hidden';
    langInput.name = 'language';
    langInput.value = langCode;
    
    const redirectInput = document.createElement('input');
    redirectInput.type = 'hidden';
    redirectInput.name = 'redirect';
    redirectInput.value = window.location.href;
    
    form.appendChild(langInput);
    form.appendChild(redirectInput);
    document.body.appendChild(form);
    
    // Enviar formulario
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay un hash en la URL
    if (window.location.hash === '#language-section') {
        setTimeout(function() {
            const section = document.getElementById('language-section');
            if (section) {
                // Agregar efecto de resaltado
                section.classList.add('highlight-section');
                
                // Remover la clase después de la animación
                setTimeout(function() {
                    section.classList.remove('highlight-section');
                }, 2000);
            }
        }, 300);
    }
    
    // Manejar clics en las opciones del dropdown
    const dropdownItems = document.querySelectorAll('#language-section .dropdown-item');
    dropdownItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const langCode = this.getAttribute('data-lang');
            if (langCode) {
                changeLanguage(langCode);
            }
        });
    });
});
</script>