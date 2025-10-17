<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Crear Nueva Cuenta</h2>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Complete el formulario para registrar un nuevo usuario en el sistema.</p>
                    
                    <?php 
                    if (isset($_GET['error']) && $_GET['error'] === 'password'): ?>
                        <div class="alert alert-danger">Las contraseñas no coinciden. Por favor, inténtelo de nuevo.</div>
                    <?php endif; ?>
                    <?php 
                    if (isset($_GET['error']) && $_GET['error'] === 'email_duplicate'): ?>
                        <div class="alert alert-danger">El correo electrónico ya está registrado. Intente iniciar sesión o use otro correo.</div>
                    <?php endif; ?>
                    <?php 
                    if (isset($_GET['error']) && $_GET['error'] === 'db'): ?>
                        <div class="alert alert-danger">Ocurrió un error en la base de datos. Por favor inténtelo más tarde.</div>
                    <?php endif; ?>
                    
                    <form method="POST" action="index.php?accion=registrar" id="registroForm">
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" placeholder="Ej: cris_tecnico" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Ej: correo@ejemplo.com" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirmar Contraseña:</label>
                            <input type="password" id="password_confirm" name="password_confirm" class="form-control" required>
                            <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php?accion=login" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Registrar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');

    form.addEventListener('submit', function(event) {
        if (password.value !== passwordConfirm.value) {
            
            event.preventDefault();
            
            
            passwordConfirm.classList.add('is-invalid');
        } else {
            passwordConfirm.classList.remove('is-invalid');
        }
    });

    
    passwordConfirm.addEventListener('keyup', function() {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.classList.add('is-invalid');
        } else {
            passwordConfirm.classList.remove('is-invalid');
        }
    });
});
</script>