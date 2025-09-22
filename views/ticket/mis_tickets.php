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
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

});
</script>