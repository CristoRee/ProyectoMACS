<div class="container mt-4">
    <h2>Gestión de Piezas</h2>
    <?php if ($_SESSION['rol'] == 1): ?>
    <a href="index.php?accion=crearPieza" class="btn btn-primary mb-3">Agregar Nueva Pieza</a>
    <?php endif; ?>
    <a href="index.php?accion=verTicketConPiezas" class="btn btn-secondary mb-3">Ver Tickets con Piezas</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($piezas as $pieza): ?>
                <tr>
                    <td><?php echo $pieza['id_repuesto']; ?></td>
                    <td><?php echo htmlspecialchars($pieza['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($pieza['descripcion']); ?></td>
                    <td><?php echo $pieza['stock']; ?></td>
                    <td><?php echo $pieza['precio']; ?></td>
                    <td>
                        <?php if ($pieza['imagen']): ?>
                            <img src="<?php echo htmlspecialchars($pieza['imagen']); ?>" alt="Imagen" style="width: 50px; height: 50px; object-fit: cover;">
                        <?php else: ?>
                            No imagen
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($_SESSION['rol'] == 1): ?>
                        <a href="index.php?accion=editarPieza&id=<?php echo $pieza['id_repuesto']; ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="index.php?accion=eliminarPieza&id=<?php echo $pieza['id_repuesto']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta pieza?')">Eliminar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
