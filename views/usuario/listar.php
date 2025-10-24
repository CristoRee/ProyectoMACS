<div class="container mt-4">
    <h2 class="pb-2 border-bottom mb-4"><?php echo __('user_management'); ?></h2>
    <p><?php echo __('registered_users_list'); ?></p>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th><?php echo __('user'); ?></th>
                    <th><?php echo __('email'); ?></th>
                    <th><?php echo __('phone'); ?></th>
                    <th><?php echo __('role'); ?></th>
                    <th><?php echo __('actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todosLosUsuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                    <td><?= htmlspecialchars($usuario['nombre_usuario']); ?></td>
                    <td><?= htmlspecialchars($usuario['email']); ?></td>
                    <td><?= htmlspecialchars($usuario['telefono'] ?? __('not_specified')); ?></td>
                    <td><?= htmlspecialchars($usuario['nombre_rol']); ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" 
                                    data-id="<?= $usuario['id_usuario'] ?>" 
                                    data-nombre="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" 
                                    data-email="<?= htmlspecialchars($usuario['email']) ?>" 
                                    data-telefono="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"
                                    data-rol="<?= $usuario['id_rol'] ?>">
                                <i class="fas fa-edit"></i> <?php echo __('edit'); ?>
                            </button>

                            <?php if ($usuario['nombre_rol'] !== __('administrator')): ?>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal"
                                    data-id="<?= $usuario['id_usuario'] ?>"
                                    data-nombre="<?= htmlspecialchars($usuario['nombre_usuario']) ?>">
                                <i class="fas fa-trash"></i> <?php echo __('delete'); ?>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarUsuarioModalLabel"><?php echo __('edit_user'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __('close'); ?>"></button>
      </div>
      <form method="POST" action="index.php?accion=actualizarUsuario">
        <div class="modal-body">
          <input type="hidden" name="id_usuario" id="edit-id-usuario">
          
          <div class="mb-3">
            <label for="edit-nombre" class="form-label"><?php echo __('user'); ?></label>
            <input type="text" class="form-control" id="edit-nombre" name="nombre_usuario" required>
          </div>
          <div class="mb-3">
            <label for="edit-email" class="form-label"><?php echo __('email'); ?></label>
            <input type="email" class="form-control" id="edit-email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="edit-telefono" class="form-label"><?php echo __('phone'); ?></label>
            <input type="tel" class="form-control" id="edit-telefono" name="telefono">
          </div>
          <div class="mb-3">
            <label for="edit-rol" class="form-label"><?php echo __('role'); ?></label>
            <select class="form-select" id="edit-rol" name="id_rol" required>
              <option value="1"><?php echo __('administrator'); ?></option>
              <option value="2"><?php echo __('technician'); ?></option>
              <option value="3"><?php echo __('client'); ?></option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('cancel'); ?></button>
          <button type="submit" class="btn btn-primary"><?php echo __('save'); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarUsuarioModalLabel"><?php echo __('confirm_user_deletion'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __('close'); ?>"></button>
      </div>
      <div class="modal-body">
        <p><?php echo __('sure_delete_user'); ?> <strong id="delete-nombre-usuario"></strong>?</p>
        <p class="text-danger"><?php echo __('action_cannot_undone'); ?></p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="index.php?accion=eliminarUsuario">
          <input type="hidden" name="id_usuario" id="delete-id-usuario">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('no_cancel'); ?></button>
          <button type="submit" class="btn btn-danger"><?php echo __('yes_delete'); ?></button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const editarUsuarioModal = document.getElementById('editarUsuarioModal');
    editarUsuarioModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; 
        
        
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const email = button.getAttribute('data-email');
        const telefono = button.getAttribute('data-telefono');
        const rol = button.getAttribute('data-rol');
        
        
        document.getElementById('edit-id-usuario').value = id;
        document.getElementById('edit-nombre').value = nombre;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-telefono').value = telefono;
        document.getElementById('edit-rol').value = rol;
    });

    
    const eliminarUsuarioModal = document.getElementById('eliminarUsuarioModal');
    eliminarUsuarioModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        
        
        document.getElementById('delete-id-usuario').value = id;
        document.getElementById('delete-nombre-usuario').textContent = nombre;
    });
});
</script>

<style>
<<<<<<< HEAD
/* Estilos específicos para arreglar alineación de botones */
.table td {
    vertical-align: middle !important;
}

.table .btn-group {
    display: flex !important;
    gap: 0.25rem !important;
    align-items: center !important;
}

.table .btn-group .btn {
    margin: 0 !important;
    flex-shrink: 0 !important;
=======
    .table .table-dark th {
    background-color: #013467ff;  
    color: #ffffff;             
    border-color: #32383e;      
>>>>>>> 425b2cb9f01fd18887e132bb99b40d0650e5b1f9
}
</style>