<?php 
$titulo = "Mis Solicitudes";
?>

<div class="container mt-4 mb-5">
    <h2 class="pb-2 border-bottom">Mis Solicitudes de Reparación</h2>
    <p class="text-muted">Aquí puedes ver el estado de todos los dispositivos que has ingresado.</p>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Dispositivo</th>
                    <th scope="col">Problema Descrito</th>
                    <th scope="col">Fecha de Ingreso</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($solicitudes)): ?>
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca'] . ' ' . $solicitud['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($solicitud['descripcion_problema']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($solicitud['fecha_ingreso'])); ?></td>
                            <td><span class="badge rounded-pill bg-primary"><?php echo htmlspecialchars($solicitud['nombre_estado']); ?></span></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success" onclick="abrirChat(<?php echo $solicitud['id_ticket']; ?>)" data-bs-toggle="tooltip" data-bs-placement="top" title="Charlar con el técnico">
                                    <i class="fas fa-comments"></i>
                                </button>
                                
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarSolicitudModal"
                                        data-id="<?php echo $solicitud['id_ticket']; ?>"
                                        data-dispositivo="<?php echo htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca']); ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">No tienes ninguna solicitud de reparación registrada.</td>
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
        <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro de que quieres eliminar esta solicitud de reparación?</p>
        <p class="text-muted">Dispositivo: <strong id="dispositivo-a-eliminar"></strong></p>
        <p class="text-danger fw-bold">Esta acción no se puede deshacer.</p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="index.php?accion=eliminarSolicitud">
          <input type="hidden" name="id_ticket" id="id-ticket-a-eliminar">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
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
    eliminarSolicitudModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const ticketId = button.getAttribute('data-id');
        const dispositivo = button.getAttribute('data-dispositivo');

      
        const modalBodyDispositivo = eliminarSolicitudModal.querySelector('#dispositivo-a-eliminar');
        const hiddenInputId = eliminarSolicitudModal.querySelector('#id-ticket-a-eliminar');

        modalBodyDispositivo.textContent = dispositivo;
        hiddenInputId.value = ticketId;
    });
});
</script>