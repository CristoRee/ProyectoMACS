<div class="container mt-4">
    <h2><?php echo __('add_new_part'); ?></h2>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form action="index.php?accion=crearPieza" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Hardware *</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Memoria RAM DDR4 8GB">
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción opcional del hardware"></textarea>
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label"><?php echo __('stock'); ?> Inicial *</label>
            <input type="number" class="form-control" id="stock" name="stock" required min="0" placeholder="0">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label"><?php echo __('price'); ?> *</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" required min="0" placeholder="0.00">
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label"><?php echo __('part_image'); ?></label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
            <small class="form-text text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF. Máximo 5MB.</small>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Hardware</button>
        <a href="index.php?accion=mostrarPiezas" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
    </form>
</div>
