<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>
<?php $errors = session()->get('errors'); ?>
<div class="reset-container">
    <div class="modal-content">
        <h2>Nueva contraseña</h2>
        <form action="<?= base_url('reset_password') ?>" method="post">
            <?= csrf_field() ?>

            <input type="hidden" name="token" value="<?= $token ?>">

            <div class="input-container">
                <input type="password" name="password" id="newPassword"
                    placeholder="Nueva contraseña" class="form-input">
                <i class="fa-solid fa-eye toggle-eye"
                onclick="togglePassword('newPassword', this)"></i>
            </div>
            <?php if (isset($errors['password'])): ?>
                <div class="error-text">
                    <?= $errors['password'] ?>
                </div>
            <?php endif; ?>

            <div class="input-container">
                <input type="password" name="confirmar" id="confirmPassword"
                    placeholder="Confirmar contraseña" class="form-input">
                <i class="fa-solid fa-eye toggle-eye"
                onclick="togglePassword('confirmPassword', this)"></i>
            </div>
            <?php if (isset($errors['confirmar'])): ?>
                <div class="error-text">
                    <?= $errors['confirmar'] ?>
                </div>
            <?php endif; ?>
            <small>La contraseña debe tener al menos 6 caracteres</small>

            <button type="submit" class="btn-modal btn-primario">
                Cambiar contraseña
            </button>

        </form>
    </div>
</div>
<script>
function togglePassword(id, icon) {
    const input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>
<?= $this->endSection() ?>
       