<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>
<div class="main-content">
<form method="get" style="margin-bottom:20px; display:flex; gap:10px;">
<!-- BUSCADOR -->
    <input type="text" name="buscar" placeholder="Buscar noticia..." onkeydown="if(event.key==='Enter'){ this.form.estado.value=''; }" 
        value="<?= $_GET['buscar'] ?? '' ?>"
        style="padding:8px; border-radius:8px; flex:1;">

</form>

 <h1 style="margin-bottom:20px;">Noticias para Validar</h1>

<div style="
    background:#eee;
    padding:20px;
    border-radius:12px;
">

    <!-- CABECERA -->
    <div style="
        display:flex;
        font-weight:bold;
        margin-bottom:10px;
        color:#555;
    ">
        <div style="flex:2;">Título</div>
        <div style="flex:1;">Estado</div>
        <div style="flex:1;">Creación</div>
        <div style="width:220px;"></div>
    </div>

    <?php foreach ($noticias as $noticia): ?>

        <div style="
            background:white;
            padding:15px;
            margin-bottom:10px;
            border-radius:10px;
            display:flex;
            align-items:center;
        ">

            <!-- TITULO -->
            <div style="flex:2; font-weight:600;">
                <?= $noticia['titulo'] ?>
            </div>

            <!-- ESTADO -->
            <div style="flex:1;">
                <span style="
                    background:#dbeafe;
                    padding:6px 12px;
                    border-radius:8px;
                    font-size:13px;
                    font-weight:500;
                ">
                    <?= $noticia['estado'] ?>
                </span>
            </div>

            <!-- FECHA -->
            <div style="flex:1; color:#777;">
                <?= date('d/m/Y', strtotime($noticia['fecha_creacion'])) ?>
            </div>

            <!-- BOTONES -->
            <div style="width:220px; text-align:right; display:flex; gap:5px; justify-content:flex-end;">

            <?php if (session()->get('rol_validador')): ?>

                <!-- PUBLICAR -->
                <form method="post" action="/noticias/cambiarEstado/<?= $noticia['id'] ?>">
                    <button name="accion" value="publicar" style="
                        background:#66bb6a;
                        color:white;
                        padding:6px 10px;
                        border:none;
                        border-radius:8px;
                        font-size:12px;
                        cursor:pointer;
                    ">Publicar</button>
                </form>

                <!-- CORREGIR -->
                <form method="post" action="/noticias/cambiarEstado/<?= $noticia['id'] ?>">
                    <button name="accion" value="corregir" style="
                        background:#ffa726;
                        color:white;
                        padding:6px 10px;
                        border:none;
                        border-radius:8px;
                        font-size:12px;
                        cursor:pointer;
                    ">Para Corregir</button>
                </form>

                <?php else: ?>

                <!-- Si no es validador -->
                <span style="color:#999; font-size:12px;">Sin permisos</span>

            <?php endif; ?>

            </div>

        </div>

    <?php endforeach; ?>

</div>
</div>

<?= $this->endSection() ?>