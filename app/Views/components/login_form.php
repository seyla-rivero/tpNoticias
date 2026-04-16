<?php 
$validation = session('validation');
$emailError = $validation ? $validation->getError('email') : null;
$passwordError = $validation ? $validation->getError('password') : null;
?>

<?php if (session()->getFlashdata('error_login') && !$emailError && !$passwordError): ?>
    <div style="color:red; margin-bottom:10px;">
        <?= session()->getFlashdata('error_login') ?>
    </div>
<?php endif; ?>
<form method="post" action="<?= site_url('login') ?>">
    <?= csrf_field() ?>

    <input type="text" name="email" placeholder="Correo Electrónico" value="<?= old('email') ?>" 

           style="width:100%;
            padding:12px;
            margin-bottom:5px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;">
           <?php if ($validation && $validation->getError('email')): ?>
    <div style="color:red; font-size:12px;">
        <?= $validation->getError('email') ?>
    </div>
<?php endif; ?>

    <input type="password" name="password" placeholder="Contraseña"
           style="width:100%;
            padding:12px;
            margin-bottom:5px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;">
           <?php if ($validation && $validation->getError('password')): ?>
    <div style="color:red; font-size:12px;">
        <?= $validation->getError('password') ?>
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
