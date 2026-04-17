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
        <div style="flex:1; display:flex; gap:8px; justify-content:flex-end;">
    <?php if (session()->get('rol_editor')): ?>

    <?php if ($noticia['estado'] == 'Borrador'): ?>

        <form method="post" action="<?= base_url('noticias/detalle/' .  $noticia['id']) ?>"> <button class="btn btn-azuloscuro" name="accion" value="ver">
                Ver detalle
            </button>
        </form>  

        <form method="post" action="<?= base_url('noticias/editar/' . $noticia['id']) ?>">
            <button class="btn btn-gris" name="accion" value="editar">
                Editar
            </button>
        </form>    

        <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
            <button class="btn btn-azul" name="accion" value="validar">
                Enviar a Validación
            </button>

        </form>

         <form method="post"  action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
            <button class="btn btn-rojo" name="accion" value="anular">
                Anular
            </button>
        </form>

    <?php elseif ($noticia['estado'] == 'Para Corrección'): ?>

        <a href="/noticias/editar/<?= $noticia['id'] ?>" style="
            background:#ffa726;
            color:white;
            padding:6px 10px;
            border-radius:8px;
            text-decoration:none;
            font-size:12px;
        ">Editar</a>
            <!-- REENVIAR A VALIDACIÓN -->
        <form method="post" action="/noticias/cambiarEstado/<?= $noticia['id'] ?>">
            <button name="accion" value="validar" style="
                background:#42a5f5;
                color:white;
                padding:6px 10px;
                border:none;
                border-radius:8px;
                font-size:12px;
                cursor:pointer;
            ">Reenviar</button>
        </form>

    <?php else: ?>

       <form method="post" action="<?= base_url('noticias/detalle/' .  $noticia['id']) ?>"> <button class="btn btn-azuloscuro" name="accion" value="ver">
                Ver detalle
            </button>
        </form>  

    <?php endif; ?>
    <?php else: ?>

    <!-- Si NO es editor, solo puede ver -->
    <form method="post" action="<?= base_url('noticias/detalle/' .  $noticia['id']) ?>">     <button class="btn btn-azuloscuro" name="accion" value="ver">
        Ver detalle
    </button>
    </form>  

<?php endif; ?>

</div>
        </div>

    <?php endforeach; ?>

</div>
</div>

<?= $this->endSection() ?>