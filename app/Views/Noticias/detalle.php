<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<div class="detalle-container">

    <div class="detalle-card">
        
        <div class="detalle-header">
            <h2>
                <?= $noticia['titulo'] ?>
            </h2>

           <?php if (
                session()->get('logueado') && 
                (session()->get('rol_editor') || session()->get('rol_validador'))
            ): ?>
                <a href="<?= base_url('noticias/historial/' . $noticia['id']) ?>" class="btn-historial">
                    Ver historial
                </a>
            <?php endif; ?>

        </div>

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

        <div class="detalle-estado">
            <span style="
                background:<?= $color ?>;
            ">
                <?= $noticia['estado'] ?>
            </span>
        </div>
        <div class="detalle-info">

            <span>
                <img src="<?= base_url('img/autor.png') ?>" width="16" style="vertical-align:middle;">
                 <?= $noticia['autor_nombre'] ?? 'Autor' ?>
            </span>

            <span>
                <img src="<?= base_url('img/fecha-icon.png') ?>" width="16" style="vertical-align:middle;">
                Creada: <?= date('d/m/Y', strtotime($noticia['fecha_creacion'])) ?>
            </span>

            <?php if ($noticia['estado'] == 'Publicada'): ?>

            <span>
                <img src="<?= base_url('img/fecha-icon.png') ?>" width="16" style="vertical-align:middle;">
                Publicada: <?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?>
            </span>

            <?php endif; ?>

        </div>

        <div class="detalle-img">

            <?php if ($noticia['imagen']): ?>
                <img src="<?= base_url('uploads/' . $noticia['imagen']) ?>">
            <?php else: ?>
                <div class="sin-imagen">
                    Sin imagen
                </div>
            <?php endif; ?>

        </div>

        <p class="detalle-descripcion">
            <?= $noticia['descripcion'] ?>
        </p>
        <hr>
        <div class="detalle-botones">
            <a href="<?= base_url('noticias') ?>" class="detalle-volver">
                <img src="<?= base_url('img/flecha-volver.png') ?>" width="16" style="vertical-align:middle;">
                Volver
            </a>

            <div class="detalle-acciones">

                <?php if ($noticia['estado'] == 'Borrador'): ?>

                    <form method="post" action="<?= base_url('noticias/editar/' . $noticia['id']) ?>">
                        <button class="btn btn-gris" name="accion" value="editar">
                            Editar
                        </button>
                    </form>

                    <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                        <button type="submit" class="btn btn-azul" name="accion" value="validar">
                            Enviar a Validación
                        </button>

                    </form>

                    <form method="post"  action="<?= base_url('noticias/cambiarEstado/' .$noticia['id']) ?>">
                        <button class="btn btn-rojo" name="accion" value="anular">
                            Anular
                        </button>
                    </form>

                <?php elseif ($noticia['estado'] == 'Para Corrección'): ?>

                    <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                        <button class="btn btn-gris" name="accion" value="editar">
                            Editar
                        </button>
                    </form>
                    
                    <form method="post" action="/noticias/cambiarEstado/<?= $noticia['id'] ?>">
                        <button name="accion" value="validar" class="btn btn-azul"">
                            Reenviar
                        </button>
                    </form>

                <?php elseif ($noticia['estado'] == 'Lista para Validación'): ?>

                    <?php if (session()->get('rol_validador') 
                            && $noticia['autor_id'] != session()->get('id')): ?>

                        <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                            <button class="btn btn-verde" name="accion" value="publicar">
                                Publicar
                            </button>
                        </form>

                        <form method="post" action="<?= base_url('noticias/cambiarEstado/' . $noticia['id']) ?>">
                            <button class="btn btn-naranja" name="accion" value="correccion">
                                Para Corrección
                            </button>
                        </form>

                    <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>