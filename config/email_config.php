<?php

require_once('secreto.php');

return [
    'smtp' => [
        'host' => 'smtp.gmail.com',
        'port' => 587,
        'user' => 'binarytecnotification@gmail.com',          // CAMBIAR: Tu email de Gmail
        'pass' => contrasena,          // CAMBIAR: Tu contraseña de aplicación (16 caracteres)
        'from_email' => 'binarytecnotification@gmail.com',
        'from_name' => 'binarytec',
        'secure' => 'tls',
        'auth' => true
    ],
    'notifications' => [
        'admin_email' => 'binarytecnotification@gmail.com', // CAMBIAR: Email donde recibirá notificaciones importantes
        'enabled' => true
    ]
];
