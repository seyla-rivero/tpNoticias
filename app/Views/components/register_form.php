<?php $errors = session()->getFlashdata('errors') ?? []; ?>
  
    
<form method="post" action="<?= base_url('registro') ?>">

    <input type="text" name="nombre" placeholder="Nombre" value="<?= old('nombre') ?>"
           style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;">
            <?php if (isset($errors['nombre'])): ?>
    <div style="color:red; font-size:12px; margin-top:-8px; margin-bottom:10px;">
        <?= $errors['nombre'] ?>
    </div>
<?php endif; ?>

    <input type="text" name="email" placeholder="Correo Electrónico" value="<?= old('email') ?>"
           style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;" >
            <?php if (isset($errors['email'])): ?>
            <div style="color:red; font-size:12px; margin-top:-8px; margin-bottom:10px;">
                <?= $errors['email'] ?>
            </div>
            <?php endif; ?>

    <input type="password" name="password" placeholder="Contraseña" 
          style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;" >
            <?php if (isset($errors['password'])): ?>
            <div style="color:red; font-size:12px; margin-top:-8px; margin-bottom:10px;">
                <?= $errors['password'] ?>
            </div>
            <?php endif; ?>

    <input type="password" name="confirmar" placeholder="Confirmar contraseña" 
    style="width:100%;
            padding:12px;
            margin-bottom:15px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;">
            <?php if (isset($errors['confirmar'])): ?>
            <div style="color:red; font-size:12px; margin-top:-8px; margin-bottom:10px;">
                <?= $errors['confirmar'] ?>
            </div>
        <?php endif; ?>

<div style="
    display:flex;
    align-items:center;
    justify-content:center;
    gap:15px;
    margin-bottom:20px;
    font-size:14px;
">

    <span style="font-weight:bold; min-width: 60px;">Roles:</span>

    <label style="
        display:flex;
        align-items:center;
        gap:5px;
        cursor:pointer;
    ">
        <input type="checkbox" name="rol_editor" value="1" >
        Editor
    </label>

    <label style="
        display:flex;
        align-items:center;
        gap:5px;
        cursor:pointer;
    ">
        <input type="checkbox" name="rol_validador" value="1" >
        Validador
    </label>

    <label style="
        display:flex;
        align-items:center;
        gap:5px;
        cursor:pointer;
    ">
        <input type="checkbox" name="rol_ambos" value="1" >
        Editor y Validador
    </label>
    
</div>
    <?php if (session('error_roles')): ?>
        <div style="
            color:red;
            font-size:13px;
            text-align:center;
            margin-top:-10px;
            margin-bottom:15px;
        ">
            <?= session('error_roles') ?>
        </div>
    <?php endif; ?>
       

    <button type="submit" style="
        width:100%;
            padding:12px;
            background:#3b6eea;
            color:white;
            border:none;
            border-radius:10px;
            font-size:16px;
            cursor:pointer;
            box-shadow:0 4px 10px rgba(0,0,0,0.2);
    ">
        Registrarse
    </button>

</form>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const editor = document.querySelector('input[name="rol_editor"]');
    const validador = document.querySelector('input[name="rol_validador"]');
    const ambos = document.querySelector('input[name="rol_ambos"]');

    // Si marca "ambos"
    ambos.addEventListener('change', function () {

        if (ambos.checked) {
            editor.checked = false;
            validador.checked = false;
        }

    });

    // Si marca editor o validador
    editor.addEventListener('change', function () {
        if (editor.checked) {
            ambos.checked = false;
        }
    });

    validador.addEventListener('change', function () {
        if (validador.checked) {
            ambos.checked = false;
        }
    });

});
</script>