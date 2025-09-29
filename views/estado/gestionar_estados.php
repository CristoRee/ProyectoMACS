<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: index.php?accion=inicio');
    exit();
}
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Gestionar Estados</h2>
        <a href="index.php?accion=crearEstado" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Estado
        </a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estados as $estado): ?>
            <tr>
                <td><?php echo $estado['id_estado']; ?></td>
                <td><?php echo htmlspecialchars($estado['nombre_estado']); ?></td>
                <td>
                    <form method="POST" action="index.php?accion=eliminarEstado" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar este estado?');">
                        <input type="hidden" name="id_estado" value="<?php echo $estado['id_estado']; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>