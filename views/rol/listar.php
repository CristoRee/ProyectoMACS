<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-user-tag me-2 text-primary"></i><?php echo __('role_management'); ?>
        </h2>
        <div class="badge bg-info fs-6">
            <i class="fas fa-shield-alt me-1"></i>
            Total: <?php echo count($roles); ?>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text text-muted mb-0">Gestiona los roles y permisos del sistema</p>
                        <a href="index.php?accion=crearRol" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle me-2"></i><?php echo __('create_role'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center" style="width: 80px;">
                                <i class="fas fa-hashtag"></i> ID
                            </th>
                            <th>
                                <i class="fas fa-user-tag me-1"></i><?php echo __('role_name'); ?>
                            </th>
                            <th class="text-center" style="width: 150px;">
                                <i class="fas fa-cogs me-1"></i><?php echo __('actions'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $rol): ?>
                        <tr class="align-middle">
                            <td class="text-center fw-bold">
                                <span class="badge bg-light text-dark"><?= htmlspecialchars($rol['id_rol']) ?></span>
                            </td>
                            <td class="fw-semibold">
                                <?php 
                                $roleIcon = match($rol['nombre_rol']) {
                                    'Administrador' => 'fas fa-crown text-danger',
                                    'Técnico' => 'fas fa-tools text-warning',
                                    'Cliente' => 'fas fa-user text-info',
                                    default => 'fas fa-user-tag text-secondary'
                                };
                                ?>
                                <i class="<?= $roleIcon ?> me-2"></i>
                                <?= htmlspecialchars($rol['nombre_rol']) ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="index.php?accion=editarRol&id=<?= $rol['id_rol'] ?>" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="<?php echo __('edit'); ?>"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?accion=eliminarRol&id=<?= $rol['id_rol'] ?>" 
                                       class="btn btn-sm btn-outline-danger" 
                                       onclick="return confirm('<?php echo __('confirm_delete_role'); ?>');"
                                       title="<?php echo __('delete'); ?>"
                                       data-bs-toggle="tooltip">
                                        <i class="fas fa-trash-alt"></i>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<style>
/* Estilos personalizados para gestión de roles */
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
