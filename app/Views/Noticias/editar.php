<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<div class="crear-container">

    <div class="crear-card">

        <!-- TITULO -->
        <h3 class="crear-titulo">
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

            <div class="estado-contenedor">
            <span class="estado" style="background:<?= $color ?>">
                <?= $noticia['estado'] ?>
            </span>
        </div>
        <form method="post" action="/app_tp1/public/noticias/guardar/<?= $noticia['id'] ?>" enctype="multipart/form-data">

            <!-- TITULO -->
            <label><b>Título:</b></label><br>
            <input type="text" name="titulo" value="<?= $noticia['titulo'] ?>"class="input">


            <!-- DESCRIPCION -->
            <label><b>Descripción:</b></label><br>
            <textarea name="descripcion" class="input"><?= $noticia['descripcion'] ?></textarea>

            <!-- IMAGEN -->
            <label><b>Imagen</b></label><br>
            <div class="bloque-imagen">

            <!-- Preview (solo si hay imagen) -->
            <?php if (!empty($noticia['imagen'])): ?>
                <div class="preview-container">
                    <img id="previewImagen"
                        src="<?= base_url('uploads/' . $noticia['imagen']) ?>">
                </div>
            <?php else: ?>
                <div class="preview-container">
                    <img id="previewImagen" style="display:none;">
                </div>
            <?php endif; ?>

            <!-- Botones SIEMPRE -->
            <div style="margin-top:10px;">

                <label for="inputImagen" class="btn btn-validar">
                    Cambiar imagen
                </label>

                <label class="checkbox-editar">
                    <input type="checkbox" name="quitar_imagen">
                    Quitar imagen
                </label>

            </div>

            <!-- Input -->
            <input type="file" id="inputImagen" name="imagen" hidden>

        </div>
           

            <!-- BOTONES -->
            <div class="acciones">

                <a href="/app_tp1/public/noticias/mis" class="volver">
                    ← Volver
                </a>

                 <div class="botones">
                    <button class="btn btn-guardar" type="submit" name="accion" value="guardar">
                    Guardar cambios
                    </button>

                    <button class="btn btn-validar" type="submit" name="accion" value="validar">
                    Enviar a validación
                    </button>

                    <a href="<?= base_url('noticias/mis') ?>" class="btn btn-gris" style="text-decoration: none;">
                        Cancelar
                    </a>
                </div>

            </div>

        </form>

    </div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {    
// 🔹 Preview cuando selecciona imagen
document.getElementById('inputImagen').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const preview = document.getElementById('previewImagen');

    // si no existe el img (caso sin imagen previa), lo creamos
    if (!preview) {
        const img = document.createElement('img');
        img.id = 'previewImagen';
        img.style.maxWidth = '100%';
        img.style.marginTop = '10px';
        document.querySelector('.preview-container')?.appendChild(img);
    }

    // actualizar preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('previewImagen').src = e.target.result;
        document.getElementById('previewImagen').style.display = 'block';
    }
    reader.readAsDataURL(file);

    // desmarcar "quitar imagen"
    const check = document.querySelector('input[name="quitar_imagen"]');
    if (check) check.checked = false;
});


// 🔹 Si marca "quitar imagen"
const checkEliminar = document.querySelector('input[name="quitar_imagen"]');

if (checkEliminar) {
    checkEliminar.addEventListener('change', function(e) {

        const preview = document.getElementById('previewImagen');

        if (e.target.checked) {
            if (preview) preview.style.opacity = "0.3";

            // limpiar input file
            document.getElementById('inputImagen').value = '';
        } else {
            if (preview) preview.style.opacity = "1";
        }

    });
}
});
</script>


<?= $this->endSection() ?>