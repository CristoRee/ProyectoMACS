<div class="container my-5">
    <h2 class="pb-2 border-bottom mb-4">Ajustes de Notificaciones por Email</h2>
    <p class="text-muted">Selecciona los cambios de estado que deben notificar automáticamente al cliente por correo electrónico.</p>
    
    <?php if(isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success">Ajustes guardados con éxito.</div>
    <?php endif; ?>

    <form action="index.php?accion=guardarAjustesNotificaciones" method="POST">
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Estados de los Tickets</strong>
            </div>
            <div class="list-group list-group-flush">
                <?php foreach ($estados as $estado): ?>
                <div class="list-group-item">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="estado_<?php echo $estado['id_estado']; ?>" 
                               name="notificar[]" 
                               value="<?php echo $estado['id_estado']; ?>"
                               <?php if ($estado['notificar_cliente']) echo 'checked'; ?>>
                        <label class="form-check-label" for="estado_<?php echo $estado['id_estado']; ?>">
                            <?php echo htmlspecialchars($estado['nombre_estado']); ?>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </form>
</div>