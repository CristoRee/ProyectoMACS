<?php 
$titulo = "Nueva Solicitud de Reparación";
// El header ya lo carga el controlador o el index.php
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">Ingresar Nueva Solicitud de Reparación</h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted">Por favor, complete todos los campos para generar el ticket de reparación.</p>
                    
                    <!-- IMPORTANTE: enctype es necesario para subir archivos -->
                    <form method="POST" action="index.php?accion=guardarSolicitud" enctype="multipart/form-data">
                        
                        <h5 class="mt-4">1. Datos del Dispositivo</h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipo_producto" class="form-label">Tipo de Dispositivo</label>
                                <select class="form-select" id="tipo_producto" name="tipo_producto" required>
                                    <option value="" selected disabled>Seleccione una opción...</option>
                                    <option value="Computadora">Computadora de Escritorio</option>
                                    <option value="Laptop">Laptop</option>
                                    <option value="Celular">Celular</option>
                                    <option value="Tablet">Tablet</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>

                        <h5 class="mt-4">2. Descripción del Problema</h5>
                        <hr>

                        <div class="mb-3">
                            <label for="descripcion_problema" class="form-label">Describa el problema con el mayor detalle posible</label>
                            <textarea class="form-control" id="descripcion_problema" name="descripcion_problema" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="fotos" class="form-label">Adjuntar Fotos (opcional)</label>
                            <input class="form-control" type="file" id="fotos" name="fotos[]" multiple>
                            <div class="form-text">Puede seleccionar varias imágenes para mostrar el estado del dispositivo.</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php?accion=inicio" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
