<?php

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 1) {
    header('Location: index.php?accion=inicio');
    exit();
}
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-plus-circle me-2 text-primary"></i>Agregar Nuevo Estado
        </h2>
        <a href="index.php?accion=gestionarEstados" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Volver a Estados
        </a>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form method="POST" action="index.php?accion=guardarEstado">
                <div class="mb-3">
                    <label for="nombre_estado" class="form-label">
                        <i class="fas fa-tag me-1"></i>Nombre del Estado
                    </label>
                    <input type="text" class="form-control" id="nombre_estado" name="nombre_estado" required>
                </div>
                <div class="mb-3">
                    <label for="color" class="form-label">
                        <i class="fas fa-palette me-1"></i>Color del Estado
                    </label>
                    <input type="color" class="form-control form-control-color" id="color" name="color" value="#0d6efd" title="Elige un color">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="index.php?accion=gestionarEstados" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Guardar Estado
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Estilos específicos para crear estado */
.form-control-color {
    width: 100px;
    height: 40px;
    border-radius: 8px;
    border: 2px solid #dee2e6;
    cursor: pointer;
}

.form-control-color:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn {
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

/* Animación de entrada */
.card {
    animation: slideInUp 0.5s ease;
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
