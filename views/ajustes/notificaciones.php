<div class="container my-5">
    <h2 class="pb-2 border-bottom mb-4">Configuración de Notificaciones</h2>
    <p class="text-muted">Configura qué cambios de estado de ticket generan notificaciones por email a los clientes</p>
    
    <?php if(isset($_GET['status']) && $_GET['status'] === 'success'): ?>
        <div class="alert alert-success">Configuración guardada correctamente</div>
    <?php endif; ?>

    <form action="index.php?accion=guardarAjustesNotificaciones" method="POST">
        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Estados de Ticket</strong>
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
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
</div>