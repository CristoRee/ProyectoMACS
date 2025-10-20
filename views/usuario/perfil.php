<div class="container my-5">
    <h2 class="pb-2 border-bottom mb-4">Mi Perfil</h2>

    <?php if(isset($_GET['status'])): ?>
        <?php if($_GET['status'] === 'profile_success'): ?>
            <div class="alert alert-success">Perfil actualizado con éxito.</div>
        <?php elseif($_GET['status'] === 'pwd_success'): ?>
            <div class="alert alert-success">Contraseña cambiada con éxito.</div>
        <?php elseif($_GET['status'] === 'pwd_mismatch'): ?>
            <div class="alert alert-danger">La nueva contraseña y su confirmación no coinciden.</div>
        <?php elseif($_GET['status'] === 'pwd_incorrect'): ?>
            <div class="alert alert-danger">La contraseña actual es incorrecta.</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-4">
           <div class="card shadow-sm mb-4">
             <div class="card-header">Foto de Perfil</div>
                <div class="card-body text-center">
                     <img src="<?php echo !empty($usuario['foto_perfil']) ? htmlspecialchars($usuario['foto_perfil']) : 'assets/images/default-avatar.png'; ?>" 
                          alt="Foto de Perfil" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
        
            <form action="index.php?accion=actualizarFotoPerfil" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <input class="form-control form-control-sm" type="file" name="foto_perfil" required>
                </div>
            <button type="submit" class="btn btn-primary btn-sm">Cambiar Foto</button>
        </form>
    </div>
</div>

            <div class="card shadow-sm">
                <div class="card-header">Preferencias</div>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch">Modo Oscuro</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">Datos Personales</div>
                <div class="card-body">
                    <form action="index.php?accion=actualizarPerfil" method="POST">
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" value="<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">Seguridad</div>
                <div class="card-body">
                    <form action="index.php?accion=cambiarPassword" method="POST">
                        <div class="mb-3">
                            <label for="password_actual" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" name="password_actual" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_nueva" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password_nueva" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" name="password_confirm" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>