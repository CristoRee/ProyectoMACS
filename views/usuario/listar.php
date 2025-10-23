<div class="container mt-4">
    <h2 class="pb-2 border-bottom mb-4">Gestión de Usuarios</h2>
    <p>Lista de todos los usuarios registrados en el sistema.</p>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre de Usuario</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todosLosUsuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id_usuario']); ?></td>
                    <td><?= htmlspecialchars($usuario['nombre_usuario']); ?></td>
                    <td><?= htmlspecialchars($usuario['email']); ?></td>
                    <td><?= htmlspecialchars($usuario['telefono'] ?? 'No especificado'); ?></td>
                    <td><?= htmlspecialchars($usuario['nombre_rol']); ?></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" 
                                data-id="<?= $usuario['id_usuario'] ?>" 
                                data-nombre="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" 
                                data-email="<?= htmlspecialchars($usuario['email']) ?>" 
                                data-telefono="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"
                                data-rol="<?= $usuario['id_rol'] ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>

                        <?php  ?>
                        <?php if ($usuario['nombre_rol'] !== 'Administrador'): ?>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal"
                                data-id="<?= $usuario['id_usuario'] ?>"
                                data-nombre="<?= htmlspecialchars($usuario['nombre_usuario']) ?>">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                        <?php endif; ?>
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
        <h5 class="modal-title" id="editarUsuarioModalLabel">Editar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="index.php?accion=actualizarUsuario">
        <div class="modal-body">
          <input type="hidden" name="id_usuario" id="edit-id-usuario">
          
          <div class="mb-3">
            <label for="edit-nombre" class="form-label">Nombre de Usuario</label>
            <input type="text" class="form-control" id="edit-nombre" name="nombre_usuario" required>
          </div>
          <div class="mb-3">
            <label for="edit-email" class="form-label">Email</label>
            <input type="email" class="form-control" id="edit-email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="edit-telefono" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="edit-telefono" name="telefono">
          </div>
          <div class="mb-3">
            <label for="edit-rol" class="form-label">Rol</label>
            <select class="form-select" id="edit-rol" name="id_rol" required>
              <option value="1">Administrador</option>
              <option value="2">Técnico</option>
              <option value="3">Cliente</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="eliminarUsuarioModal" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarUsuarioModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que quieres eliminar al usuario <strong id="delete-nombre-usuario"></strong>?</p>
        <p class="text-danger">Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="index.php?accion=eliminarUsuario">
          <input type="hidden" name="id_usuario" id="delete-id-usuario">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, cancelar</button>
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
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
    .table .table-dark th {
    background-color: #013467ff;  
    color: #ffffff;             
    border-color: #32383e;      
}
</style>