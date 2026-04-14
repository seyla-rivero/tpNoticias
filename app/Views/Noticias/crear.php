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

        <form method="post" action="/app_tp1/public/noticias/guardar" enctype="multipart/form-data">

            <!-- TITULO -->
            <label><b>Título:</b></label><br>
            <input type="text" name="titulo" style="
                width:100%;
                padding:10px;
                border-radius:8px;
                box-sizing:border-box;
                border:none;
                margin-top:5px;
                margin-bottom:15px;
            ">

            <!-- DESCRIPCION -->
            <label><b>Descripción:</b></label><br>
            <textarea name="descripcion" style="
                width:100%;
                padding:10px;
                border-radius:8px;
                box-sizing:border-box;
                border:none;
                margin-top:5px;
                margin-bottom:15px;
            "></textarea>

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
                <input type="file" name="imagen">
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

    </div>

</div>

<?= $this->endSection() ?>