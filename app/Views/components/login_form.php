<form method="post" action="<?= base_url('login') ?>">

    <input type="email" name="email" placeholder="Correo Electrónico"
           style="width:100%; margin:10px 0; padding:10px;">

    <input type="password" name="password" placeholder="Contraseña"
           style="width:100%; margin:10px 0; padding:10px;">

    <button type="submit" style="
        width:100%;
        padding:10px;
        background:#3b6eea;
        color:white;
        border:none;
        border-radius:8px;
    ">
        Ingresar
    </button>

</form>