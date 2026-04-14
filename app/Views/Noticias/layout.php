<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
</head>
<body style="margin:0; font-family: Arial;">

    <!-- HEADER -->
    <?= view('components/header') ?>

    <!-- CONTENIDO -->
    <div style="padding: 30px; background: #f5f5f5; min-height: 100vh;">
        <?= $this->renderSection('contenido') ?>
    </div>

</body>
</html>