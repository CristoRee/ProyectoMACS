<!DOCTYPE html>
<html lang="<?php echo Language::getCurrentLanguage(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?? 'BinaryTEC'; ?></title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="assets/css/style.css?v=<?php echo time(); ?>" rel="stylesheet">
    <?php if (isset($_SESSION['id_usuario'])): ?>
    <link href="assets/css/footerChat.css" rel="stylesheet">
    <?php endif; ?>
</head>
<body <?php if (isset($_SESSION['id_usuario'])) echo 'data-user-id="' . $_SESSION['id_usuario'] . '"'; ?>>

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
                
                <a class="nav-link text-white me-4" href="index.php?accion=inicio#sobre-nosotros"><?php echo __('about_us'); ?></a>
                
                <!-- Widget de cambio de idioma -->
                <div class="me-3">
                    <?php include 'views/includes/language_widget.php'; ?>
                </div>

                <div class="nav-item dropdown">
                    
                    <?php if (isset($_SESSION['usuario'])): ?>

                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php 
                                $foto_perfil_sesion = $_SESSION['foto_perfil'] ?? 'assets/images/default-avatar.png';
                            ?>
                            <img src="<?php echo htmlspecialchars($foto_perfil_sesion); ?>" class="profile-pic rounded-circle" alt="Perfil" style="width: 40px; height: 40px; object-fit: cover;">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li><h6 class="dropdown-header"><?php echo __('hello'); ?>, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 1):?>
                                <li><a class="dropdown-item" href="index.php?accion=listarUsuarios"><i class="fas fa-users-cog me-2"></i><?php echo __('manage_users'); ?></a></li>
                                <li><a class="dropdown-item" href="index.php?accion=gestionarTickets"><i class="fas fa-tasks me-2"></i><?php echo __('manage_tickets'); ?></a></li>
                                <li><a class="dropdown-item" href="index.php?accion=gestionarEstados"><i class="fas fa-list me-2"></i><?php echo __('manage_states'); ?></a></li>
                                <li><a class="dropdown-item" href="index.php?accion=listarRoles"><i class="fas fa-user-tag me-2"></i><?php echo __('manage_roles'); ?></a></li>
                                <li><a class="dropdown-item" href="index.php?accion=verHistorial"><i class="fas fa-history me-2"></i><?php echo __('history'); ?></a></li>
                                <li><a class="dropdown-item" href="index.php?accion=ajustes"><i class="fas fa-cog me-2"></i><?php echo __('settings'); ?></a></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 2):?>
                                <li><a class="dropdown-item" href="index.php?accion=misTickets"><i class="fas fa-ticket-alt me-2"></i><?php echo __('my_tickets'); ?></a></li>
                            <?php endif; ?>
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3):?>
                                <li><a class="dropdown-item" href="index.php?accion=misSolicitudes"><i class="fas fa-folder-open me-2"></i><?php echo __('my_requests'); ?></a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="index.php?accion=miPerfil"><i class="fas fa-user-circle me-2"></i><?php echo __('my_profile'); ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="index.php?accion=logout"><i class="fas fa-sign-out-alt me-2"></i><?php echo __('logout'); ?></a></li>
                        </ul>

                    <?php else:?>
                        
                        <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg"></i> 
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                            <li><a class="dropdown-item" href="index.php?accion=login"><i class="fas fa-sign-in-alt me-2"></i><?php echo __('login'); ?></a></li>
                            <li><a class="dropdown-item" href="index.php?accion=mostrarRegistro"><i class="fas fa-user-plus me-2"></i><?php echo __('register'); ?></a></li>
                        </ul>
                        
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
</header>