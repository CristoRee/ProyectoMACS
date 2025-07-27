<?php
include('includes/header.php'); 
?>
<link rel="stylesheet" href="../assets/css/style.css">
<div class="container py-5">

    <!-- Sección de Presentación Principal -->
    <div class="p-5 mb-4 bg-light rounded-3 text-center shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-4 fw-bold">Bienvenido a BinaryTEC</h1>
            <p class="fs-4 col-md-10 mx-auto">Somos una empresa dedicada a ofrecer soluciones y reparaciones tecnológicas de confianza. Si tienes un problema, nosotros tenemos la solución. Puede hacer su solicitud ahora mismo para que nuestro equipo lo atienda a la brevedad.</p>
            
            <!-- Botón de Solicitud con enlace al controlador de productos -->
            <a class="btn btn-primary btn-lg mt-4 custom-btn" href="../index.php?accion=crear" role="button">
                Solicitud de Reparación
            </a>
        </div>
    </div>

    <!-- Sección "Sobre Nosotros" -->
    <div class="row align-items-md-stretch">
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

</div>

<?php
// El controlador también se encargará de cargar el footer.
// Por ejemplo: include 'views/includes/footer.php';
?>