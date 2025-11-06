<?php 
$titulo = __('new_repair_request');

?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0"><?php echo __('enter_new_repair_request'); ?></h3>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted"><?php echo __('complete_all_fields'); ?></p>
                    
                    
                    <form method="POST" action="index.php?accion=guardarSolicitud" enctype="multipart/form-data">
                        
                        <h5 class="mt-4">1. <?php echo __('device_data'); ?></h5>
                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tipo_producto" class="form-label"><?php echo __('device_type'); ?></label>
                                <select class="form-select" id="tipo_producto" name="tipo_producto" required>
                                    <option value="" selected disabled><?php echo __('select_option'); ?></option>
                                    <option value="Computadora"><?php echo __('desktop_computer'); ?></option>
                                    <option value="Laptop"><?php echo __('laptop'); ?></option>
                                    <option value="Celular"><?php echo __('cellphone'); ?></option>
                                    <option value="Tablet"><?php echo __('tablet'); ?></option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marca" class="form-label"><?php echo __('brand'); ?></label>
                                <input type="text" class="form-control" id="marca" name="marca" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="modelo" class="form-label"><?php echo __('model'); ?></label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>

                        <h5 class="mt-4">2. <?php echo __('problem_description'); ?></h5>
                        <hr>

                        <div class="mb-3">
                            <label for="descripcion_problema" class="form-label"><?php echo __('describe_problem_detail'); ?></label>
                            <textarea class="form-control" id="descripcion_problema" name="descripcion_problema" rows="4" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="fotos" class="form-label"><?php echo __('attach_photos'); ?></label>
                            <input class="form-control" type="file" id="fotos" name="fotos[]" multiple>
                            <div class="form-text"><?php echo __('multiple_images_help'); ?></div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="index.php?accion=inicio" class="btn btn-secondary me-md-2"><?php echo __('cancel'); ?></a>
                            <button type="submit" class="btn btn-primary"><?php echo __('send_request'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
