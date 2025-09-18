<div class="container mt-4">
    <h2 class="pb-2 border-bottom mb-4">Mis Tickets Asignados</h2>
    <p>Estos son los trabajos de reparación que tienes a tu cargo.</p>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Dispositivo</th>
                    <th>Problema Reportado</th>
                    <th>Estado Actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($misTickets as $ticket): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ticket['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca'] . ' ' . $ticket['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['descripcion_problema']); ?></td>
                    <td><span class="badge bg-primary"><?php echo htmlspecialchars($ticket['nombre_estado']); ?></span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editarTicketModal"
                                data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                data-cliente="<?php echo htmlspecialchars($ticket['nombre_cliente']); ?>"
                                data-dispositivo="<?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca']); ?>"
                                data-problema="<?php echo htmlspecialchars($ticket['descripcion_problema']); ?>"
                                data-estado-actual-id="<?php echo $ticket['id_estado']; ?>">
                            <i class="fas fa-edit"></i> Editar
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($misTickets)): ?>
                <tr>
                    <td colspan="6" class="text-center">No tienes tickets asignados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editarTicketModal" tabindex="-1" aria-labelledby="editarTicketModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarTicketModalLabel">Actualizar Ticket #<span id="modal-ticket-id"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="index.php?accion=actualizarTicketEstado">
        <div class="modal-body">
          <input type="hidden" name="id_ticket" id="form-ticket-id">
          
          <p><strong>Cliente:</strong> <span id="modal-cliente"></span></p>
          <p><strong>Dispositivo:</strong> <span id="modal-dispositivo"></span></p>
          <p><strong>Problema:</strong> <span id="modal-problema"></span></p>
          <hr>
          <div class="mb-3">
            <label for="form-estado-id" class="form-label"><strong>Cambiar Estado a:</strong></label>
            <select class="form-select" name="id_estado" id="form-estado-id" required>
              <?php foreach ($todosLosEstados as $estado): ?>
                <option value="<?php echo $estado['id_estado']; ?>"><?php echo htmlspecialchars($estado['nombre_estado']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Aplicar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editarTicketModal = document.getElementById('editarTicketModal');
    editarTicketModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        
        
        const ticketId = button.getAttribute('data-ticket-id');
        const cliente = button.getAttribute('data-cliente');
        const dispositivo = button.getAttribute('data-dispositivo');
        const problema = button.getAttribute('data-problema');
        const estadoActualId = button.getAttribute('data-estado-actual-id');
        
        
        document.getElementById('modal-ticket-id').textContent = ticketId;
        document.getElementById('form-ticket-id').value = ticketId;
        document.getElementById('modal-cliente').textContent = cliente;
        document.getElementById('modal-dispositivo').textContent = dispositivo;
        document.getElementById('modal-problema').textContent = problema;
        
        
        document.getElementById('form-estado-id').value = estadoActualId;
    });
});
</script>