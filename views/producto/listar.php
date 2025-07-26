<?php 
$titulo = "Lista de Productos";
include('views/includes/header.php'); 
?>

<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lista de Productos</h2>
            <a href="index.php?accion=crear" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Crear nuevo producto
            </a>
        </div>
        
        <?php if (empty($resultados)): ?>
            <div class="alert alert-info">
                No hay productos registrados. <a href="index.php?accion=crear">Crear el primero</a>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados as $p): ?>
                                <tr>
                                    <td><?= $p['id'] ?></td>
                                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td>$<?= number_format($p['precio'], 2) ?></td>
                                    <td>
                                        <div class="btn-group-actions d-flex">
                                            <a href="index.php?accion=editar&id=<?= $p['id'] ?>" 
                                               class="btn btn-sm btn-outline-primary">
                                                Editar
                                            </a>
                                            <?php if ($_SESSION['rol'] === 'admin'): ?>
                                            <a href="index.php?accion=borrar&id=<?= $p['id'] ?>" class="btn btn-danger" onclick="return confirmarBorrar();">Borrar</a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('views/includes/footer.php'); ?>