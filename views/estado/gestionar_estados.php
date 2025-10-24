<div class="container my-5">
    <h2 class="pb-2 border-bottom"><?php echo __('manage_ticket_states'); ?></h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><?php echo __('state_name'); ?></th>
                    <th><?php echo __('color_sample'); ?></th>
                    <th><?php echo __('actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estados as $estado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($estado['nombre_estado']); ?></td>
                    <td>
                        <span class="badge" style="background-color: <?php echo htmlspecialchars($estado['color']); ?>; font-size: 1rem; padding: 0.5em 1em;">
                            <?php echo __('example'); ?>
                        </span>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarEstadoModal"
                                    data-id="<?php echo $estado['id_estado']; ?>"
                                    data-nombre="<?php echo htmlspecialchars($estado['nombre_estado']); ?>"
                                    data-color="<?php echo htmlspecialchars($estado['color']); ?>">
                                <i class="fas fa-edit"></i> <?php echo __('edit'); ?>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editarEstadoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo __('edit_state'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __('close'); ?>"></button>
      </div>
      <form action="index.php?accion=actualizarEstado" method="POST">
        <div class="modal-body">
            <input type="hidden" name="id_estado" id="edit-id-estado">
            <div class="mb-3">
                <label for="edit-nombre-estado" class="form-label"><?php echo __('state_name'); ?></label>
                <input type="text" class="form-control" id="edit-nombre-estado" name="nombre_estado" required>
            </div>
            <div class="mb-3">
                <label for="edit-color" class="form-label"><?php echo __('state_color'); ?></label>
                <input type="color" class="form-control form-control-color" id="edit-color" name="color" title="<?php echo __('choose_color'); ?>">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('cancel'); ?></button>
          <button type="submit" class="btn btn-primary"><?php echo __('save_changes'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editarEstadoModal = document.getElementById('editarEstadoModal');
    editarEstadoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const color = button.getAttribute('data-color');
        
        document.getElementById('edit-id-estado').value = id;
        document.getElementById('edit-nombre-estado').value = nombre;
        document.getElementById('edit-color').value = color;
    });
});
</script>