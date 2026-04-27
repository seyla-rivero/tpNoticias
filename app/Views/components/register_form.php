<?php $errors = session()->getFlashdata('errors') ?? []; ?>
  
<form method="post" action="<?= base_url('registro') ?>">

    <input type="text" name="nombre" placeholder="Nombre" value="<?= old('nombre') ?>" class="form-input">

    <?php if (isset($errors['nombre'])): ?>
        <div class="error-text">
            <?= $errors['nombre'] ?>
        </div>
    <?php endif; ?>

    <input type="text" name="email" placeholder="Correo Electrónico" value="<?= old('email') ?>" class="form-input">

    <?php if (isset($errors['email'])): ?>
        <div class="error-text">
            <?= $errors['email'] ?>
        </div>
    <?php endif; ?>

    <div class="input-container">
        <input type="password" name="password" placeholder="Contraseña" class="form-input" id="registerPassword">
        <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('registerPassword', this)"></i>
    </div>

    <?php if (isset($errors['password'])): ?>
        <div class="error-text">
            <?= $errors['password'] ?>
        </div>
    <?php endif; ?>

    <div class="input-container">
        <input type="password" name="confirmar" placeholder="Confirmar contraseña" class="form-input" id="confirmPassword">
        <i class="fa-solid fa-eye toggle-eye" onclick="togglePassword('confirmPassword', this)"></i>
    </div>

    <?php if (isset($errors['confirmar'])): ?>
        <div class="error-text">
            <?= $errors['confirmar'] ?>
        </div>
    <?php endif; ?>

<div class="roles-container">

    <span class="roles-title">Roles:</span>

    <label class="roles-label">
       <input type="radio" name="rol" value="editor" <?= old('rol') == 'editor' ? 'checked' : '' ?>>
        Editor
    </label>

    <label class="roles-label">
        <input type="radio" name="rol" value="validador" <?= old('rol') == 'validador' ? 'checked' : '' ?>>
        Validador
    </label>

    <label class="roles-label">
       <input type="radio" name="rol" value="ambos" <?= old('rol') == 'ambos' ? 'checked' : '' ?>>
        Editor y Validador
    </label>
    
</div>
    <?php if (session('error_roles')): ?>
        <div class="error-roles">
            <?= session('error_roles') ?>
        </div>
    <?php endif; ?>
       

    <button type="submit" class="btn-modal btn-primario">
        Registrarse
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