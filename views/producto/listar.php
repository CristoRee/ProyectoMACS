<?php 
$titulo = __('my_requests');
$vista_actual = $_GET['vista'] ?? 'activos';
?>

<div class="container mt-4 mb-5">
    <h2 class="pb-2 border-bottom"><?php echo __('my_repair_requests'); ?></h2>
    <p class="text-muted"><?php echo __('repair_requests_description'); ?></p>
    
    <div class="d-flex justify-content-end mb-3">
        <div class="btn-group">
            <a href="index.php?accion=misSolicitudes&vista=activos" class="btn <?php echo $vista_actual === 'activos' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                <?php echo __('active_requests'); ?>
            </a>
            <a href="index.php?accion=misSolicitudes&vista=finalizados" class="btn <?php echo $vista_actual === 'finalizados' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                <?php echo __('completed_requests'); ?>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?php echo __('device'); ?></th>
                    <th scope="col"><?php echo __('described_problem'); ?></th>
                    <th scope="col"><?php echo __('entry_date'); ?></th>
                    <th scope="col"><?php echo __('status'); ?></th>
                    <th scope="col"><?php echo __('actions'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($solicitudes)): ?>
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca'] . ' ' . $solicitud['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($solicitud['descripcion_problema']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($solicitud['fecha_ingreso'])); ?></td>
                            <td>
                                <span class="badge" style="background-color: <?php echo htmlspecialchars($solicitud['estado_color']); ?> !important; font-size: 0.9rem;">
                                    <?php echo htmlspecialchars($solicitud['nombre_estado']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($vista_actual === 'activos'): ?>
                                    <?php if (!empty($solicitud['id_tecnico_asignado'])): ?>
                                        <button type="button" class="btn btn-sm btn-success" onclick="abrirChat(<?php echo $solicitud['id_ticket']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo __('chat_with_technician'); ?>">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-secondary disabled" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo __('no_technician_assigned'); ?>">
                                            <i class="fas fa-comments"></i>
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarSolicitudModal"
                                            data-id="<?php echo $solicitud['id_ticket']; ?>"
                                            data-dispositivo="<?php echo htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca']); ?>"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo __('delete_request'); ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo __('no_actions'); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4"><?php echo __('no_requests_in_view'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
    .table .table-dark th {
    background-color: #013467ff;  
    color: #ffffff;             
    border-color: #32383e;      
}
</style>