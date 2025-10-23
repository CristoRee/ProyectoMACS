<div class="container my-5">
    <h2 class="pb-2 border-bottom">Gestionar Estados de Tickets</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nombre del Estado</th>
                    <th>Color de Muestra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estados as $estado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($estado['nombre_estado']); ?></td>
                    <td>
                        <span class="badge" style="background-color: <?php echo htmlspecialchars($estado['color']); ?>; font-size: 1rem; padding: 0.5em 1em;">
                            Ejemplo
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarEstadoModal"
                                data-id="<?php echo $estado['id_estado']; ?>"
                                data-nombre="<?php echo htmlspecialchars($estado['nombre_estado']); ?>"
                                data-color="<?php echo htmlspecialchars($estado['color']); ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>
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