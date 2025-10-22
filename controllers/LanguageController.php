<?php
class LanguageController {
    public function cambiarIdioma() {
        $method = $_SERVER['REQUEST_METHOD'];
        $lang = 'es';
        if ($method === 'GET') {
            $lang = $_GET['lang'] ?? 'es';
        } elseif ($method === 'POST') {
            $lang = $_POST['lang'] ?? ($_GET['lang'] ?? 'es');
        }
        if (session_status() === PHP_SESSION_NONE) session_start();
        $_SESSION['lang'] = in_array($lang, ['es','en','pt-BR']) ? $lang : 'es';
        $back = $_POST['redirect'] ?? $_SERVER['HTTP_REFERER'] ?? 'index.php?accion=inicio';
        header('Location: ' . $back);
        exit();
    }

    // Alias en inglés para compatibilidad con rutas que usan 'changeLanguage'
    public function changeLanguage() {
        $this->cambiarIdioma();
    }
}
