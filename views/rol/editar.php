<div class="container mt-4">
    <h2><?php echo __('edit_role'); ?></h2>
    <form method="POST" action="index.php?accion=editarRol&id=<?= $rol['id_rol'] ?>">
        <div class="mb-3">
            <label for="nombre_rol" class="form-label"><?php echo __('role_name'); ?></label>
            <input type="text" name="nombre_rol" id="nombre_rol" class="form-control" value="<?= htmlspecialchars($rol['nombre_rol']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary"><?php echo __('update'); ?></button>
        <a href="index.php?accion=listarRoles" class="btn btn-secondary"><?php echo __('cancel'); ?></a>
    </form>
</div>
