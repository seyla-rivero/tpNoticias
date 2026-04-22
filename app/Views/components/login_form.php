<?php 
$validation = session('validation');
$emailError = $validation ? $validation->getError('email') : null;
$passwordError = $validation ? $validation->getError('password') : null;
?>

<?php if (session()->getFlashdata('error_login') && !$emailError && !$passwordError): ?>
    <div class="error-text">
        <?= session()->getFlashdata('error_login') ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= site_url('login') ?>">
    <?= csrf_field() ?>

    <input type="text" name="email" placeholder="Correo Electrónico" value="<?= old('email') ?>" 
        class="form-input">
           <?php if ($validation && $validation->getError('email')): ?>
    <div class="error-text">
        <?= $validation->getError('email') ?>
    </div>
<?php endif; ?>

    <input type="password" name="password" placeholder="Contraseña"
           class="form-input">
           <?php if ($validation && $validation->getError('password')): ?>
    <div class="error-text">
        <?= $validation->getError('password') ?>
    </div>
<?php endif; ?>

    <button type="submit" class="btn-modal btn-primario">
        Ingresar
    </button>

</form>
