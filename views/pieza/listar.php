<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-cogs me-2 text-primary"></i><?php echo __('manage_parts'); ?>
        </h2>
        <div class="badge bg-info fs-6">
            <i class="fas fa-layer-group me-1"></i>
            <?php echo __('total_parts'); ?>: <?php echo count($piezas); ?>
        </div>
    </div>
    
    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <div class="btn-toolbar" role="toolbar">
                            <?php if ($_SESSION['rol'] == 1): ?>
                            <div class="btn-group me-2" role="group">
                                <a href="index.php?accion=crearPieza" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle me-2"></i><?php echo __('add_new_part'); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                            <?php if ($_SESSION['rol'] <= 2): // Administradores y técnicos ?>
                            <div class="btn-group" role="group">
                                <a href="index.php?accion=verTicketConPiezas" class="btn btn-outline-primary">
                                    <i class="fas fa-wrench me-2"></i><?php echo __('tickets_with_parts'); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="text-muted me-2"><?php echo __('showing_results'); ?>:</span>
                            <span class="badge bg-secondary fs-6"><?php echo count($piezas); ?> <?php echo __('parts'); ?></span>
                        </div>
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
                            <th class="text-center" style="width: 60px;">
                                <i class="fas fa-hashtag"></i> ID
                            </th>
                            <th>
                                <i class="fas fa-tag me-1"></i><?php echo __('name'); ?>
                            </th>
                            <th>
                                <i class="fas fa-info-circle me-1"></i><?php echo __('description'); ?>
                            </th>
                            <th class="text-center" style="width: 100px;">
                                <i class="fas fa-boxes me-1"></i><?php echo __('stock'); ?>
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="fas fa-dollar-sign me-1"></i><?php echo __('price'); ?>
                            </th>
                            <th class="text-center" style="width: 100px;">
                                <i class="fas fa-image me-1"></i><?php echo __('image'); ?>
                            </th>
                            <th class="text-center" style="width: 120px;">
                                <i class="fas fa-cogs me-1"></i><?php echo __('actions'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($piezas as $pieza): ?>
                            <tr class="align-middle">
                                <td class="text-center fw-bold">
                                    <span class="badge bg-light text-dark"><?php echo $pieza['id_repuesto']; ?></span>
                                </td>
                                <td class="fw-semibold">
                                    <?php echo htmlspecialchars($pieza['nombre']); ?>
                                </td>
                                <td class="text-muted">
                                    <?php 
                                    $desc = htmlspecialchars($pieza['descripcion']);
                                    echo (strlen($desc) > 50) ? substr($desc, 0, 50) . '...' : $desc;
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $stock = $pieza['stock'];
                                    $stockClass = $stock > 10 ? 'success' : ($stock > 5 ? 'warning' : 'danger');
                                    ?>
                                    <span class="badge bg-<?php echo $stockClass; ?> fs-6">
                                        <?php echo $stock; ?>
                                    </span>
                                </td>
                                <td class="text-center fw-bold">
                                    <span class="text-primary">$<?php echo number_format($pieza['precio'], 2); ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($pieza['imagen']) && $pieza['imagen']): ?>
                                        <img src="<?php echo htmlspecialchars($pieza['imagen']); ?>" 
                                             alt="<?php echo __('image'); ?>" 
                                             class="rounded shadow-sm parts-image"
                                             style="width: 50px; height: 50px; object-fit: cover; cursor: pointer; border: 2px solid #e9ecef;"
                                             onclick="showImageModal('<?php echo htmlspecialchars($pieza['imagen']); ?>', '<?php echo htmlspecialchars($pieza['nombre']); ?>')">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded" style="width: 50px; height: 50px; border: 2px dashed #dee2e6;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($_SESSION['rol'] == 1): ?>
                                    <div class="btn-group" role="group">
                                        <a href="index.php?accion=editarPieza&id=<?php echo $pieza['id_repuesto']; ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="<?php echo __('edit'); ?>"
                                           data-bs-toggle="tooltip">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?accion=eliminarPieza&id=<?php echo $pieza['id_repuesto']; ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           title="<?php echo __('delete'); ?>"
                                           data-bs-toggle="tooltip"
                                           onclick="return confirm('<?php echo __('confirm_delete_part'); ?>')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                    <?php else: ?>
                                        <span class="text-muted fst-italic"><?php echo __('view_only'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <?php if (empty($piezas)): ?>
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="fas fa-cogs fa-4x text-muted opacity-50"></i>
            </div>
            <h4 class="text-muted mb-3"><?php echo __('no_parts_found'); ?></h4>
            <?php if ($_SESSION['rol'] == 1): ?>
                <p class="text-muted mb-4"><?php echo __('add_first_part'); ?></p>
                <a href="index.php?accion=crearPieza" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle me-2"></i><?php echo __('add_new_part'); ?>
                </a>
            <?php else: ?>
                <p class="text-muted"><?php echo __('contact_admin_to_add_parts'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Modal para ver imagen completa -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel"><?php echo __('part_image'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos personalizados para la gestión de piezas */
.parts-image {
    transition: all 0.3s ease;
}

.parts-image:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
    border-color: #007bff !important;
}

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

.btn-toolbar .btn-group {
    margin-right: 0.5rem;
}

.badge {
    font-size: 0.75rem;
}

/* Animaciones para botones */
.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}

/* Mejoras responsive */
@media (max-width: 768px) {
    .btn-toolbar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-group {
        margin-bottom: 0.5rem;
    }
    
    .parts-image {
        width: 40px !important;
        height: 40px !important;
    }
}

/* Estados de stock */
.badge.bg-success {
    background-color: #0d6efd !important;
}
.badge.bg-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}
.badge.bg-danger {
    background-color: #dc3545 !important;
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
</style>

<script>
// Función para mostrar modal de imagen
function showImageModal(imageSrc, imageName) {
    const modalImage = document.getElementById('modalImage');
    const modalLabel = document.getElementById('imageModalLabel');
    
    modalImage.src = imageSrc;
    modalImage.alt = imageName;
    modalLabel.textContent = imageName;
    
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

// Inicializar tooltips
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Agregar efecto de hover a las imágenes
    const images = document.querySelectorAll('.parts-image');
    images.forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
    });
    
    // Confirmar eliminación con SweetAlert si está disponible
    const deleteButtons = document.querySelectorAll('[onclick*="confirm"]');
    deleteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.href;
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '<?php echo __('are_you_sure'); ?>',
                    text: '<?php echo __('confirm_delete_part'); ?>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '<?php echo __('yes_delete'); ?>',
                    cancelButtonText: '<?php echo __('cancel'); ?>'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            } else {
                if (confirm('<?php echo __('confirm_delete_part'); ?>')) {
                    window.location.href = href;
                }
            }
        });
    });
});
</script>
