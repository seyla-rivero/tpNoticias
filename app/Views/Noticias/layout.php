<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link rel="stylesheet" href="/app_tp1/public/css/crear.css">
    <link rel="stylesheet" href="/app_tp1/public/css/MisNoticias.css">
</head>
<body style="margin:0; font-family: Arial;">

    <!-- HEADER -->
    <?= view('components/header') ?>

    <!-- CONTENIDO -->
    <div style="padding: 30px; background: #2F4A8A; min-height: 100vh;">
        <?= $this->renderSection('contenido') ?>
    </div>

</body>
</html>