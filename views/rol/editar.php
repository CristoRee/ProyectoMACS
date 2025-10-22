<div class="container mt-4">
    <h2>Editar Rol</h2>
    <form method="POST" action="index.php?accion=editarRol&id=<?= $rol['id_rol'] ?>">
        <div class="mb-3">
            <label for="nombre_rol" class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre_rol" id="nombre_rol" class="form-control" value="<?= htmlspecialchars($rol['nombre_rol']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="index.php?accion=listarRoles" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
