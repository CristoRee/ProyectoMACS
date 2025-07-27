<?php
require_once("../../config/conexion.php");
include('../includes/header.php'); 
?>
<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h4 mb-0">Editar Usuario</h2>
                </div>
                <div class="card-body">
                    <!-- El action del formulario apunta al controlador y acción correctos -->
                    <form method="POST" action="index.php?accion=actualizarUsuario">
                        
                        <!-- Campo oculto para enviar el ID del usuario -->
                        <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($datos['id_usuario']) ?>">
                        
                        <!-- Campo Nombre de Usuario -->
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label">Nombre de Usuario:</label>
                            <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" value="<?= htmlspecialchars($datos['nombre_usuario']) ?>" required>
                        </div>
                        
                        <!-- Campo Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($datos['email']) ?>" required>
                        </div>

                        <!-- Campo Teléfono (Opcional) -->
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono (Opcional):</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" value="<?= htmlspecialchars($datos['telefono'] ?? '') ?>">
                        </div>

                        <!-- Campo Especialización (Opcional) -->
                        <div class="mb-3">
                            <label for="especializacion" class="form-label">Especialización (Opcional):</label>
                            <input type="text" id="especializacion" name="especializacion" class="form-control" value="<?= htmlspecialchars($datos['especializacion'] ?? '') ?>">
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php?accion=listarUsuarios" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>