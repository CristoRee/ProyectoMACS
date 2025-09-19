<?php
require_once 'models/Estado.php'; 

class EstadoController {

    private $model;

    public function __construct() {
        $this->model = new Estado();
    }

    
    public function crear() {
        include 'views/includes/header.php';
        include 'views/estado/';
        include 'views/includes/footer.php';
    }

    

}
