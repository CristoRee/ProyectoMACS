<div class="container mt-4">
    <h2 class="pb-2 border-bottom mb-4">Mis Tickets Asignados</h2>
    <p>Estos son los trabajos de reparación que tienes a tu cargo.</p>

    <?php $vista_actual = $_GET['vista'] ?? 'activos'; ?>
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="index.php?accion=misTickets&vista=activos" class="btn <?php echo $vista_actual === 'activos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Tickets Activos
            </a>
            <a href="index.php?accion=misTickets&vista=finalizados" class="btn <?php echo $vista_actual === 'finalizados' ? 'btn-primary' : 'btn-outline-primary'; ?>">
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
                    <th>Problema Reportado</th>
                    <th>Estado Actual</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($misTickets)): ?>
                    <?php foreach ($misTickets as $ticket): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ticket['nombre_cliente']); ?></td>
                        <td><?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca'] . ' ' . $ticket['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($ticket['descripcion_problema']); ?></td>
                        <td>
                            <span class="badge" style="background-color: <?php echo htmlspecialchars($ticket['estado_color']); ?> !important; font-size: 0.9rem;">
                                <?php echo htmlspecialchars($ticket['nombre_estado']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($vista_actual === 'activos'): ?>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editarTicketModal"
                                        data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                        data-estado-actual-id="<?php echo $ticket['id_estado']; ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                
                                <button type="button" class="btn btn-sm btn-success" onclick="abrirChat(<?php echo $ticket['id_ticket']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Chatear con el cliente">
                                    <i class="fas fa-comments"></i>
                                </button>
                            <?php else: ?>
                                <span class="text-muted">No hay acciones.</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No tienes tickets en esta vista.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="editarTicketModal" tabindex="-1" aria-labelledby="editarTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditarTicket" method="POST" action="index.php">
                <input type="hidden" name="accion" value="actualizarTicketEstado">

                <div class="modal-header">
                    <h5 class="modal-title" id="editarTicketModalLabel">Editar Estado del Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_ticket" id="modal_id_ticket">
                    <div class="mb-3">
                        <label for="modal_estado" class="form-label">Cambiar Estado a:</label>
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
                    <button type="button" id="confirmar-editar-btn" class="btn btn-primary">Aplicar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="finalizarTicketModal" tabindex="-1" aria-hidden="true">
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const editarTicketModalEl = document.getElementById('editarTicketModal');
    const finalizarTicketModal = new bootstrap.Modal(document.getElementById('finalizarTicketModal'));
    const formEditarTicket = document.getElementById('formEditarTicket');
    
    const ID_ESTADO_FINALIZADO = 7;

    if (editarTicketModalEl) {
        editarTicketModalEl.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id_ticket = button.getAttribute('data-ticket-id');
            const estado_actual_id = button.getAttribute('data-estado-actual-id');
            document.getElementById('modal_id_ticket').value = id_ticket;
            document.getElementById('modal_estado').value = estado_actual_id;
        });
    }
    
    document.getElementById('confirmar-editar-btn').addEventListener('click', function() {
        const selectEstado = document.getElementById('modal_estado');
        const estadoSeleccionadoId = parseInt(selectEstado.value);

        if (estadoSeleccionadoId === ID_ESTADO_FINALIZADO) {
        
            if (localStorage.getItem('noMostrarAvisoFinalizar') === 'true') {
                formEditarTicket.submit(); 
            } else {
                bootstrap.Modal.getInstance(editarTicketModalEl).hide();
                finalizarTicketModal.show(); 
            }
        } else {
            formEditarTicket.submit(); 
        }
    });

   
    document.getElementById('confirmar-finalizar-btn').addEventListener('click', function() {
        if (document.getElementById('noVolverAMostrarFinalizar').checked) {
            localStorage.setItem('noMostrarAvisoFinalizar', 'true');
        }
        formEditarTicket.submit(); 
    });
});
</script>