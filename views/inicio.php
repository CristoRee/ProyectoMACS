<?php

?>

<div class="container py-5">

    
    <div class="p-5 mb-4 bg-light rounded-3 text-center shadow-sm">
        <div class="container-fluid py-5">
            <h1 class="display-4 fw-bold">Bienvenido a BinaryTEC</h1>
            <p class="fs-4 col-md-10 mx-auto">Somos una empresa dedicada a ofrecer soluciones y reparaciones tecnológicas de confianza. Si tienes un problema, nosotros tenemos la solución. Puede hacer su solicitud ahora mismo para que nuestro equipo lo atienda a la brevedad.</p>
            
            <a class="btn btn-primary btn-lg mt-4 custom-btn" href="index.php?accion=crear" role="button">
                Solicitud de Reparación
            </a>
        </div>
    </div>

    
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

</div>

<?php 

if (isset($_GET['status']) && $_GET['status'] === 'success'): 
?>

<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center border-0 shadow-lg">
      <div class="modal-body p-5">
        <div class="checkmark-container mx-auto mb-3">
            <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
            </svg>
        </div>
        <h4 class="modal-title fw-bold" id="successModalLabel">Solicitud creada con éxito</h4>
        <p class="text-muted mt-2">Siga su caso en "mis solicitudes".</p>
        <a href="index.php?accion=inicio" class="btn btn-primary mt-3 px-5">Continuar</a>
      </div>
    </div>
  </div>
</div>
<?php 
endif; 
?>
