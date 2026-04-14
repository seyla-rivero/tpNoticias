<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<h1 style="margin-bottom:20px;">Noticias</h1>

<?php foreach ($noticias as $noticia): ?>

    <div style="
        background:white;
        padding:15px;
        margin-bottom:15px;
        border-radius:10px;
        display:flex;
        gap:15px;
        align-items:flex-start;
    ">

        <!-- IMAGEN -->
        <?php if (!empty($noticia['imagen'])): ?>
            <img src="/app_tp1/public/uploads/<?= $noticia['imagen'] ?>" 
                 style="width:120px; height:120px; object-fit:cover; border-radius:8px;">
        <?php else: ?>
            <div style="
                width:120px;
                height:120px;
                background:#ccc;
                border-radius:8px;
                display:flex;
                justify-content:center;
                align-items:center;
                font-size:12px;
            ">
                Sin imagen
            </div>
        <?php endif; ?>

        <!-- CONTENIDO -->
        <div style="flex:1;">
            <h3 style="margin:0 0 10px 0;">
                <?= $noticia['titulo'] ?>
            </h3>

            <p style="margin-bottom:10px;">
                <?= $noticia['descripcion'] ?>
            </p>

            <span style="
                font-size:12px;
                padding:5px 10px;
                border-radius:6px;
                background:#eee;
            ">
                <?= $noticia['estado'] ?>
            </span>
        </div>

    </div>

<?php endforeach; ?>

<?= $this->endSection() ?>