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
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($solicitudes)): ?>
                    <?php foreach ($solicitudes as $solicitud): ?>
                        <tr>
                            <td><?= htmlspecialchars($solicitud['tipo_producto'] . ' ' . $solicitud['marca'] . ' ' . $solicitud['modelo']) ?></td>
                            <td><?= htmlspecialchars($solicitud['descripcion_problema']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($solicitud['fecha_ingreso'])) ?></td>
                            <td><span class="badge rounded-pill bg-primary"><?= htmlspecialchars($solicitud['nombre_estado']) ?></span></td>
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
