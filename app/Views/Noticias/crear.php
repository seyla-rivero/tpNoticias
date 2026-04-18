<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>
<link rel="stylesheet" href="<?= base_url('css/crear.css') ?>">

<div class="main-content">
<div class="crear-container">
    

    <div class="crear-card">
       
        <h3 class="crear-titulo">Crear Noticia</h3>
        

        <form id="formNoticia" method="post" action="/app_tp1/public/noticias/guardar" enctype="multipart/form-data">

            <!-- TITULO -->
            <label><b>Título:</b></label><br>
            <input type="text" id="titulo" name="titulo"
                value="<?= old('titulo') ?>" 
                class="input <?= session('errors.titulo') ? 'input-error' : '' ?>">
            <?php if (session('errors.titulo')): ?>
            <p class="error">
               <?= session('errors.titulo') ?>
            </p>
            <?php endif; ?>

            <!-- DESCRIPCION -->
            <label><b>Descripción:</b></label><br>
            <textarea name="descripcion"
                class="input <?= session('errors.descripcion') ? 'input-error' : '' ?>"
                ><?= old('descripcion') ?></textarea>
            <?php if (session('errors.descripcion')): ?>
            <p class="error">
                <?= session('errors.descripcion') ?>
            </p>
            <?php endif; ?>

            <!-- IMAGEN -->
            <label><b>Imagen(Opcional)</b></label><br>
             <div class="upload-box">
                <input type="file" id="imagen" name="imagen">
            </div>

            <!-- BOTONES -->
            <div class="acciones">
                
                <a href="/app_tp1/public/noticias" class="volver">
                    ← Volver
                </a>

                <div class="botones">
                    <button class="btn btn-guardar" type="submit" name="accion" value="guardar">
                    Guardar cambios
                    </button>

                    <button class="btn btn-validar" type="submit" name="accion" value="validar">
                    Enviar a validación
                    </button>

                    <button class="btn btn-anular" type="submit" name="accion "value="anular">
                    Cancelar
                    </button>
                </div>

            </div>

        </form>
                <!-- EL MODAL DE GUARDAR CAMBIOS -->
        <div id="modalError" class="modal">
        <div class="modal-content">
            <h2>Atención</h2>
            <p>El título y la descrición son obligatorios.</p>
            <button class="btn-cerrar" onclick="cerrarModal()">Cerrar</button>
        </div>
        </div>

    </div>
      
</div>
</div>
<script>
function mostrarModal() {
  document.getElementById("modalError").style.display = "flex";
}

function cerrarModal() {
  document.getElementById("modalError").style.display = "none";
}

document.getElementById("formNoticia").addEventListener("submit", function(e) {
  let titulo = document.getElementById("titulo").value.trim();
  let descripcion = document.querySelector("textarea[name='descripcion']").value.trim();

  if (titulo === "" || descripcion === "") {
    e.preventDefault();
    mostrarModal();
  }
});
</script>        

<?= $this->endSection() ?>
