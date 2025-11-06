<?php 
$titulo = __('my_requests');
$vista_actual = $_GET['vista'] ?? 'activos';
?>

<div class="container mt-4 mb-5">
    <h2 class="pb-2 border-bottom"><?php echo __('my_repair_requests'); ?></h2>
    <p class="text-muted"><?php echo __('repair_requests_description'); ?></p>
    
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="badge bg-info fs-6">
                            <i class="fas fa-clipboard-list me-1"></i>
                            Solicitudes: <?php echo count($solicitudes); ?>
                        </div>
                        <div class="btn-group">
                            <a href="index.php?accion=misSolicitudes&vista=activos" class="btn <?php echo $vista_actual === 'activos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                <i class="fas fa-play-circle me-1"></i><?php echo __('active_requests'); ?>
                            </a>
                            <a href="index.php?accion=misSolicitudes&vista=finalizados" class="btn <?php echo $vista_actual === 'finalizados' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                <i class="fas fa-check-circle me-1"></i><?php echo __('completed_requests'); ?>
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
                            <th>
                                <i class="fas fa-laptop me-1"></i><?php echo __('device'); ?>
                            </th>
                            <th>
                                <i class="fas fa-exclamation-triangle me-1"></i><?php echo __('described_problem'); ?>
                            </th>
                            <th class="text-center">
                                <i class="fas fa-calendar me-1"></i><?php echo __('entry_date'); ?>
                            </th>
                            <th class="text-center">
                                <i class="fas fa-flag me-1"></i><?php echo __('status'); ?>
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-cogs me-1"></i><?php echo __('actions'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($solicitudes)): ?>
                            <?php foreach ($solicitudes as $solicitud): ?>
                            <tr class="align-middle">
                                <td class="fw-semibold">
                                    <i class="fas fa-desktop me-2 text-info"></i>
                                    <?php echo htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca'] . ' ' . $solicitud['modelo']); ?>
                                </td>
                                <td class="text-muted">
                                    <?php 
                                    $desc = htmlspecialchars($solicitud['descripcion_problema']);
                                    echo (strlen($desc) > 60) ? substr($desc, 0, 60) . '...' : $desc;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        <?php echo date('d/m/Y H:i', strtotime($solicitud['fecha_ingreso'])); ?>
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge fs-6" style="background-color: <?php echo htmlspecialchars($solicitud['estado_color']); ?> !important;">
                                        <?php echo htmlspecialchars($solicitud['nombre_estado']); ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($vista_actual === 'activos'): ?>
                                        <div class="btn-group" role="group">
                                            <?php if (!empty($solicitud['id_tecnico_asignado'])): ?>
                                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                                        onclick="abrirChat(<?php echo $solicitud['id_ticket']; ?>)" 
                                                        title="<?php echo __('chat_with_technician'); ?>"
                                                        data-bs-toggle="tooltip">
                                                    <i class="fas fa-comments"></i>
                                                </button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-outline-secondary disabled" 
                                                        title="<?php echo __('no_technician_assigned'); ?>"
                                                        data-bs-toggle="tooltip">
                                                    <i class="fas fa-comments"></i>
                                                </button>
                                            <?php endif; ?>
                                            
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    data-bs-toggle="modal" data-bs-target="#eliminarSolicitudModal"
                                                    data-id="<?php echo $solicitud['id_ticket']; ?>"
                                                    data-dispositivo="<?php echo htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca']); ?>"
                                                    title="<?php echo __('delete_request'); ?>"
                                                    data-bs-toggle="tooltip">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic"><?php echo __('no_actions'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-clipboard-list fa-3x text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-muted"><?php echo __('no_requests_in_view'); ?></h5>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eliminarSolicitudModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarModalLabel"><?php echo __('confirm_deletion'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><?php echo __('delete_confirmation_question'); ?></p>
        <p class="text-muted"><?php echo __('device_label'); ?> <strong id="dispositivo-a-eliminar"></strong></p>
        <p class="text-danger fw-bold"><?php echo __('action_cannot_be_undone'); ?></p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="index.php?accion=eliminarSolicitud">
          <input type="hidden" name="id_ticket" id="id-ticket-a-eliminar">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo __('cancel'); ?></button>
          <button type="submit" class="btn btn-danger"><?php echo __('yes_delete'); ?></button>
        </form>
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

    const eliminarSolicitudModal = document.getElementById('eliminarSolicitudModal');
    if (eliminarSolicitudModal) {
        eliminarSolicitudModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const ticketId = button.getAttribute('data-id');
            const dispositivo = button.getAttribute('data-dispositivo');

            const modalBodyDispositivo = eliminarSolicitudModal.querySelector('#dispositivo-a-eliminar');
            const hiddenInputId = eliminarSolicitudModal.querySelector('#id-ticket-a-eliminar');

            modalBodyDispositivo.textContent = dispositivo;
            hiddenInputId.value = ticketId;
        });
    }
});
</script>
<style>
/* Estilos personalizados para mis solicitudes */
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