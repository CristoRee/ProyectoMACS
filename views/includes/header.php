<?php
// session_start(); // Asegúrate de que la sesión esté iniciada en tu index.php principal
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'BinaryTEC' ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<!-- 
    NOTA IMPORTANTE: Para que los menús desplegables (dropdowns) de Bootstrap funcionen,
    debes incluir el archivo JavaScript de Bootstrap. Generalmente, esto se hace
    en tu archivo footer.php, justo antes de cerrar la etiqueta </body>.

    Asegúrate de tener esta línea en tu footer.php:
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
-->

<header class="bg-primary position-relative">
    <nav class="navbar navbar-expand-lg navbar-dark container">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            
            <a class="navbar-brand fs-4 fw-bold" href="index.php?accion=inicio">BinaryTEC</a>
            
            <div id="logo-container">
                <a href="index.php?accion=inicio" aria-label="Inicio">
                    <i id="logo-wrench" class="fas fa-wrench"></i>
                </a>
            </div>

            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['usuario'])): ?>
                    
                    <a class="nav-link text-white me-4" href="index.php?accion=inicio#sobre-nosotros">Sobre Nosotros</a>

                    <!-- Este es el menú desplegable del perfil -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://i.pravatar.cc/40?u=<?= htmlspecialchars($_SESSION['usuario']) ?>" class="profile-pic rounded-circle" alt="Perfil">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <!-- Este enlace llama a la acción 'logout' que ya tienes en tu controlador -->
                            <li><a class="dropdown-item" href="index.php?accion=logout">Cerrar Sesión</a></li>
                        </ul>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-4">
