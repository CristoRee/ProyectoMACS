<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-users me-2 text-primary"></i>Gestión de Usuarios
        </h2>
        <div class="badge bg-info fs-6">
            <i class="fas fa-user-friends me-1"></i>
            Total de usuarios: <?php echo $totalRecords ?? count($todosLosUsuarios); ?>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <p class="card-text text-muted mb-0">Lista de usuarios registrados en el sistema</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive" style="margin-bottom: 60px;">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" style="width: 60px;">
                                <i class="fas fa-hashtag"></i> ID
                            </th>
                            <th>
                                <i class="fas fa-user me-1"></i>Usuario
                            </th>
                            <th>
                                <i class="fas fa-envelope me-1"></i>Email
                            </th>
                            <th>
                                <i class="fas fa-phone me-1"></i>Teléfono
                            </th>
                            <th class="text-center">
                                <i class="fas fa-user-tag me-1"></i>Rol
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-cogs me-1"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosLosUsuarios as $usuario): ?>
                        <tr class="align-middle">
                            <td class="text-center fw-bold">
                                <span class="badge bg-light text-dark"><?= htmlspecialchars($usuario['id_usuario']); ?></span>
                            </td>
                            <td class="fw-semibold">
                                <i class="fas fa-user-circle me-2 text-primary"></i>
                                <?= htmlspecialchars($usuario['nombre_usuario']); ?>
                            </td>
                            <td class="text-muted">
                                <i class="fas fa-at me-1"></i>
                                <?= htmlspecialchars($usuario['email']); ?>
                            </td>
                            <td class="text-muted">
                                <i class="fas fa-phone me-1"></i>
                                <?= htmlspecialchars($usuario['telefono'] ?? __('not_specified')); ?>
                            </td>
                            <td class="text-center">
                                <?php 
                                $rolClass = match($usuario['nombre_rol']) {
                                    'Administrador' => 'danger',
                                    'Técnico' => 'warning', 
                                    'Cliente' => 'info',
                                    default => 'secondary'
                                };
                                ?>
                                <span class="badge bg-<?= $rolClass ?> fs-6">
                                    <?= htmlspecialchars($usuario['nombre_rol']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" data-bs-target="#editarUsuarioModal" 
                                            data-id="<?= $usuario['id_usuario'] ?>" 
                                            data-nombre="<?= htmlspecialchars($usuario['nombre_usuario']) ?>" 
                                            data-email="<?= htmlspecialchars($usuario['email']) ?>" 
                                            data-telefono="<?= htmlspecialchars($usuario['telefono'] ?? '') ?>"
                                            data-rol="<?= $usuario['id_rol'] ?>"
                                            title="Editar usuario"
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if ($usuario['nombre_rol'] !== 'Administrador'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal"
                                            data-id="<?= $usuario['id_usuario'] ?>"
                                            data-nombre="<?= htmlspecialchars($usuario['nombre_usuario']) ?>"
                                            title="Eliminar usuario"
                                            data-bs-toggle="tooltip">
                                        <i class="fas fa-trash-alt"></i>
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
    </div>
    
    <!-- Paginación -->
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <?php include 'views/includes/pagination.php'; ?>
    <?php endif; ?>
    
    <!-- Espaciador para evitar el chat -->
    <div style="height: 60px;"></div>
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
            <label for="edit-nombre" class="form-label">Usuario</label>
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
          <button type="submit" class="btn btn-primary">Guardar</button>
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
        <p>¿Está seguro de eliminar al usuario <strong id="delete-nombre-usuario"></strong>?</p>
        <p class="text-danger">Esta acción no se puede deshacer</p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="index.php?accion=eliminarUsuario">
          <input type="hidden" name="id_usuario" id="delete-id-usuario">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Cancelar</button>
          <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
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
    
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
/* Estilos personalizados para gestión de usuarios */
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
    border-top: none;
}

.table-primary th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}

/* Animación de carga */
.table tbody tr {
    animation: fadeInUp 0.5s ease;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Mejoras responsive */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-bottom: 2px;
    }
}
</style>