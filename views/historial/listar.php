<div class="container mt-4 mb-5">
    <?php if (isset($_GET['id_ticket'])): ?>
        <h2 class="pb-2 border-bottom">Historial del Ticket #<?php echo htmlspecialchars($_GET['id_ticket']); ?></h2>
        <a href="index.php?accion=verHistorial" class="btn btn-secondary mt-2 mb-4">Ver Historial Completo</a>
    <?php else: ?>
        <h2 class="pb-2 border-bottom">Historial Completo del Sistema</h2>
        <p class="text-muted">Aquí se registran todas las acciones importantes realizadas.</p>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Fecha y Hora</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Ticket Afectado</th>
                    <th scope="col">Acción Realizada</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historial)): ?>
                    <?php foreach ($historial as $evento): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($evento['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($evento['nombre_usuario'] ?? 'Sistema'); ?></td>
                            <td>
                                <?php if ($evento['id_ticket']): ?>
                                    #<?php echo htmlspecialchars($evento['id_ticket']); ?>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($evento['accion']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-4">No hay registros en el historial.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>