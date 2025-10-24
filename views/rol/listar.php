<div class="container mt-4">
    <h2 class="mb-3"><?php echo __('role_management'); ?></h2>
    <a href="index.php?accion=crearRol" class="btn btn-success mb-3"><?php echo __('create_role'); ?></a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th><?php echo __('role_name'); ?></th>
                <th><?php echo __('actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= htmlspecialchars($rol['id_rol']) ?></td>
                    <td><?= htmlspecialchars($rol['nombre_rol']) ?></td>
                    <td>
                        <a href="index.php?accion=editarRol&id=<?= $rol['id_rol'] ?>" class="btn btn-warning btn-sm"><?php echo __('edit'); ?></a>
                        <a href="index.php?accion=eliminarRol&id=<?= $rol['id_rol'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('<?php echo __('confirm_delete_role'); ?>');"><?php echo __('delete'); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
