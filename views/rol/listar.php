<div class="container mt-4">
    <h2 class="mb-3">Gestión de Roles</h2>
    <a href="index.php?accion=crearRol" class="btn btn-success mb-3"> Crear Rol</a>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre del Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td><?= htmlspecialchars($rol['id_rol']) ?></td>
                    <td><?= htmlspecialchars($rol['nombre_rol']) ?></td>
                    <td>
                        <a href="index.php?accion=editarRol&id=<?= $rol['id_rol'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?accion=eliminarRol&id=<?= $rol['id_rol'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este rol?');"> Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<style>
    .table .table-dark th {
    background-color: #013467ff;  
    color: #ffffff;             
    border-color: #32383e;      
}
</style>
