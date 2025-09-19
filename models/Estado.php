<?php
require_once __DIR__ . '/../config/conexion.php';

class Estado {
    private $db;

    public function __construct() {
        $this->db = conectar();
    }


}
