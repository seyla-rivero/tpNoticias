<?= $this->extend('Noticias/layout') ?>

<?= $this->section('contenido') ?>
<div class="main-content">

 <h1 class="titulo-seccion">Noticias para Validar</h1>

<div class="tabla-noticias">

    <!-- CABECERA -->
    <div class="tabla-header">
        <div style="flex:2;">Título</div>
        <div style="flex:1;">Estado</div>
        <div style="flex:1;">Creación</div>
        <div style="flex:2; text-align:right;">Acciones</div>
    </div>

    <?php foreach ($noticias as $noticia): ?>

        <div class="noticia-item">

            <!-- TITULO -->
            <div class="col-titulo">
                <?= $noticia['titulo'] ?>
            </div>

            <!-- ESTADO -->
            <div class="col-estado">
                <span style=" background:#dbeafe; padding:6px 12px; border-radius:8px; font-size:13px; font-weight:500; "> <?= $noticia['estado'] ?> </span>
            </div>

            <!-- FECHA -->
            <div class="col-fecha">
                <?= date('d/m/Y', strtotime($noticia['fecha_creacion'])) ?>
            </div>

            <!-- BOTONES -->
            <div class="col-acciones">

            <?php if (session()->get('rol_validador')): ?>

                <form method="post" action="<?= base_url('noticias/detalle/' .  $noticia['id']) ?>"> <button class="btn btn-azuloscuro" name="accion" value="ver">
                        Ver detalle
                    </button>
                </form>  

                <!-- PUBLICAR -->
                <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                    <button class="btn btn-verde" name="accion" value="publicar">
                                Publicar
                            </button>
                        </form>

                <!-- CORREGIR -->
                <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                           <button class="btn btn-naranja" name="accion" value="correccion">
                        Para Corrección
                    </button>
                </form>

                <?php else: ?>

                <!-- Si no es validador -->
                <span class="sin-permisos">Sin permisos</span>

            <?php endif; ?>

            </div>

        </div>

    <?php endforeach; ?>

</div>
</div>

<?= $this->endSection() ?>