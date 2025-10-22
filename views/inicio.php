<?php
$rol = $_SESSION['rol'] ?? 0;
?>

<div class="container py-5">

    <?php if ($rol == 3 || $rol == 0): ?>
    <div class="text-center">
        <h1 class="display-4 fw-bold">¿Tu dispositivo se averió?</h1>
        <p class="fs-4 col-md-10 mx-auto text-muted">Cuéntanos cuál es el problema y nuestro equipo de expertos se encargará de solucionarlo.</p>

        <div class="row justify-content-center mt-5 gx-4 gy-4">
            <div class="col-md-5 col-lg-4">
                <?php
                    $enlace_solicitud = isset($_SESSION['usuario']) ? "index.php?accion=crear" : "index.php?accion=login";
                ?>
                <a href="<?php echo $enlace_solicitud; ?>" class="dashboard-button primary">
                    <i class="fas fa-tools fa-2x"></i>
                    <span class="dashboard-button-text">Solicitar Reparación</span>
                </a>
            </div>

            <?php if ($rol == 3): ?>
            <div class="col-md-5 col-lg-4">
                <a href="index.php?accion=misSolicitudes" class="dashboard-button secondary">
                    <i class="fas fa-folder-open fa-2x"></i>
                    <span class="dashboard-button-text">Solicitudes Creadas</span>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>


    <?php if ($rol == 2): ?>
    <div class="text-center">
        <h1 class="display-4 fw-bold">Panel del Técnico</h1>
        <p class="fs-4 text-muted">Accede a tus trabajos de reparación asignados.</p>
        <div class="row justify-content-center mt-5 gx-4 gy-4">
            <div class="col-md-5 col-lg-4">
                <a href="index.php?accion=misTickets" class="dashboard-button primary">
                    <i class="fas fa-ticket-alt fa-2x"></i>
                    <span class="dashboard-button-text">Ver Mis Encargos</span>
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>


    <?php if ($rol == 1): ?>
    <div class="text-center">
        <h1 class="display-4 fw-bold">Panel de Administración</h1>
        <p class="fs-4 text-muted">Gestiona todos los aspectos del sistema.</p>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4 text-center">
        <div class="col">
            <a href="index.php?accion=gestionarTickets" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-tasks fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Gestionar Tickets</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=listarUsuarios" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-users-cog fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Gestionar Usuarios</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=listarRoles" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-user-tag fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Gestionar Roles</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=gestionarEstados" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-clipboard-list fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Gestionar Estados</h4>
                    </div>
                </div>
            </a>
        </div>
        <div class="col">
             <a href="index.php?accion=verHistorial" class="text-decoration-none">
                <div class="card h-100 shadow-sm card-hover">
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <i class="fas fa-history fa-3x text-primary mb-3"></i>
                        <h4 class="card-title">Historial del Sistema</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <?php endif; ?>

    <div id="sobre-nosotros" class="row align-items-md-stretch pt-5 mt-5">
        </div>

    <div class="text-center py-4">
        </div>
</div>


<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <?php endif; ?>

    <div id="sobre-nosotros" class="row align-items-md-stretch pt-4">
        <div class="col-md-12">
            <div class="h-100 p-5 border rounded-3">
                <h2 class="pb-2 border-bottom mb-4">Sobre Nosotros</h2>
                <p>
                    <strong>BinaryTEC</strong> es una iniciativa que nace de <strong>BinaryMACS</strong>, un proyecto de fin de año desarrollado por estudiantes de informática en <strong>UTU</strong>. 
                    Nuestra misión es transformar y mejorar la eficiencia de los servicios técnicos en Rivera, implementando un sistema de organización claro y profesional que beneficie tanto a los técnicos como a los clientes. Buscamos aportar orden y calidad al mundo de las reparaciones tecnológicas.
                </p>
            </div>
        </div>
    </div>

    <div class="text-center py-4">
        <video 
            src="Documentos/logo_animacion.mp4" 
            width="300"
            hight="100"
            autoplay 
            muted 
            loop
            style="cursor: pointer; border-radius: 10px;"
            title="Haz clic para pausar o reanudar"
        ></video>
    </div>

    <script>
        const video = document.querySelector('video');
        video.addEventListener('click', function() {
            if (this.paused) {
                this.play();
            } else {
                this.pause();
            }
        });
    </script>
    </div>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <?php endif; ?>