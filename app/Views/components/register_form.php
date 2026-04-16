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
        <input type="checkbox" name="rol_editor" value="editor" >
        Editor
    </label>

    <label style="
        display:flex;
        align-items:center;
        gap:5px;
        cursor:pointer;
    ">
        <input type="checkbox" name="rol_validador" value="validador" >
        Validador
    </label>

</div>
       

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