<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<div style="
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:80vh;
">

    <div style="
        background:#d9d9d9;
        padding:20px 30px 30px 30px;
        border-radius:10px;
        width:600px;
    ">

        <!-- TITULO -->
        <h3 style="
            margin-top:0;
            margin-bottom:15px;
            padding-bottom:10px;
            border-bottom:1px solid #bbb;
        ">
            Editar Noticia
        </h3>
         <!-- ESTADO -->
             <?php
            $color = "#eee";

            switch ($noticia['estado']) {
                case 'Borrador': $color = "#fff3cd"; break;
                case 'Lista para Validación': $color = "#dbeafe"; break;
                case 'Para Corrección': $color = "#f8d7da"; break;
            }
        ?>

            <div style="margin-bottom:15px;">
            <span style="
                font-size:12px;
                padding:5px 10px;
                border-radius:6px;
                background:<?= $color ?>;
            ">
                <?= $noticia['estado'] ?>
            </span>
        </div>
        <form method="post" action="/app_tp1/public/noticias/guardar/<?= $noticia['id'] ?>" enctype="multipart/form-data">

            <!-- TITULO -->
            <label><b>Título:</b></label><br>
            <input type="text" name="titulo" value="<?= $noticia['titulo'] ?>" style="
                width:100%;
                padding:10px;
                border-radius:8px;
                border:none;
                box-sizing:border-box;
                margin-top:5px;
                margin-bottom:15px;
            ">


            <!-- DESCRIPCION -->
            <label><b>Descripción:</b></label><br>
            <textarea name="descripcion" style="
                width:100%;
                padding:10px;
                border-radius:8px;
                border:none;
                box-sizing:border-box;
                margin-top:5px;
                margin-bottom:15px;
            "><?= $noticia['descripcion'] ?></textarea>

            <!-- IMAGEN -->
            <label><b>Imagen</b></label><br>

            <div style="
                display:flex;
                gap:15px;
                align-items:center;
                margin-top:10px;
                margin-bottom:20px;
            ">

                <!-- Imagen actual -->
                <?php if (!empty($noticia['imagen'])): ?>
                   <img id="preview"
                    src="/app_tp1/public/uploads/<?= $noticia['imagen'] ?>" 
                    style="width:150px; height:150px; object-fit:cover; border-radius:10px;">
                        
                <?php else: ?>
                    <div style="
                        width:150px;
                        height:150px;
                        background:#ccc;
                        border-radius:10px;
                        display:flex;
                        justify-content:center;
                        align-items:center;
                    ">
                        Sin imagen
                    </div>
                <?php endif; ?>

                <!-- Botón cambiar imagen -->
            <label class="btn btn-validar" style="cursor:pointer;">
                Cambiar imagen
                <input type="file" name="imagen" style="display:none;">
            </label>
            <span id="nombreImagen" style="margin-left:10px;"></span>

            <label style="display:flex; align-items:center; gap:5px; margin-top:10px;">
                <input type="checkbox" name="eliminar_imagen" value="1">
                Quitar imagen
            </label>

            </div>

            <!-- BOTONES -->
            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-top:20px;
            ">

                <a href="/app_tp1/public/noticias/mis" style="text-decoration:none; color:black;">
                    ← Volver
                </a>

                <div style="display:flex; gap:10px;">

                    <button class="btn btn-guardar" type="submit" name="accion" value="guardar">
                        Guardar cambios
                    </button>

                    <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                    <button class="btn btn-azul" name="accion" value="validar">
                        Enviar a Validación
                    </button>

                    <a href="<?= base_url('noticias') ?>" class="btn btn-anular" style="text-decoration:none;">
                        Cancelar
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>
<script>
// 🔹 Preview cuando selecciona imagen
document.querySelector('input[name="imagen"]').addEventListener('change', function(e) {
    if (e.target.files.length > 0) {
        const file = e.target.files[0];

        // mostrar nombre
        document.getElementById('nombreImagen').innerText = file.name;

        // sacar el check de "eliminar imagen" si estaba marcado
        const checkEliminar = document.querySelector('input[name="eliminar_imagen"]');
        if (checkEliminar) {
            checkEliminar.checked = false;
        }

        // preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// 🔹 Si marca "quitar imagen"
document.querySelector('input[name="eliminar_imagen"]').addEventListener('change', function(e) {
    if (e.target.checked) {
        // borrar preview
        document.getElementById('preview').src = '';

        // limpiar input file
        document.querySelector('input[name="imagen"]').value = '';

        // limpiar nombre
        document.getElementById('nombreImagen').innerText = '';
    }
});
</script>

<?= $this->endSection() ?>