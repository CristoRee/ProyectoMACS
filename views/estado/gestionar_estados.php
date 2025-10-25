<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-flag me-2 text-primary"></i>Gestionar Estados de Tickets
        </h2>
        <div class="badge bg-info fs-6">
            <i class="fas fa-palette me-1"></i>
            Estados: <?php echo count($estados); ?>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text text-muted mb-0">Gestiona los estados de los tickets del sistema</p>
                        <a href="index.php?accion=crearEstado" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>Agregar Estado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th>
                                <i class="fas fa-tag me-1"></i>Nombre del Estado
                            </th>
                            <th class="text-center">
                                <i class="fas fa-palette me-1"></i>Color de Muestra
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="fas fa-cogs me-1"></i>Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($estados as $estado): ?>
                        <tr class="align-middle">
                            <td class="fw-semibold">
                                <i class="fas fa-circle me-2" style="color: <?php echo htmlspecialchars($estado['color']); ?>"></i>
                                <?php echo htmlspecialchars($estado['nombre_estado']); ?>
                            </td>
                            <td class="text-center">
                                <span class="badge fs-6 px-4 py-2" style="background-color: <?php echo htmlspecialchars($estado['color']); ?>;">
                                    <i class="fas fa-eye me-1"></i>Vista previa
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#editarEstadoModal"
                                        data-id="<?php echo $estado['id_estado']; ?>"
                                        data-nombre="<?php echo htmlspecialchars($estado['nombre_estado']); ?>"
                                        data-color="<?php echo htmlspecialchars($estado['color']); ?>"
                                        title="Editar estado"
                                        data-bs-toggle="tooltip">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editarEstadoModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar Estado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="index.php?accion=actualizarEstado" method="POST">
        <div class="modal-body">
            <input type="hidden" name="id_estado" id="edit-id-estado">
            <div class="mb-3">
                <label for="edit-nombre-estado" class="form-label">Nombre del Estado</label>
                <input type="text" class="form-control" id="edit-nombre-estado" name="nombre_estado" required>
            </div>
            <div class="mb-3">
                <label for="edit-color" class="form-label">Color del Estado</label>
                <input type="color" class="form-control form-control-color" id="edit-color" name="color" title="Elige un color">
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

<style>
/* Estilos personalizados para gestión de estados */
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

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
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

/* Círculos de color más visibles */
.fas.fa-circle {
    filter: drop-shadow(0 0 2px rgba(0,0,0,0.3));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
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