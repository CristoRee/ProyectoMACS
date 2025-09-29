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
                        
                        <button type="button" class="btn btn-sm btn-success" onclick="abrirChat(<?php echo $ticket['id_ticket']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Chatear con el cliente">
                            <i class="fas fa-comments"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($misTickets)): ?>
                <tr>
                    <td colspan="5" class="text-center">No tienes tickets asignados.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editarTicketModal" tabindex="-1" aria-labelledby="editarTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarTicket" method="POST" action="index.php?accion=actualizarTicketEstado">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTicketModalLabel">Editar Estado del Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                      <input type="hidden" name="id_ticket" id="modal_id_ticket">
                                <div class="mb-3">
                                    <label for="modal_estado" class="form-label">Estado</label>
                                    <select class="form-select" name="id_estado" id="modal_estado" required>
                                        <option value="">Seleccione un estado</option>
                                        <?php foreach ($todosLosEstados as $estado): ?>
                                            <option value="<?php echo $estado['id_estado']; ?>"><?php echo htmlspecialchars($estado['nombre_estado']); ?></option>
                                        <?php endforeach; ?>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var editarTicketModal = document.getElementById('editarTicketModal');
    if (editarTicketModal) {
        editarTicketModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var id_ticket = button.getAttribute('data-ticket-id');
            var estado_actual_id = button.getAttribute('data-estado-actual-id');
            document.getElementById('modal_id_ticket').value = id_ticket;
            document.getElementById('modal_estado').value = estado_actual_id;
        });
    }
});
</script>