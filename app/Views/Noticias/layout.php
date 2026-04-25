<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link rel="stylesheet" href="<?= base_url('css/crear.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/publicadas.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/detalle.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/modals.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/menu.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/header.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body style="margin:0; font-family: Arial;">

    <!-- Header -->
    <?= view('components/header') ?>
    <?= view('components/menu') ?>

    <!-- CONTENIDO -->
    <div style="padding: 30px; background: #f3e8ff; min-height: 100vh;">
        <?= $this->renderSection('contenido') ?>
    </div>
    <!-- Modal de Login y Registro-->
    <?= view('components/modals') ?>
    <?= view('Noticias/recuperar_password') ?>

    <!-- Script de Login y Registro-->
    <?= view('components/scripts') ?>
 
</body>
</html>

