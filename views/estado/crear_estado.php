<?php

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: index.php?accion=inicio');
    exit();
}
?>
<div class="container mt-4">
    <h2><?php echo __('add_new_state'); ?></h2>
    <form method="POST" action="index.php?accion=guardarEstado">
        <div class="mb-3">
            <label for="nombre_estado" class="form-label"><?php echo __('state_name'); ?></label>
            <input type="text" class="form-control" id="nombre_estado" name="nombre_estado" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo __('save_state'); ?></button>
        <a href="index.php?accion=gestionarEstados" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
    </form>
</div>
