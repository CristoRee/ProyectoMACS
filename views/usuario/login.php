<?php
// El header ya fue cargado por el controlador antes de llegar aquí.
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            <div class="card mt-5 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center mb-0">Iniciar Sesión</h3>
                </div>
                <div class="card-body p-4">
                    
                    <?php 
                    // Muestra un mensaje de error si la autenticación falló
                    if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">Usuario o contraseña incorrectos.</div>
                    <?php endif; ?>

                    <?php 
                    // Muestra un mensaje de éxito si el registro fue exitoso
                    if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
                        <div class="alert alert-success">¡Registro exitoso! Por favor, inicie sesión.</div>
                    <?php endif; ?>

                    <form method="POST" action="index.php?accion=autenticar">
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="usuario" name="usuario" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                    
                    <!-- ===== SECCIÓN AÑADIDA ===== -->
                    <div class="text-center mt-3">
                        <p class="mb-0">¿No tienes cuenta? <a href="index.php?accion=mostrarRegistro">Regístrate</a></p>
                    </div>
                    <!-- ===== FIN DE LA SECCIÓN AÑADIDA ===== -->

                </div>
            </div>
        </div>
    </div>
</div>
