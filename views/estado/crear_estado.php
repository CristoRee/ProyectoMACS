<?php

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: index.php?accion=inicio');
    exit();
}
?>
<div class="container mt-4">
    <h2>Agregar Nuevo Estado</h2>
    <form method="POST" action="index.php?accion=guardarEstado">
        <div class="mb-3">
            <label for="nombre_estado" class="form-label">Nombre del Estado</label>
            <input type="text" class="form-control" id="nombre_estado" name="nombre_estado" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Estado</button>
    </form>
</div>
