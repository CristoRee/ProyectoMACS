<?php
class Language {
    private static $translations = [];
    private static $currentLanguage = 'es';
    
    public static function init() {
        // Establecer idioma por defecto desde la sesión o detectar del navegador
        if (isset($_SESSION['language'])) {
            self::$currentLanguage = $_SESSION['language'];
        } else {
            // Detectar idioma del navegador
            $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'es', 0, 2);
            if (in_array($browserLang, ['es', 'en', 'pt'])) {
                self::$currentLanguage = $browserLang;
            }
            $_SESSION['language'] = self::$currentLanguage;
        }
        
        self::loadTranslations();
    }
    
    public static function setLanguage($language) {
        if (in_array($language, ['es', 'en', 'pt'])) {
            self::$currentLanguage = $language;
            $_SESSION['language'] = $language;
            self::loadTranslations();
        }
    }
    
    public static function getCurrentLanguage() {
        return self::$currentLanguage;
    }
    
    public static function getAvailableLanguages() {
        return [
            'es' => 'Español',
            'en' => 'English',
            'pt' => 'Português'
        ];
    }
    
    private static function loadTranslations() {
        $file = __DIR__ . '/../lang/' . self::$currentLanguage . '.json';
        if (file_exists($file)) {
            $json = file_get_contents($file);
            self::$translations = json_decode($json, true) ?: [];
        } else {
            self::$translations = [];
        }
    }
    
    public static function get($key, $default = null) {
        return self::$translations[$key] ?? $default ?? $key;
    }
}

// Función global para obtener traducciones
function __($key, $default = null) {
    return Language::get($key, $default);
}
?>