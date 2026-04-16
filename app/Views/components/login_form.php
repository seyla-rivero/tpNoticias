<?php $errors = session()->getFlashdata('errors') ?? []; ?>
<form method="post" action="<?= base_url('login') ?>">

    <input type="email" name="email" placeholder="Correo Electrónico" value="<?= old('email') ?>" 

           style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;">
            <?php if (isset($errors['email'])): ?>
            <div style="color:red; font-size:12px;">
                <?= $errors['email'] ?>
            </div>
        <?php endif; ?>

    <input type="password" name="password" placeholder="Contraseña"
           style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;">
            <?php if (isset($errors['password'])): ?>
            <div style="color:red; font-size:12px;">
                <?= $errors['password'] ?>
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
        Ingresar
    </button>

</form>