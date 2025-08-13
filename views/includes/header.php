<?php

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

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://i.pravatar.cc/40?u=<?= htmlspecialchars($_SESSION['usuario']) ?>" class="profile-pic rounded-circle" alt="Perfil">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            
                            <li><a class="dropdown-item" href="index.php?accion=misSolicitudes">Mis Solicitudes</a></li>
                            <li><a class="dropdown-item" href="#">Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#">Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?accion=logout">Cerrar Sesión</a></li>
                        </ul>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<div class="container mt-4">
