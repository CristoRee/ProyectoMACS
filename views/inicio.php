<?php
// Determinamos el rol del usuario. Si no está logueado, el rol es 0 (visitante).
$rol = $_SESSION['rol'] ?? 0;
?>

<div class="container py-5">

    <?php if ($rol == 3 || $rol == 0): ?>
    <div class="text-center">
        <h1 class="display-4 fw-bold"><?php echo __('device_broken'); ?></h1>
        <p class="fs-4 col-md-10 mx-auto text-muted"><?php echo __('device_broken_desc'); ?></p>

        <div class="row justify-content-center mt-5 gx-4 gy-4">
            <div class="col-md-5 col-lg-4">
                <?php
                    $enlace_solicitud = isset($_SESSION['usuario']) ? "index.php?accion=crear" : "index.php?accion=login";
                ?>
                <a href="<?php echo $enlace_solicitud; ?>" class="dashboard-button primary">
                    <i class="fas fa-tools fa-2x"></i>
                    <span class="dashboard-button-text"><?php echo __('request_repair'); ?></span>
                </a>
            </div>

            <?php if ($rol == 3): ?>
            <div class="col-md-5 col-lg-4">
                <a href="index.php?accion=misSolicitudes" class="dashboard-button secondary">
                    <i class="fas fa-folder-open fa-2x"></i>
                    <span class="dashboard-button-text"><?php echo __('created_requests'); ?></span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>


    <?php if ($rol == 2): ?>
    <div class="text-center">
        <h1 class="display-4 fw-bold"><?php echo __('technician_panel'); ?></h1>
        <p class="fs-4 text-muted"><?php echo __('technician_panel_desc'); ?></p>

    </div>
        <div class="row justify-content-center mt-5 gx-4 gy-4">
            <div class="col-md-5 col-lg-4">
                <a href="index.php?accion=misTickets" class="dashboard-button primary">
                    <i class="fas fa-ticket-alt fa-2x"></i>
                    <span class="dashboard-button-text"><?php echo __('view_my_assignments'); ?></span>
                </a>
            </div>
            <div class="col-md-5 col-lg-4">
                <a href="index.php?accion=mostrarPiezas" class="dashboard-button secondary">
                    <i class="fas fa-cogs fa-2x"></i>
                    <span class="dashboard-button-text"><?php echo __('parts'); ?></span>
                </a>
            </div>
            <div class="col-md-5 col-lg-4">
                <a href="index.php?accion=verTicketConPiezas" class="dashboard-button secondary">
                    <i class="fas fa-tools fa-2x"></i>
                    <span class="dashboard-button-text"><?php echo __('tickets_with_parts'); ?></span>
                </a>
            </div>
        </div>
        
        
       <?php endif; ?>


    <?php if ($rol == 1): ?>
    <div class="text-center">
        <h1 class="display-4 fw-bold"><?php echo __('admin_panel'); ?></h1>
        <p class="fs-4 text-muted"><?php echo __('admin_panel_desc'); ?></p>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4 text-center">
        <div class="col">
            <a href="index.php?accion=gestionarTickets" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                        <h4 class="card-title"><?php echo __('manage_tickets'); ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=listarUsuarios" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                        <h4 class="card-title"><?php echo __('manage_users'); ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=listarRoles" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-user-tag fa-3x text-primary mb-3"></i>
                        <h4 class="card-title"><?php echo __('manage_roles'); ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=gestionarEstados" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
                        <h4 class="card-title"><?php echo __('manage_states'); ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=mostrarPiezas" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-microchip fa-3x text-primary mb-3"></i>
                        <h4 class="card-title"><?php echo __('manage_parts'); ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=verHistorial" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-history fa-3x text-primary mb-3"></i>
                        <h4 class="card-title"><?php echo __('history'); ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=ajustes" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-cog fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Ajustes</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div id="sobre-nosotros" class="row align-items-md-stretch pt-5 mt-5">
        <div class="col-md-12">
            <div class="h-100 p-5 border rounded-3">
                <h2 class="pb-2 border-bottom mb-4"><?php echo __('about_us_title'); ?></h2>
                <p>
                    <?php echo __('about_us_content'); ?>
                </p>
            </div>
        </div>
    </div>

    <div class="text-center py-4">
        <video 
            src="Documentos/logo_animacion.mp4" 
            width="400"
            height="350"
            autoplay 
            muted 
            loop
            style="cursor: pointer; border-radius: 10px;"
            title="Haz clic para pausar o reanudar"
        ></video>
    </div>

    <script>
        // Este script solo debe estar una vez
        if (document.querySelector('video')) {
            const video = document.querySelector('video');
            video.addEventListener('click', function() {
                if (this.paused) {
                    this.play();
                } else {
                    this.pause();
                }
            });
        }
    </script>
</div>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <?php endif; ?>