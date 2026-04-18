<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<div class="main-content">

<h1 class="titulo">Noticias</h1>

<div class="news-grid">

<?php foreach ($noticias as $n): ?>

    <div class="news-card">

        <!-- IMAGEN -->
        <div class="news-img">
            <img src="<?= base_url('uploads/' . ($n['imagen'] ?? 'default.jpg')) ?>" alt="imagen">
        </div>

        <!-- CONTENIDO -->
        <div class="news-body">

            <div class="news-date">
                <?= date('d/m/Y', strtotime($n['fecha_publicacion'])) ?>
            </div>

            <h3 class="news-title">
                <?= $n['titulo'] ?>
            </h3>

            <p class="news-desc">
                <?= substr($n['descripcion'], 0, 100) ?>...
            </p>

            <a href="<?= base_url('noticias/detalle/' . $n['id']) ?>" class="btn-leer">
                Leer más
            </a>

        </div>

    </div>

<?php endforeach; ?>

</div>

</div>

<?= $this->endSection() ?>