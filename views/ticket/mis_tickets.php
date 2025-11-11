<div class="container mt-4">
    <h2 class="pb-2 border-bottom mb-4"><?php echo __('my_assigned_tickets'); ?></h2>
    <p><?php echo __('repair_jobs_assigned'); ?></p>

    <?php $vista_actual = $_GET['vista'] ?? 'activos'; ?>
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="index.php?accion=misTickets&vista=activos" class="btn <?php echo $vista_actual === 'activos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                <?php echo __('active_tickets'); ?>
            </a>
            <a href="index.php?accion=misTickets&vista=finalizados" class="btn <?php echo $vista_actual === 'finalizados' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                <?php echo __('finished_tickets'); ?>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th><?php echo __('client'); ?></th>
                    <th><?php echo __('device'); ?></th>
                    <th><?php echo __('reported_problem'); ?></th>
                    <th><?php echo __('current_status'); ?></th>
                    <th><?php echo __('actions'); ?></th>
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
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-success" 
                                        data-bs-toggle="modal" data-bs-target="#verTicketModal"
                                        data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                        data-cliente="<?php echo htmlspecialchars($ticket['nombre_cliente']); ?>"
                                        data-tecnico="<?php echo htmlspecialchars($_SESSION['usuario']); ?>"
                                        data-dispositivo="<?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca'] . ' ' . $ticket['modelo']); ?>"
                                        data-problema="<?php echo htmlspecialchars($ticket['descripcion_problema']); ?>"
                                        data-fotos="<?php echo htmlspecialchars($ticket['fotos'] ?? ''); ?>"
                                        title="<?php echo __('view_ticket'); ?>" data-bs-toggle="tooltip">
                                    <i class="fas fa-eye"></i>
                                </button>
                                
                                <?php if ($vista_actual === 'activos'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editarTicketModal"
                                            data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                            data-estado-actual-id="<?php echo $ticket['id_estado']; ?>"
                                            title="<?php echo __('edit_status'); ?>" data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="abrirChat(<?php echo $ticket['id_ticket']; ?>)" 
                                            title="<?php echo __('chat_with_client'); ?>" data-bs-toggle="tooltip">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center"><?php echo __('no_tickets_to_show'); ?></td>
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
                    <h5 class="modal-title" id="editarTicketModalLabel"><?php echo __('edit_ticket_state'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __('close'); ?>"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_ticket" id="modal_id_ticket">
                    <div class="mb-3">
                        <label for="modal_estado" class="form-label"><?php echo __('change_status_to'); ?>:</label>
                        <select class="form-select" name="id_estado" id="modal_estado" required>
                            <option value=""><?php echo __('select_status'); ?>...</option>
                            <?php foreach ($todosLosEstados as $estado): ?>
                                <option value="<?php echo $estado['id_estado']; ?>"><?php echo htmlspecialchars($estado['nombre_estado']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('cancel'); ?></button>
                    <button type="button" id="confirmar-editar-btn" class="btn btn-primary"><?php echo __('apply_changes'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="finalizarTicketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo __('finalize_ticket_warning'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo __('close'); ?>"></button>
            </div>
            <div class="modal-body">
                <p><?php echo __('finalize_ticket_message'); ?></p>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="noVolverAMostrarFinalizar">
                    <label class="form-check-label" for="noVolverAMostrarFinalizar">
                        <?php echo __('dont_show_again'); ?>
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('cancel'); ?></button>
                <button type="button" class="btn btn-warning" id="confirmar-finalizar-btn"><?php echo __('yes_finalize'); ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verTicketModal" tabindex="-1" aria-labelledby="verTicketModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verTicketModalLabel">Detalles del Ticket #<span id="modal-ver-id"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <h5><i class="fas fa-user me-2"></i>Información del Cliente</h5>
                <p><strong>Cliente:</strong> <span id="modal-ver-cliente"></span></p>
                <p><strong>Técnico Asignado:</strong> <span id="modal-ver-tecnico"></span></p>
                <hr>
                <h5><i class="fas fa-laptop me-2"></i>Información del Dispositivo</h5>
                <p><strong>Dispositivo:</strong> <span id="modal-ver-dispositivo"></span></p>
                <p><strong>Problema Reportado:</strong></p>
                <p class="text-muted" style="white-space: pre-wrap;" id="modal-ver-problema"></p>
            </div>
            <div class="col-md-6">
                <h5><i class="fas fa-images me-2"></i>Fotos Adjuntas</h5>
                <div id="modal-ver-fotos" class="row row-cols-2 g-2">
                    </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    const editarTicketModalEl = document.getElementById('editarTicketModal');
    const finalizarTicketModalEl = document.getElementById('finalizarTicketModal');
    if (!finalizarTicketModalEl) {
        console.error('El modal de finalizar no se encontró.');
        return;
    }
    const finalizarTicketModal = new bootstrap.Modal(finalizarTicketModalEl);
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
    
    // Asegurarse de que el botón exista antes de añadir el listener
    const confirmarEditarBtn = document.getElementById('confirmar-editar-btn');
    if (confirmarEditarBtn) {
        confirmarEditarBtn.addEventListener('click', function() {
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
    }

    // Asegurarse de que el botón exista antes de añadir el listener
    const confirmarFinalizarBtn = document.getElementById('confirmar-finalizar-btn');
    if (confirmarFinalizarBtn) {
        confirmarFinalizarBtn.addEventListener('click', function() {
            if (document.getElementById('noVolverAMostrarFinalizar').checked) {
                localStorage.setItem('noMostrarAvisoFinalizar', 'true');
            }
            formEditarTicket.submit(); 
        });
    }

    const verTicketModal = document.getElementById('verTicketModal');
    if (verTicketModal) {
        verTicketModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('modal-ver-id').textContent = button.getAttribute('data-ticket-id');
            document.getElementById('modal-ver-cliente').textContent = button.getAttribute('data-cliente');
            document.getElementById('modal-ver-tecnico').textContent = button.getAttribute('data-tecnico');
            document.getElementById('modal-ver-dispositivo').textContent = button.getAttribute('data-dispositivo');
            document.getElementById('modal-ver-problema').textContent = button.getAttribute('data-problema');
            
            const fotosContainer = document.getElementById('modal-ver-fotos');
            fotosContainer.innerHTML = '';
            const fotosString = button.getAttribute('data-fotos');
            
            if (fotosString && fotosString !== "null") {
                const fotosArray = fotosString.split(',');
                fotosArray.forEach(url_imagen => {
                    const col = document.createElement('div');
                    col.className = 'col';
                    col.innerHTML = `
                        <a href="${url_imagen}" target="_blank">
                            <img src="${url_imagen}" class="img-thumbnail" alt="Foto del ticket" style="width: 100%; height: 150px; object-fit: cover;">
                        </a>`;
                    fotosContainer.appendChild(col);
                });
            } else {
                fotosContainer.innerHTML = '<p class="text-muted">El cliente no adjuntó fotos.</p>';
            }
        });
    }
});
</script>

<style>
    .table .table-dark th {
    background-color: #013467ff;  
    color: #ffffff;             
    border-color: #32383e;      
}
</style>

<?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php include 'views/includes/pagination.php'; ?>
<?php endif; ?>