<div class="container mt-4">
    <h2>Editar Hardware</h2>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form action="index.php?accion=editarPieza&id=<?php echo $pieza['id_repuesto']; ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="imagen_actual" value="<?php echo htmlspecialchars($pieza['imagen'] ?? ''); ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Hardware *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required value="<?php echo htmlspecialchars($pieza['nombre']); ?>" placeholder="Ej: Memoria RAM DDR4 8GB">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción opcional del hardware"><?php echo htmlspecialchars($pieza['descripcion']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label"><?php echo __('stock'); ?> *</label>
            <input type="number" class="form-control" id="stock" name="stock" required min="0" value="<?php echo $pieza['stock']; ?>" placeholder="0">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label"><?php echo __('price'); ?> *</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required min="0" value="<?php echo $pieza['precio']; ?>" placeholder="0.00">
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label"><?php echo __('part_image'); ?></label>
            <?php if ($pieza['imagen']): ?>
                <div class="mb-2">
                    <img src="<?php echo htmlspecialchars($pieza['imagen']); ?>" alt="Imagen actual" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
            <?php endif; ?>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            <small class="form-text text-muted">Deja vacío para mantener la imagen actual. Formatos permitidos: JPG, JPEG, PNG, GIF. Máximo 5MB.</small>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Hardware</button>
        <a href="index.php?accion=mostrarPiezas" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
    </form>
</div>
