<form method="post" action="<?= base_url('registro') ?>">

    <input type="text" name="nombre" placeholder="Nombre"
           style="width:100%; padding:12px; margin-bottom:15px;" required>

    <input type="email" name="email" placeholder="Correo Electrónico"
           style="width:100%; padding:12px; margin-bottom:15px;" required>

    <input type="password" name="password" placeholder="Contraseña"
          style="width:100%; padding:12px; margin-bottom:15px;" required>

    <input type="password" name="confirmar" placeholder="Confirmar contraseña" 
    style="width:100%; padding:12px; margin-bottom:15px;" required>
    
    <label>
        <input type="checkbox" name="rol_editor"> Editor
    </label>

    <label>
        <input type="checkbox" name="rol_validador"> Validador
    </label>
       

    <button type="submit" style="
        width:100%;
        padding:10px;
        background:#3b6eea;
        color:white;
        border:none;
        border-radius:8px;
        font-size:15px;
    ">
        Registrarse
    </button>

</form>