<div class="container mt-4 mb-5">
    <?php if (isset($_GET['id_ticket'])): ?>
        <h2 class="pb-2 border-bottom"><?php echo __('ticket_history'); ?> #<?php echo htmlspecialchars($_GET['id_ticket']); ?></h2>
        <a href="index.php?accion=verHistorial" class="btn btn-secondary mt-2 mb-4"><?php echo __('view_complete_history'); ?></a>
    <?php else: ?>
        <h2 class="pb-2 border-bottom"><?php echo __('complete_system_history'); ?></h2>
        <p class="text-muted"><?php echo __('important_actions_log'); ?></p>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col"><?php echo __('date_time'); ?></th>
                    <th scope="col"><?php echo __('user'); ?></th>
                    <th scope="col"><?php echo __('affected_ticket'); ?></th>
                    <th scope="col"><?php echo __('action_performed'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historial)): ?>
                    <?php foreach ($historial as $evento): ?>
                        <tr>
                            <td><?php echo date('d/m/Y H:i:s', strtotime($evento['fecha'])); ?></td>
                            <td><?php echo htmlspecialchars($evento['nombre_usuario'] ?? __('system')); ?></td>
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
                        <td colspan="4" class="text-center py-4"><?php echo __('no_history_records'); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>