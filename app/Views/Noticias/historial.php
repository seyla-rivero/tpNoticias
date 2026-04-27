<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<div class="main-content">
<h2 class="titulo-seccion">Historial de la Noticia</h2>


<?php
function colorEstado($estado) {
    return match($estado) {
        'Creada' => '#6c757d',
        'Borrador' => '#f0ad4e',          
        'Lista para Validación' => '#4a90e2', 
        'Para Corrección' => '#f39c12',   
        'Publicada' => '#28a745',         
        'Anulada' => '#dc3545',           
        default => '#999'
    };
}
?>
<?php
function iconoEstado($estado) {
    return match($estado) {
        'Creada' => '<img src="' . base_url('img/creada.png') . '" width="12">',
        'Borrador' => '<img src="' . base_url('img/borrador.png') . '" width="12">',
        'Lista para Validación' => '<img src="' . base_url('img/validacion.png') . '" width="12">',
        'Para Corrección' => '<img src="' . base_url('img/correccion.png') . '" width="12">',
        'Publicada' => '<img src="' . base_url('img/publicado.png') . '" width="12">',
        'Anulada' => '<img src="' . base_url('img/anulado.png') . '" width="12">',
        default => '<img src="' . base_url('img/punto.png') . '" width="12">',
    };
}
?>
<div class="timeline">

<?php foreach ($historial as $h): ?>

    <div class="timeline-item">

        <div class="timeline-dot" style="background: <?= colorEstado($h['estado_nuevo']) ?>;"></div>

        <div class="timeline-card">

            <div class="timeline-header">
            
            <div style="display:flex; align-items:center; gap:10px;">
                <div class="timeline-avatar"> 
                    <?= strtoupper(substr($h['nombre'], 0, 1)) ?> 
                </div>

                <strong><?= $h['nombre'] ?></strong>
            </div>

            <span><?= date('d M Y - H:i', strtotime($h['fecha'])) ?></span>
        </div>

            <div class="timeline-estado">

                <span style="
                    background: <?= colorEstado($h['estado_anterior']) ?>20;
                    color: <?= colorEstado($h['estado_anterior']) ?>;
                    padding:5px 10px;
                    border-radius:10px;
                    font-size:13px;
                ">
                    <?= iconoEstado($h['estado_anterior']) ?> <?= $h['estado_anterior'] ?>
                </span>

                <img src="<?= base_url('img/flecha-historial.png') ?>" width="12">

                <span style="
                    background: <?= colorEstado($h['estado_nuevo']) ?>20;
                    color: <?= colorEstado($h['estado_nuevo']) ?>;
                    padding:5px 10px;
                    border-radius:10px;
                    font-size:13px;
                    font-weight:bold;
                ">
                    <?= iconoEstado($h['estado_nuevo']) ?> <?= $h['estado_nuevo'] ?>
                </span>

            </div>

        </div>

    </div>

<?php endforeach; ?>

</div>
</div>

<?= $this->endSection() ?>