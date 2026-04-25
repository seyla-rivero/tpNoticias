<?php $error = session()->get('error'); ?>
<?php $success = session()->get('success'); ?>
<div id="modalRecuperar" class="modal">
    <div class="modal-content">
        <h2>Recuperar contraseña</h2>
        <span class="close" onclick="cerrarModalRecuperar()">&times;</span>


            <form action="<?= base_url('recuperar_password') ?>" method="post">
                
                <?= csrf_field() ?>
                
                <input type="email" name="email" placeholder="Tu correo"
                    value="<?= old('email') ?>" required class="form-input">

                <?php if ($error): ?>
                    <div class="error-text"><?= $error ?></div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-text"><?= $success ?></div>
                <?php endif; ?>

                <button type="submit" class="btn-modal btn-primario">
                    Enviar enlace
                </button>

            </form>
    </div>
</div>
 