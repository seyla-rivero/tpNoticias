<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<div class="contenedor-editar">

    <div class="card-editar">

        <!-- TITULO -->
        <h3 class="titulo-editar">
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

            <div class="imagen-contenedor-editar">
            

                <!-- Imagen actual -->
                <?php if (!empty($noticia['imagen'])): ?>
                   <img id="preview"
                    src="/app_tp1/public/uploads/<?= $noticia['imagen'] ?>" 
                    class="preview-img-editar">
                        
                <?php else: ?>
                    <div class="sin-imagen-editar">
                        Sin imagen
                    </div>
                <?php endif; ?>

                <!-- Botón cambiar imagen -->
            <label class="btn btn-validar" style="cursor:pointer;">
                Cambiar imagen
                <input type="file" name="imagen" style="display:none;">
            </label>
            <span id="nombreImagen" style="margin-left:10px;"></span>

            <label class="checkbox-editar">
                <input type="checkbox" name="eliminar_imagen" value="1">
                Quitar imagen
            </label>

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