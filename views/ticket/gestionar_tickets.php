<div class="container mt-4">
    <h2 class="pb-2 border-bottom mb-4">Gestionar Todos los Tickets</h2>
    <p>Asigna técnicos a los tickets de los clientes.</p>

    <?php
    $vista_actual = $_GET['vista'] ?? 'activos'; 
?>
<div class="d-flex justify-content-end mb-3">
    <div class="btn-group">
        <a href="?accion=<?php echo $_GET['accion']; ?>&vista=activos" class="btn <?php echo $vista_actual === 'activos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
            Tickets Activos
        </a>
        <a href="?accion=<?php echo $_GET['accion']; ?>&vista=finalizados" class="btn <?php echo $vista_actual === 'finalizados' ? 'btn-primary' : 'btn-outline-primary'; ?>">
            Tickets Finalizados
        </a>
    </div>
</div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Dispositivo</th>
                    <th>Estado</th>
                    <th>Técnico Asignado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($todosLosTickets as $ticket): ?>
                <tr>
                    <td><?php echo htmlspecialchars($ticket['nombre_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca']); ?></td>
                    <td><span class="badge" style="background-color: <?php echo htmlspecialchars($ticket['estado_color']); ?> !important;"><?php echo htmlspecialchars($ticket['nombre_estado']); ?></span></td>
                    <td>
                        <?php if ($ticket['nombre_tecnico']): ?>
                            <span class="badge bg-success"><?php echo htmlspecialchars($ticket['nombre_tecnico']); ?></span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Sin asignar</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#asignarTecnicoModal"
                                data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                data-tecnico-actual-id="<?php echo $ticket['id_tecnico_asignado'] ?? ''; ?>">
                            <i class="fas fa-user-plus"></i> Asignar
                        </button>
                        
                        <?php if ($ticket['id_tecnico_asignado']): ?>
                        <button type="button" class="btn btn-sm btn-info" onclick="abrirChat(<?php echo $ticket['id_ticket']; ?>, 'tecnico')" data-bs-toggle="tooltip" data-bs-placement="top" title="Chat Privado con Técnico">
                            <i class="fas fa-headset"></i>
                        </button>
                        <?php endif; ?>
                         <a href="index.php?accion=verHistorial&id_ticket=<?php echo $ticket['id_ticket']; ?>" class="btn btn-sm btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Ver historial del ticket">
                            <i class="fas fa-history"></i>
                         </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="asignarTecnicoModal" tabindex="-1" aria-labelledby="asignarTecnicoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asignarTecnicoModalLabel">Asignar Técnico al Ticket #<span id="modal-ticket-id"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="index.php?accion=asignarTecnico">
        <div class="modal-body">
          <input type="hidden" name="id_ticket" id="form-ticket-id">
          <div class="mb-3">
            <label for="form-tecnico-id" class="form-label"><strong>Seleccionar Técnico:</strong></label>
            <select class="form-select" name="id_tecnico" id="form-tecnico-id">
              <option value="">-- Sin asignar --</option>
              <?php foreach ($listaDeTecnicos as $tecnico): ?>
                <option value="<?php echo $tecnico['id_usuario']; ?>"><?php echo htmlspecialchars($tecnico['nombre_usuario']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar Asignación</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const asignarTecnicoModal = document.getElementById('asignarTecnicoModal');
    asignarTecnicoModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const ticketId = button.getAttribute('data-ticket-id');
        const tecnicoActualId = button.getAttribute('data-tecnico-actual-id');
        
        document.getElementById('modal-ticket-id').textContent = ticketId;
        document.getElementById('form-ticket-id').value = ticketId;
        document.getElementById('form-tecnico-id').value = tecnicoActualId;
    });
});
</script>