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
</head>
<body style="margin:0; font-family: Arial;">

    <!-- Header -->
    <?= view('components/header') ?>
    <?= view('components/menu') ?>

    <!-- CONTENIDO -->
    <div style="padding: 30px; background: #2F4A8A; min-height: 100vh;">
        <?= $this->renderSection('contenido') ?>
    </div>
    <!-- Modal de Login y Registro-->
    <?= view('components/modals') ?>

    <!-- Script de Login y Registro-->
    <?= view('components/scripts') ?>

</body>
</html>

