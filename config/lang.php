<?php
function __($key) {
    static $translations = null;
    
    if ($translations === null) {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'es';
        $langFile = __DIR__ . '/../lang/' . $lang . '.json';
        
        if (file_exists($langFile)) {
            $translations = json_decode(file_get_contents($langFile), true);
        } else {
            // Fallback to es
            $fallbackFile = __DIR__ . '/../lang/es.json';
            $translations = file_exists($fallbackFile) ? json_decode(file_get_contents($fallbackFile), true) : [];
        }
    }
    
    return isset($translations[$key]) ? $translations[$key] : $key;
}
?>
