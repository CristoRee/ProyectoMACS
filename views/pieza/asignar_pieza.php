<div class="container mt-4">
    <h2><?php echo __('assign_part'); ?> al Ticket #<?php echo htmlspecialchars($id_ticket); ?></h2>
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    <form action="index.php?accion=asignarPieza&id_ticket=<?php echo $id_ticket; ?>" method="POST">
        <div class="mb-3">
            <label for="id_repuesto" class="form-label">Seleccionar Hardware *</label>
            <select class="form-control" id="id_repuesto" name="id_repuesto" required>
                <option value="">Seleccione hardware</option>
                <?php foreach ($piezas as $pieza): ?>
                    <option value="<?php echo $pieza['id_repuesto']; ?>"><?php echo htmlspecialchars($pieza['nombre']); ?> (<?php echo __('stock'); ?>: <?php echo $pieza['stock']; ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label"><?php echo __('quantity'); ?> *</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" required min="1" placeholder="1">
        </div>
        <button type="submit" class="btn btn-primary"><?php echo __('assign_part'); ?></button>
        <a href="index.php?accion=verTicketConPiezas" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
    </form>
</div>
