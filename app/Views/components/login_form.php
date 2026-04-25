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

    <div class="input-container">
        <input type="password" id="loginPassword" name="password" placeholder="Contraseña"  class="form-input">
            <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('loginPassword',  this)"></i>
    </div>  
    
    <div class="forgot-password">
        <a href="#" onclick="abrirModalRecuperar(); return false;">
            ¿Olvidaste la contraseña?
        </a>
    </div>      
            <?php if ($validation && $validation->getError('password')): ?>
                <div class="error-text">
                    <?= $validation->getError('password') ?>
                </div>
            <?php endif; ?>

    <button type="submit" class="btn-modal btn-primario">
        Ingresar
    </button>

</form>
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
