<?
    require_once("config/conexion.php");
    require_once("views/templates/css.css");
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Crear Nueva Cuenta</h2>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Complete el formulario para registrar un nuevo usuario en el sistema.</p>
                    
                    
                    <form method="POST" action="index.php?accion=registrar">
                        
                        
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