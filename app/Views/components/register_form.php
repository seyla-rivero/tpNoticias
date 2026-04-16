<form method="post" action="<?= base_url('registro') ?>">

    <input type="text" name="nombre" placeholder="Nombre"
           style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;" required>

    <input type="email" name="email" placeholder="Correo Electrónico"
           style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;" required>

    <input type="password" name="password" placeholder="Contraseña"
          style="width:100%;
            padding:12px;
            margin-bottom:12px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;" required>

    <input type="password" name="confirmar" placeholder="Confirmar contraseña" 
    style="width:100%;
            padding:12px;
            margin-bottom:15px;
            border-radius:8px;
            border:1px solid #ccc;
            box-sizing:border-box;" required>
    <label><b>Roles:</b></label>
    <!-- ROLES -->
        <div style="
            display:flex;
            justify-content:center;
            gap:20px;
            margin-bottom:20px;
            font-size:14px;
        ">
            <label><input type="checkbox" name="rol[]" value="editor"> Editor</label>
            <label><input type="checkbox" name="rol[]" value="validador"> Validador</label>
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