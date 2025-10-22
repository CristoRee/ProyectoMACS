<div class="container my-5">
    <h2 class="pb-2 border-bottom mb-4"><?php echo __('my_profile'); ?></h2>

    <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] === 'profile_success'): ?>
            <div class="alert alert-success"><?php echo __('profile_updated_successfully'); ?></div>
        <?php elseif($_GET['status'] === 'photo_success'): ?>
            <div class="alert alert-success"><?php echo __('photo_updated_successfully'); ?></div>
        <?php elseif($_GET['status'] === 'pwd_success'): ?>
            <div class="alert alert-success"><?php echo __('password_changed_successfully'); ?></div>
        <?php elseif($_GET['status'] === 'pwd_mismatch'): ?>
            <div class="alert alert-danger"><?php echo __('password_mismatch'); ?></div>
        <?php elseif($_GET['status'] === 'pwd_incorrect'): ?>
            <div class="alert alert-danger"><?php echo __('current_password_incorrect'); ?></div>
        <?php elseif($_GET['status'] === 'upload_error'): ?>
            <div class="alert alert-danger"><?php echo __('upload_error'); ?></div>
        <?php elseif($_GET['status'] === 'no_file'): ?>
            <div class="alert alert-danger"><?php echo __('no_file_selected'); ?></div>
        <?php elseif($_GET['status'] === 'invalid_file_type'): ?>
            <div class="alert alert-danger"><?php echo __('invalid_file_type'); ?></div>
        <?php elseif($_GET['status'] === 'file_too_large'): ?>
            <div class="alert alert-danger"><?php echo __('file_too_large'); ?></div>
        <?php elseif($_GET['status'] === 'invalid_extension'): ?>
            <div class="alert alert-danger"><?php echo __('invalid_extension'); ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4">
           <div class="card shadow-sm mb-4">
             <div class="card-header"><?php echo __('profile_picture'); ?></div>
                <div class="card-body text-center">
                     <img src="<?php echo !empty($usuario['foto_perfil']) ? htmlspecialchars($usuario['foto_perfil']) : 'assets/images/default-avatar.png'; ?>" 
                          alt="Foto de Perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
        
            <form action="index.php?accion=actualizarFotoPerfil" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="file" name="foto_perfil" required accept="image/*">
                </div>
            <button type="submit" class="btn btn-primary btn-sm"><?php echo __('change_photo'); ?></button>
        </form>
    </div>
</div>

            <div class="card shadow-sm">
                <div class="card-header"><?php echo __('preferences'); ?></div>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch"><?php echo __('dark_mode'); ?></label>
                    </div>
                    <hr>
                    <form action="index.php?accion=cambiarIdioma" method="POST">
                        <div class="mb-3">
                            <label for="lang" class="form-label"><?php echo __('language'); ?></label>
                            <select class="form-select" name="lang" id="lang">
                                <option value="es" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] === 'es') ? 'selected' : ''; ?>>Español</option>
                                <option value="en" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] === 'en') ? 'selected' : ''; ?>>English</option>
                                <option value="pt-BR" <?php echo (isset($_SESSION['lang']) && $_SESSION['lang'] === 'pt-BR') ? 'selected' : ''; ?>>Português (Brasil)</option>
                            </select>
                        </div>
                        <input type="hidden" name="redirect" value="index.php?accion=miPerfil">
                        <button type="submit" class="btn btn-secondary btn-sm"><?php echo __('change_language'); ?></button>
                    </form>
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
                        <button type="submit" class="btn btn-primary"><?php echo __('save_changes'); ?></button>
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
                            <label for="password_confirm" class="form-label"><?php echo __('confirma_new_password'); ?></label>
                            <input type="password" class="form-control" name="password_confirm" required>
                        </div>
                        <button type="submit" class="btn btn-warning"><?php echo __('change_password'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>