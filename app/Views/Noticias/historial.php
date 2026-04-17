<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<div class="main-content">
<h2 style="color:white;">Historial de la Noticia</h2>


<?php
function colorEstado($estado) {
    return match($estado) {
        'Borrador' => '#f0ad4e',          
        'Lista para Validación' => '#4a90e2', 
        'Para Corrección' => '#f39c12',   
        'Publicada' => '#28a745',         
        'Anulada' => '#dc3545',           
        default => '#999'
    };
}
?>
<div class="timeline">

<?php foreach ($historial as $h): ?>

    <div class="timeline-item">

        <!-- circulito -->
        <div class="timeline-dot" style="background: <?= colorEstado($h['estado_nuevo']) ?>;"></div>

        <!-- tarjeta -->
        <div class="timeline-card">

            <div class="timeline-header">
                <strong><?= $h['nombre'] ?></strong>
                <span><?= date('d/m/Y H:i', strtotime($h['fecha'])) ?></span>
            </div>

            <div class="timeline-estado">

                <!-- estado anterior -->
                <span style="
                    background: <?= colorEstado($h['estado_anterior']) ?>20;
                    color: <?= colorEstado($h['estado_anterior']) ?>;
                    padding:5px 10px;
                    border-radius:10px;
                    font-size:13px;
                ">
                    <?= $h['estado_anterior'] ?>
                </span>

                →

                <!-- estado nuevo -->
                <span style="
                    background: <?= colorEstado($h['estado_nuevo']) ?>20;
                    color: <?= colorEstado($h['estado_nuevo']) ?>;
                    padding:5px 10px;
                    border-radius:10px;
                    font-size:13px;
                    font-weight:bold;
                ">
                    <?= $h['estado_nuevo'] ?>
                </span>

            </div>

        </div>

    </div>

<?php endforeach; ?>

</div>
</div>

<?= $this->endSection() ?>