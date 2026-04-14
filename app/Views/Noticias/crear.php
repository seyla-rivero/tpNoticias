<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<h2>Crear Noticia</h2>

<div style="background: white; padding: 20px; border-radius: 10px; width: 500px;">

<form method="post" action="/app_tp1/public/noticias/guardar">

    <label>Título:</label><br>
    <input type="text" name="titulo" style="width:100%; padding:8px;"><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" style="width:100%; padding:8px;"></textarea><br><br>

    <div style="display:flex; gap:10px;">
        <button style="background: green; color:white; padding:10px;">
            Guardar cambios
        </button>

        <button type="button" style="background: blue; color:white; padding:10px;">
            Enviar a validación
        </button>

        <button type="button" style="background: red; color:white; padding:10px;">
            Anular
        </button>
    </div>

</form>

</div>

<?= $this->endSection() ?>