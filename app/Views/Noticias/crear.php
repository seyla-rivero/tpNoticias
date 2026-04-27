<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>
<link rel="stylesheet" href="<?= base_url('css/crear.css') ?>">

<div class="crear-container">
    <div class="crear-card">
       
        <h3 class="crear-titulo">Crear Noticia</h3>
        
        <form id="formNoticia" method="post" action="/app_tp1/public/noticias/guardar" enctype="multipart/form-data">

            <label><b>Título:</b></label><br>
            <input type="text" id="titulo" name="titulo"
                value="<?= old('titulo') ?>" 
                class="input <?= session('errors.titulo') ? 'input-error' : '' ?>">
            <?php if (session('errors.titulo')): ?>
                <p class="error">
                  <?= session('errors.titulo') ?>
                </p>
            <?php endif; ?>

            
            <label><b>Descripción:</b></label><br>
            <textarea name="descripcion" class="input <?= session('errors.descripcion') ? 'input-error' : '' ?>"
                ><?= old('descripcion') ?></textarea>
            <?php if (session('errors.descripcion')): ?>
                <p class="error">
                    <?= session('errors.descripcion') ?>
                </p>
            <?php endif; ?>

            
            <div class="bloque-imagen">
                <label>Imagen (Opcional)</label>

                <div id="drop-area">
                    <p>Arrastrá una imagen acá o hacé click</p>
                    <input type="file" id="imagen" name="imagen" accept="image/*" hidden>
                </div>

                <div class="preview-container">
                    <img id="previewImagen">
                </div>
            </div>

           
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
                
        <div id="modalError" class="modal">
            <div class="modal-content">
                <h2>Atención</h2>
                <p>El título y la descrición son obligatorios.</p>
                <button class="btn-cerrar" onclick="cerrarModal()">Cerrar</button>
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

const dropArea = document.getElementById("drop-area");
const input = document.getElementById("imagen");
const preview = document.getElementById("previewImagen");


dropArea.addEventListener("click", () => input.click());


input.addEventListener("change", (e) => {
  mostrarImagen(e.target.files[0]);
});


dropArea.addEventListener("dragover", (e) => {
  e.preventDefault();
  dropArea.classList.add("activo");
});


dropArea.addEventListener("dragleave", () => {
  dropArea.classList.remove("activo");
});

dropArea.addEventListener("drop", (e) => {
  e.preventDefault();
  dropArea.classList.remove("activo");

  const archivo = e.dataTransfer.files[0];
  input.files = e.dataTransfer.files; 

  mostrarImagen(archivo);
});


function mostrarImagen(file) {
  if (!file || !file.type.startsWith("image/")) return;

  if (file.size > 2 * 1024 * 1024) {
    alert("La imagen es demasiado grande (máx 2MB)");
    return;
  }

  const reader = new FileReader();
  reader.onload = (e) => {
    preview.src = e.target.result;
    preview.style.display = "block";
  };
  reader.readAsDataURL(file);
}

</script>    

<?= $this->endSection() ?>
