<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<div class="main-content">

    <h2 class="titulo-config">Configuración</h2>

    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif; ?>

    <div class="card-config">

        <form action="<?= base_url('noticias/configuracion/guardar') ?>" method="post">

            <!-- 🔹 DÍAS -->
            <div class="config-item">
                <label>Cantidad de días para expirar una noticia</label>

                <div class="input-group">
                    <input type="number" name="dias_expiracion"
                        value="<?= $config['dias_expiracion'] ?>" required>
                    <span>días</span>
                </div>

                <small>Duración en días antes que una noticia expire automáticamente.</small>
            </div>

            <hr>

            <!-- 🔹 IMAGEN -->
            <div class="config-item">
                <label>Tamaño máximo de imagen</label>

                <div class="input-group">
                    <input type="number" name="max_imagen"
                        value="<?= $config['max_imagen'] ?>" required>
                    <span>MB</span>
                </div>

                <small>Tamaño máximo permitido para imágenes.</small>
            </div>

            <!-- 🔘 BOTÓN -->
            <div class="config-actions">
                <button type="submit">Guardar Cambios</button>
            </div>

        </form>

    </div>

</div>
<?= $this->endSection() ?>