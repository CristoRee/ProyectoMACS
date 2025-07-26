<?php 
// session_start();
// if (!isset($_SESSION['usuario'])) {
//     header("Location: index.php?accion=login");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'CRUD Productos' ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    
    <!-- CSS personalizado -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">CRUD Productos</a>
            <div class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <span class="navbar-text me-3">
                        Hola, <?= htmlspecialchars($_SESSION['usuario']) ?> (<?= htmlspecialchars($_SESSION['rol']) ?>)
                    </span>
                    <a class="nav-link" href="index.php?accion=logout">Salir</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">