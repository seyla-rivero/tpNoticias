<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<h1 class="titulo">Noticias de BTS</h1>

<?php if (!empty($noticias)): ?>

    <?php $destacada = $noticias[0]; ?>

    <!-- 🔥 NOTICIA DESTACADA -->
    <div class="featured">

       <div class="featured-img" style="background-image: url('<?= base_url('uploads/' .     ($destacada['imagen'] ?? 'default.jpg')) ?>')">
        </div>

        <div class="featured-body">

            <span class="badge">DESTACADO</span>
            <div class="news-date">
                <?= date('d/m/Y', strtotime($destacada['fecha_publicacion'])) ?>
            </div>

            <h2 class="featured-title">
                <?= $destacada['titulo'] ?>
            </h2>

            <p class="featured-desc">
                <?= substr($destacada['descripcion'], 0, 200) ?>...
            </p>

            <a href="<?= base_url('noticias/detalle/' . $destacada['id']) ?>" class="btn-leer">
                Leer más
            </a>

        </div>

    </div>

    <!-- 🧱 GRID DE NOTICIAS -->
    <div class="news-grid">

        <?php foreach (array_slice($noticias, 1) as $n): ?>

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

<?php else: ?>

    <p>No hay noticias disponibles.</p>

<?php endif; ?>

<?= $this->endSection() ?>