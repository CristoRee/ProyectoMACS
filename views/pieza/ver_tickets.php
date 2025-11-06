<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <h2 class="text-center mb-4"><?php echo __('my_tickets_with_parts'); ?></h2>
            <a href="index.php?accion=mostrarPiezas" class="btn btn-secondary mb-4 d-block mx-auto" style="width: fit-content;">
                <i class="fas fa-arrow-left me-2"></i><?php echo __('back_to_parts'); ?>
            </a>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success text-center"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (empty($tickets)): ?>
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4><?php echo __('no_assigned_tickets'); ?></h4>
                    <p><?php echo __('contact_admin_if_error'); ?></p>
                </div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($tickets as $ticket): ?>
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">Ticket #<?php echo $ticket['id_ticket']; ?></h5>
                                    <small><?php echo __('state'); ?>: <span class="badge bg-light text-dark"><?php echo htmlspecialchars($ticket['nombre_estado']); ?></span></small>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-light border">
                                        <strong><?php echo __('problem_description'); ?>:</strong><br>
                                        <?php echo nl2br(htmlspecialchars($ticket['descripcion_problema'])); ?>
                                    </div>
                                    <h6 class="mt-3"><?php echo __('assigned_parts'); ?>:</h6>
                                    <?php if (!empty($piezas_usadas[$ticket['id_ticket']])): ?>
                                        <div class="row g-2">
                                            <?php foreach ($piezas_usadas[$ticket['id_ticket']] as $pieza): ?>
                                                <div class="col-6">
                                                    <div class="card border-secondary">
                                                        <div class="card-body p-2 text-center">
                                                            <?php if ($pieza['imagen']): ?>
                                                                <img src="<?php echo htmlspecialchars($pieza['imagen']); ?>" alt="Imagen de pieza" class="img-fluid rounded mb-1" style="max-height: 60px; object-fit: cover;">
                                                            <?php else: ?>
                                                                <div class="bg-light rounded d-flex align-items-center justify-content-center mb-1" style="height: 60px;">
                                                                    <i class="fas fa-image text-muted"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                            <small class="fw-bold"><?php echo htmlspecialchars($pieza['nombre']); ?></small><br>
                                                            <small class="text-muted"><?php echo __('quantity'); ?>: <?php echo $pieza['cantidad_usada']; ?></small><br>
                                                            <a href="index.php?accion=desasignarPieza&id_ticket=<?php echo $ticket['id_ticket']; ?>&id_repuesto=<?php echo $pieza['id_repuesto']; ?>" class="btn btn-sm btn-outline-danger mt-1" onclick="return confirm('<?php echo __('confirm_unassign_part'); ?>')"><?php echo __('unassign'); ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted small"><?php echo __('no_parts_assigned'); ?></p>
                                    <?php endif; ?>
                                    <div class="mt-3">
                                        <a href="index.php?accion=asignarPieza&id_ticket=<?php echo $ticket['id_ticket']; ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus me-1"></i><?php echo __('assign_part'); ?>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
