<?php 
$titulo = "Editar Producto";
include('views/includes/header.php'); 
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Editar Producto</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?accion=actualizar">
                    <input type="hidden" name="id" value="<?= $datos['id'] ?>">
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               value="<?= htmlspecialchars($datos['nombre']) ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="precio" name="precio" 
                                   value="<?= $datos['precio'] ?>" step="0.01" min="0" required>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="index.php" class="btn btn-secondary me-md-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('views/includes/footer.php'); ?>