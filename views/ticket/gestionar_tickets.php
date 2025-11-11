<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-ticket-alt me-2 text-primary"></i><?php echo __('manage_all_tickets'); ?>
        </h2>
        <div class="badge bg-info fs-6">
            <i class="fas fa-clipboard-list me-1"></i>
            Total: <?php echo $totalRecords ?? count($todosLosTickets); ?>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text text-muted mb-0"><?php echo __('assign_technicians_desc'); ?></p>
                        <div class="btn-group">
                            <a href="index.php?accion=gestionarTickets&vista=activos" class="btn <?php echo $vista === 'activos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                <i class="fas fa-play-circle me-1"></i><?php echo __('active_tickets'); ?>
                            </a>
                            <a href="index.php?accion=gestionarTickets&vista=finalizados" class="btn <?php echo $vista === 'finalizados' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                <i class="fas fa-check-circle me-1"></i><?php echo __('finished_tickets'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th><i class="fas fa-user me-1"></i><?php echo __('client'); ?></th>
                            <th><i class="fas fa-laptop me-1"></i><?php echo __('device'); ?></th>
                            <th class="text-center"><i class="fas fa-flag me-1"></i><?php echo __('state'); ?></th>
                            <th class="text-center"><i class="fas fa-user-cog me-1"></i><?php echo __('assigned_technician'); ?></th>
                            <th class="text-center" style="width: 220px;"><i class="fas fa-cogs me-1"></i><?php echo __('actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($todosLosTickets as $ticket): ?>
                        <tr class="align-middle">
                            <td class="fw-semibold">
                                <i class="fas fa-user-circle me-2 text-primary"></i>
                                <?php echo htmlspecialchars($ticket['nombre_cliente']); ?>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-desktop me-2 text-info"></i>
                                    <span><?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca'] . ' ' . $ticket['modelo']); ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge fs-6" style="background-color: <?php echo htmlspecialchars($ticket['estado_color']); ?> !important;">
                                    <?php echo htmlspecialchars($ticket['nombre_estado']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($ticket['nombre_tecnico']): ?>
                                    <span class="badge bg-primary fs-6">
                                        <i class="fas fa-user-check me-1"></i>
                                        <?php echo htmlspecialchars($ticket['nombre_tecnico']); ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary fs-6">
                                        <i class="fas fa-user-times me-1"></i>
                                        <?php echo __('unassigned'); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            data-bs-toggle="modal" data-bs-target="#verTicketModal"
                                            data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                            data-cliente="<?php echo htmlspecialchars($ticket['nombre_cliente']); ?>"
                                            data-tecnico="<?php echo htmlspecialchars($ticket['nombre_tecnico'] ?? 'Sin asignar'); ?>"
                                            data-dispositivo="<?php echo htmlspecialchars($ticket['tipo_producto'] . ' ' . $ticket['marca'] . ' ' . $ticket['modelo']); ?>"
                                            data-problema="<?php echo htmlspecialchars($ticket['descripcion_problema']); ?>"
                                            data-fotos="<?php echo htmlspecialchars($ticket['fotos'] ?? ''); ?>"
                                            title="<?php echo __('view_ticket'); ?>" data-bs-toggle="tooltip">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    <?php if ($vista === 'activos'): ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            data-bs-toggle="modal" data-bs-target="#asignarTecnicoModal"
                                            data-ticket-id="<?php echo $ticket['id_ticket']; ?>"
                                            data-tecnico-actual-id="<?php echo $ticket['id_tecnico_asignado'] ?? ''; ?>"
                                            title="<?php echo __('assign'); ?> técnico" data-bs-toggle="tooltip">
                                        <i class="fas fa-user-plus"></i>
                                    </button>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-success" 
                                            onclick="abrirChat(<?php echo $ticket['id_ticket']; ?>, 'ticket')" 
                                            title="<?php echo __('public_chat'); ?>" data-bs-toggle="tooltip">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                    
                                    <?php if ($ticket['id_tecnico_asignado']): ?>
                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                            onclick="abrirChat(<?php echo $ticket['id_ticket']; ?>, 'tecnico')" 
                                            title="<?php echo __('private_chat_technician'); ?>" data-bs-toggle="tooltip">
                                        <i class="fas fa-headset"></i>
                                    </button>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <a href="index.php?accion=verHistorial&id_ticket=<?php echo $ticket['id_ticket']; ?>" 
                                       class="btn btn-sm btn-outline-secondary" 
                                       title="<?php echo __('view_ticket_history'); ?>" data-bs-toggle="tooltip">
                                        <i class="fas fa-history"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="asignarTecnicoModal" tabindex="-1" aria-labelledby="asignarTecnicoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asignarTecnicoModalLabel"><?php echo __('assign_technician_ticket'); ?> #<span id="modal-ticket-id"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="index.php?accion=asignarTecnico">
        <div class="modal-body">
          <input type="hidden" name="id_ticket" id="form-ticket-id">
          <div class="mb-3">
            <label for="form-tecnico-id" class="form-label"><strong><?php echo __('select_technician'); ?>:</strong></label>
            <select class="form-select" name="id_tecnico" id="form-tecnico-id">
              <option value="">-- <?php echo __('unassigned'); ?> --</option>
              <?php foreach ($listaDeTecnicos as $tecnico): ?>
                <option value="<?php echo $tecnico['id_usuario']; ?>"><?php echo htmlspecialchars($tecnico['nombre_usuario']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('cancel'); ?></button>
          <button type="submit" class="btn btn-primary"><?php echo __('save_assignment'); ?></button>
        </div>
      </form>
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

    const asignarTecnicoModal = document.getElementById('asignarTecnicoModal');
    if (asignarTecnicoModal) {
        asignarTecnicoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-ticket-id');
            const tecnicoActualId = button.getAttribute('data-tecnico-actual-id');
            
            document.getElementById('modal-ticket-id').textContent = ticketId;
            document.getElementById('form-ticket-id').value = ticketId;
            document.getElementById('form-tecnico-id').value = tecnicoActualId;
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
            
            if (fotosString && fotosString !== "null" && fotosString !== "") {
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
/* Estilos personalizados para gestión de tickets */
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

<!-- Paginación -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php include 'views/includes/pagination.php'; ?>
<?php endif; ?>