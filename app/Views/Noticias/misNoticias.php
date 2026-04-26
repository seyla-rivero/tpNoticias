<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>

<div class="main-content">
<h1 class="titulo-seccion">Mis Noticias</h1>


<form method="get" class="filtro-form">

    <!-- FILTRO ESTADO -->
    <select name="estado" onchange="this.form.submit()" class="filtro-select">

    <option value=""
        <?= ($estado ?? '') == '' ? 'selected' : '' ?>>
        Todos los estados
    </option>

    <option value="Borrador"
        <?= ($estado ?? '') == 'Borrador' ? 'selected' : '' ?>>
        Borrador
    </option>

    <option value="Lista para Validación"
        <?= ($estado ?? '') == 'Lista para Validación' ? 'selected' : '' ?>>
        Validación
    </option>

    <option value="Para Corrección"
        <?= ($estado ?? '') == 'Para Corrección' ? 'selected' : '' ?>>
        Corrección
    </option>

    <option value="Publicada"
        <?= ($estado ?? '') == 'Publicada' ? 'selected' : '' ?>>
        Publicada
    </option>

    <option value="Expirada"
        <?= ($estado ?? '') == 'Expirada' ? 'selected' : '' ?>>
        Expirada
    </option>

    <option value="Anulada"
        <?= ($estado ?? '') == 'Anulada' ? 'selected' : '' ?>>
        Anulada
    </option>

</select>

</form>

<div class="tabla-noticias">

    <!-- CABECERA -->
    <div class="tabla-header">
        <div style="flex:2;">Título</div>
        <div style="flex:1;">Estado</div>
        <div style="flex:1;">Creación</div>
        <div style="flex:2; text-align:right;">Acciones</div>
    </div>

    <?php foreach ($noticias as $noticia): ?>

        <div  class="noticia-item">

            <!-- TITULO -->
            <div class="col-titulo">
                <?= $noticia['titulo'] ?>
            </div>

            <!-- ESTADO -->
            <div class="col-estado">
                <?php
                    $claseEstado = match($noticia['estado']) {
                        'Borrador' => 'estado-borrador',
                        'Lista para Validación' => 'estado-validacion',
                        'Publicada' => 'estado-publicada',
                        'Para Corrección' => 'estado-correccion',
                        'Anulada' => 'estado-anulada',
                        'Expirada' => 'estado-expirada',
                        default => ''
                    };
                    ?>

                    <span class="estado-badge <?= $claseEstado ?>">
                        <?= $noticia['estado'] ?>
                    </span>
            </div>

            <!-- FECHA -->
            <div class="col-fecha">
                <?= date('d/m/Y', strtotime($noticia['fecha_creacion'])) ?>
            </div>

            <!-- BOTON -->
        <div class="col-acciones">
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

         <form method="post" action="<?= base_url('noticias/editar/' . $noticia['id']) ?>">
            <button class="btn btn-gris" name="accion" value="editar">
                Editar
            </button>
        </form>   
            <!-- REENVIAR A VALIDACIÓN -->
        <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
            <button class="btn btn-azul" name="accion" value="validar">
                Reenviar para Validación
            </button>

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