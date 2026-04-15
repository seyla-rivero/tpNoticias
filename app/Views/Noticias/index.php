<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>
<div class="main-content">
<form method="get" style="margin-bottom:20px; display:flex; gap:10px;">

    <!-- FILTRO ESTADO -->
    <select name="estado" onchange="this.form.buscar.value=''; this.form.submit()" style="padding:8px; border-radius:8px;">
        <option value="">Todos los estados</option>
        <option value="Borrador" <?= ($_GET['estado'] ?? '') == 'Borrador' ? 'selected' : '' ?>>Borrador</option>
        <option value="Lista para Validación" <?= ($_GET['estado'] ?? '') == 'Lista para Validación' ? 'selected' : '' ?>>Validación</option>
        <option value="Para Corrección" <?= ($_GET['estado'] ?? '') == 'Para Correción' ? 'selected' : '' ?>>Corrección</option>
        <option value="Publicada" <?= ($_GET['estado'] ?? '') == 'Publicada' ? 'selected' : '' ?>>Publicada</option>
        <option value="Expirada" <?= ($_GET['estado'] ?? '') == 'Expirada' ? 'selected' : '' ?>>Expirada</option>
        <option value="Anulada" <?= ($_GET['estado'] ?? '') == 'Anulada' ? 'selected' : '' ?>>Anulada</option>
    </select>

    <!-- BUSCADOR -->
    <input type="text" name="buscar" placeholder="Buscar noticia..." onkeydown="if(event.key==='Enter'){ this.form.estado.value=''; }" 
        value="<?= $_GET['buscar'] ?? '' ?>"
        style="padding:8px; border-radius:8px; flex:1;">

</form>


<h1 style="margin-bottom:20px;">Mis Noticias</h1>

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
        <div style="width:120px;"></div>
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
                <?php
                    $color = "#eee";

                    switch ($noticia['estado']) {
                        case 'Borrador': $color = "#fff3cd"; break;
                        case 'Lista para Validación': $color = "#dbeafe"; break;
                        case 'Publicada': $color = "#c8e6c9"; break;
                        case 'Para Corrección': $color = "#f8d7da"; break;
                        case 'Anulada': $color = "#f5c6cb"; break;
                        case 'Expirada': $color = "#d6d8db"; break;
                    }
                ?>

                <span style="
                    background:<?= $color ?>;
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

            <!-- BOTON -->
            <div style="width:120px; text-align:right;">
                <a href="/noticias/ver/<?= $noticia['id'] ?>" style="
                    background:#5c6bc0;
                    color:white;
                    padding:8px 12px;
                    border-radius:8px;
                    text-decoration:none;
                    font-size:13px;
                ">
                    Ver detalle
                </a>
            </div>

        </div>

    <?php endforeach; ?>

</div>
</div>

<?= $this->endSection() ?>