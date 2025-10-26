<?php
/**
 * Componente de paginación reutilizable
 * 
 * @param int $currentPage - Página actual
 * @param int $totalPages - Total de páginas
 * @param string $baseUrl - URL base para los links
 * @param int $totalRecords - Total de registros
 * @param int $recordsPerPage - Registros por página
 * @param int $startRecord - Registro inicial de la página actual
 * @param int $endRecord - Registro final de la página actual
 */

if ($totalPages <= 1) return; // No mostrar paginación si hay una sola página

// Calcular rango de páginas a mostrar
$range = 2;
$startPage = max(1, $currentPage - $range);
$endPage = min($totalPages, $currentPage + $range);
?>

<div class="d-flex justify-content-between align-items-center mt-4">
    <!-- Información de registros -->
    <div class="text-muted">
        <small>
            <i class="fas fa-info-circle me-1"></i>
            <?php echo __('showing_results'); ?> <?php echo $startRecord; ?>-<?php echo $endRecord; ?> de <?php echo $totalRecords; ?> registros
        </small>
    </div>
    
    <!-- Controles de paginación -->
    <nav aria-label="Navegación de páginas">
        <ul class="pagination pagination-sm mb-0">
            <!-- Botón Primera página -->
            <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $baseUrl . '&page=1'; ?>" title="Primera página">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
            <?php endif; ?>
            
            <!-- Botón Anterior -->
            <?php if ($currentPage > 1): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $baseUrl . '&page=' . ($currentPage - 1); ?>" title="Página anterior">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
            <?php endif; ?>
            
            <!-- Páginas numéricas -->
            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo $baseUrl . '&page=' . $i; ?>">
                    <?php echo $i; ?>
                </a>
            </li>
            <?php endfor; ?>
            
            <!-- Botón Siguiente -->
            <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $baseUrl . '&page=' . ($currentPage + 1); ?>" title="Página siguiente">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
            <?php endif; ?>
            
            <!-- Botón Última página -->
            <?php if ($currentPage < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo $baseUrl . '&page=' . $totalPages; ?>" title="Última página">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<!-- Selector de registros por página -->
<div class="d-flex justify-content-center mt-3">
    <div class="btn-group btn-group-sm">
        <span class="btn btn-outline-secondary disabled">Registros por página:</span>
        <?php 
        $perPageOptions = [10, 25, 50, 100];
        foreach ($perPageOptions as $option): 
            $activeClass = ($recordsPerPage == $option) ? 'btn-primary' : 'btn-outline-primary';
        ?>
        <a href="<?php echo $baseUrl . '&page=1&per_page=' . $option; ?>" 
           class="btn <?php echo $activeClass; ?>">
            <?php echo $option; ?>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<style>
.pagination .page-link {
    transition: all 0.2s ease;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.pagination .page-link:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.btn-group .btn {
    transition: all 0.2s ease;
}

.btn-group .btn:hover:not(.disabled) {
    transform: translateY(-1px);
}
</style>