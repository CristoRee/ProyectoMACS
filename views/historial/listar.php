<div class="container mt-4 mb-5" id="historial-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <?php if (isset($_GET['id_ticket'])): ?>
            <h2 class="mb-0">
                <i class="fas fa-history me-2 text-primary"></i><?php echo __('ticket_history'); ?> #<?php echo htmlspecialchars($_GET['id_ticket']); ?>
            </h2>
        <?php else: ?>
            <h2 class="mb-0">
                <i class="fas fa-clipboard-list me-2 text-primary"></i><?php echo __('complete_system_history'); ?>
            </h2>
        <?php endif; ?>
        <div class="badge bg-info fs-6">
            <i class="fas fa-database me-1"></i>
            Registros: <?php echo $totalRecords ?? count($historial); ?>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <?php if (isset($_GET['id_ticket'])): ?>
                            <p class="card-text text-muted mb-0">Historial de acciones para el ticket específico</p>
                            <a href="index.php?accion=verHistorial" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-1"></i><?php echo __('view_complete_history'); ?>
                            </a>
                        <?php else: ?>
                            <p class="card-text text-muted mb-0"><?php echo __('important_actions_log'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-primary-historial">
                        <tr>
                            <th>
                                <i class="fas fa-clock me-1"></i><?php echo __('date_time'); ?>
                            </th>
                            <th>
                                <i class="fas fa-user me-1"></i><?php echo __('user'); ?>
                            </th>
                            <th class="text-center">
                                <i class="fas fa-ticket-alt me-1"></i><?php echo __('affected_ticket'); ?>
                            </th>
                            <th>
                                <i class="fas fa-bolt me-1"></i><?php echo __('action_performed'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($historial)): ?>
                            <?php foreach ($historial as $evento): ?>
                            <tr class="align-middle">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                        <div>
                                            <div class="fw-semibold"><?php echo date('d/m/Y', strtotime($evento['fecha'])); ?></div>
                                            <small class="text-muted"><?php echo date('H:i:s', strtotime($evento['fecha'])); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($evento['nombre_usuario']): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle me-2 text-info"></i>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($evento['nombre_usuario']); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-cog me-2 text-secondary"></i>
                                            <span class="text-muted fst-italic"><?php echo __('system'); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($evento['id_ticket']): ?>
                                        <span class="badge bg-primary fs-6">
                                            <i class="fas fa-hashtag me-1"></i><?php echo htmlspecialchars($evento['id_ticket']); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-dark">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                        $accion = $evento['accion'];
                                        $icono = 'fas fa-info-circle text-info';
                                        if (strpos($accion, 'creado') !== false || strpos($accion, 'registrado') !== false) {
                                            $icono = 'fas fa-plus-circle text-primary';
                                        } elseif (strpos($accion, 'actualizado') !== false || strpos($accion, 'modificado') !== false) {
                                            $icono = 'fas fa-edit text-warning';
                                        } elseif (strpos($accion, 'eliminado') !== false || strpos($accion, 'borrado') !== false) {
                                            $icono = 'fas fa-trash text-danger';
                                        } elseif (strpos($accion, 'asignado') !== false) {
                                            $icono = 'fas fa-user-plus text-primary';
                                        }
                                        ?>
                                        <i class="<?php echo $icono; ?> me-2"></i>
                                        <span><?php echo htmlspecialchars($evento['accion']); ?></span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-history fa-3x text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="text-muted"><?php echo __('no_history_records'); ?></h5>
                                    <p class="text-muted mb-0">No hay actividad registrada aún</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos ULTRA específicos SOLO para el historial usando ID único */
#historial-container .table-primary-historial th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: white !important;
    border: none !important;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

/* Animación específica SOLO para tabla de historial con ID */
#historial-container .card .table tbody tr {
    animation: fadeInUpHistorial 0.5s ease;
}

@keyframes fadeInUpHistorial {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Hover effect SOLO para tabla del historial con ID específico */
#historial-container .card .table tbody tr:hover {
    background-color: rgba(102, 126, 234, 0.1);
    transition: background-color 0.3s ease;
}

/* Estilos de badge específicos SOLO dentro del historial */
#historial-container .card .badge {
    font-size: 0.75rem;
}

/* Iconos con espaciado SOLO en tabla de historial */
#historial-container .card .table .fas {
    width: 16px;
    text-align: center;
}

/* Responsive específico SOLO para historial con ID */
@media (max-width: 768px) {
    #historial-container .card .table-responsive {
        font-size: 0.9rem;
    }
}

/* Mantener el estilo original para table-dark si existe */
.table .table-dark th {
    background-color: #013467ff;  
    color: #ffffff;             
    border-color: #32383e;      
}

/* Protección específica para el chat - NO tocar estos elementos */
.chat-launcher, 
#chat-launcher,
.chat-list,
#chat-list,
#chat-ventana,
.chat-ventana-oculta {
    /* Asegurar que mantengan sus estilos originales */
    position: fixed !important;
}

/* Asegurar posición específica del chat launcher */
.chat-launcher,
#chat-launcher {
    bottom: 20px !important;
    right: 20px !important;
    z-index: 1001 !important;
}

/* Asegurar que NO se apliquen estilos del historial fuera de su contenedor */
#historial-container * {
    /* Todos los estilos están limitados a este ID */
}
</style>

<!-- Paginación -->
<?php if (isset($totalPages) && $totalPages > 1): ?>
    <?php include 'views/includes/pagination.php'; ?>
<?php endif; ?>