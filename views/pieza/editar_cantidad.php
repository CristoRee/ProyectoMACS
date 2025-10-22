<div class="container mt-4 d-flex justify-content-center">
    <div class="col-lg-6">
        <h2 class="text-center mb-4">Editar Cantidad de Pieza</h2>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        <div class="card shadow">
            <div class="card-body">
                <div class="text-center mb-3">
                    <?php if ($pieza['imagen']): ?>
                        <img src="<?php echo htmlspecialchars($pieza['imagen']); ?>" alt="Imagen de pieza" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 150px;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    <h5 class="mt-2"><?php echo htmlspecialchars($pieza['nombre']); ?></h5>
                </div>
                <form action="index.php?accion=editarCantidad&id_ticket=<?php echo $id_ticket; ?>&id_repuesto=<?php echo $pieza['id_repuesto']; ?>" method="POST">
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Nueva Cantidad *</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1" value="<?php echo $cantidad_actual; ?>" placeholder="Ingrese la nueva cantidad">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save"></i> Actualizar Cantidad
                        </button>
                        <a href="index.php?accion=verTicketConPiezas" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
