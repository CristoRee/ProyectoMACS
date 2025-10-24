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
        <?php elseif($_GET['status'] === 'photo_success'): ?>
            <div class="alert alert-success"><?php echo __('photo_updated'); ?></div>
        <?php elseif($_GET['status'] === 'no_file'): ?>
            <div class="alert alert-danger"><?php echo __('no_file_selected'); ?></div>
        <?php elseif($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger"><?php echo __('update_error'); ?></div>
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
                        <form action="index.php?accion=cambiarIdioma" method="POST" id="languageForm">
                            <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                            <div class="d-grid gap-2">
                                <?php 
                                $currentLang = Language::getCurrentLanguage();
                                $languages = [
                                    'es' => ['name' => __('spanish'), 'flag' => '🇪🇸'],
                                    'en' => ['name' => __('english'), 'flag' => '🇺🇸'],
                                    'pt' => ['name' => __('portuguese'), 'flag' => '🇧🇷']
                                ];
                                foreach ($languages as $code => $lang): ?>
                                <button type="submit" name="language" value="<?php echo $code; ?>" 
                                        class="btn <?php echo $currentLang === $code ? 'btn-primary' : 'btn-outline-primary'; ?> language-btn text-start position-relative" 
                                        style="border-radius: 15px; padding: 15px 20px;">
                                    <div class="d-flex align-items-center">
                                        <span class="me-3 fs-3 flag-emoji"><?php echo $lang['flag']; ?></span>
                                        <div class="flex-grow-1">
                                            <strong class="fs-6"><?php echo $lang['name']; ?></strong>
                                        </div>
                                        <?php if($currentLang === $code): ?>
                                        <span class="position-absolute top-0 start-100 translate-middle p-2 bg-success border border-light rounded-circle active-language-indicator">
                                            <i class="fas fa-check text-white" style="font-size: 0.7rem;"></i>
                                            <span class="visually-hidden">Idioma actual</span>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </button>
                                <?php endforeach; ?>
                            </div>
                        </form>
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
</style>

<script>
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
});
</script>