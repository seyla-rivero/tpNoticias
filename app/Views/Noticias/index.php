<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<h1>Noticias</h1>

<a href="/app_tp1/public/noticias/crear">
    <button style="padding:10px; margin-bottom:20px;">+ Crear Noticia</button>
</a>

<?php foreach ($noticias as $noticia): ?>

    <div style="background:white; padding:15px; margin-bottom:10px; border-radius:8px;">
        <h3><?= $noticia['titulo'] ?></h3>
        <p><?= $noticia['descripcion'] ?></p>
        <small>Estado: <?= $noticia['estado'] ?></small>
    </div>

<?php endforeach; ?>

<?= $this->endSection() ?>