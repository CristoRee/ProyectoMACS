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

// Función para cambiar idioma
function changeLanguage(lang) {
    // Crear formulario simple para cambiar idioma mediante sesión
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'index.php?accion=login';
    
    const langInput = document.createElement('input');
    langInput.type = 'hidden';
    langInput.name = 'change_language';
    langInput.value = lang;
    
    form.appendChild(langInput);
    document.body.appendChild(form);
    form.submit();
}
</script>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 col-xl-4">
        <div class="card mt-5 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="text-center mb-0 flex-grow-1"><?php echo __('login'); ?></h3>
                <!-- Selector básico de idioma -->
                <div class="language-selector-login">
                    <select class="form-select form-select-sm" style="width: auto;" onchange="changeLanguage(this.value)">
                        <?php
                        $currentLang = Language::getCurrentLanguage();
                        $languages = [
                            'es' => 'Español',
                            'en' => 'English', 
                            'pt' => 'Português'
                        ];
                        foreach ($languages as $code => $name): ?>
                            <option value="<?php echo $code; ?>" <?php echo ($currentLang === $code) ? 'selected' : ''; ?>>
                                <?php echo $name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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
                    <p class="mb-0"><?php echo __('no_account'); ?> <a href="index.php?accion=mostrarRegistro"><?php echo __('register'); ?></a></p>
                </div>

            </div>
        </div>
    </div>
</div>

<?php

?>