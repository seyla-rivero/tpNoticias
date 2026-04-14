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
        padding:30px;
        border-radius:10px;
        width:600px;
    ">

        <h3 style="
          margin-top:0;
          margin-bottom:15px;
          padding-bottom:10px;
          border-bottom:1px solid #bbb;
    ">
        Crear Noticia
        </h3>
        

        <form id="formNoticia" method="post" action="/app_tp1/public/noticias/guardar" enctype="multipart/form-data">

            <!-- TITULO -->
            <label><b>Título:</b></label><br>
            <input type="text"  id="titulo" name="titulo" class="<?= session('errors.titulo') ? 'input-error' : '' ?>" style="
                width:100%;
                padding:10px;
                border-radius:8px;
                box-sizing:border-box;
                margin-top:5px;
                margin-bottom:15px;
            ">
            <?php if (session('errors.titulo')): ?>
            <p style="color:red; font-size:14px;">
               <?= session('errors.titulo') ?>
            </p>
            <?php endif; ?>

            <!-- DESCRIPCION -->
            <label><b>Descripción:</b></label><br>
            <textarea name="descripcion" class="<?= session('errors.titulo') ? 'input-error' : '' ?>" style="
                width:100%;
                padding:10px;
                border-radius:8px;
                box-sizing:border-box;
                margin-top:5px;
                margin-bottom:15px;
            "></textarea>
            <?php if (session('errors.descripcion')): ?>
            <p style="color:red; font-size:14px;">
                <?= session('errors.descripcion') ?>
            </p>
            <?php endif; ?>

            <!-- IMAGEN -->
            <label><b>Insertar imagen:</b></label><br>
            <div style="
                background:white;
                height:150px;
                border-radius:10px;
                display:flex;
                justify-content:center;
                align-items:center;
                margin-top:10px;
                margin-bottom:40px;
            ">
                <input type="file" id="imagen" name="imagen">
            </div>

            <!-- BOTONES -->
            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-top:40px;
            ">

                <a href="/app_tp1/public/noticias" style="text-decoration:none; color:black;">
                    ← Volver
                </a>

                <div style="display:flex; gap:10px;">
                    <button class="btn btn-guardar" type="submit" name="accion" value="guardar">
                    Guardar cambios
                    </button>

                    <button class="btn btn-validar" type="submit" name="accion" value="validar">
                    Enviar a validación
                    </button>

                    <button class="btn btn-anular" type="button">
                    Anular
                    </button>
                </div>

            </div>

        </form>
                <!-- EL MODAL DE GUARDAR CAMBIOS -->
        <div id="modalError" class="modal">
        <div class="modal-content">
            <h2>Atención</h2>
            <p>Llene todos los campos</p>
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
  let titulo = document.getElementById("titulo").value;
  let imagen = document.getElementById("imagen").value;

  if (titulo === "" || imagen === "") {
    e.preventDefault();
    mostrarModal();
  }
});
</script>        

<?= $this->endSection() ?>
