<?= $this->extend('Noticias/layout') ?>
<?= $this->section('contenido') ?>

<div style="display:flex; justify-content:center; margin-top:40px;">

    <div style="
        width:800px;
        background:#d9d9d9;
        border-radius:12px;
        padding:20px;
    ">

        <!-- HEADER -->
        <div style="display:flex; justify-content:space-between; align-items:center;">

            <h2 style="margin:0;">
                <?= $noticia['titulo'] ?>
            </h2>

             <?php if (session()->get('logueado')): ?>
                <a href="<?= base_url('noticias/historial/' . $noticia['id']) ?>">
                    Ver historial
                </a>
            <?php endif; ?>

        </div>

        <!-- ESTADO -->
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

        <div style="margin-top:10px;">
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

        <!-- INFO -->
        <div style="
            margin-top:15px;
            padding-top:10px;
            border-top:1px solid #bbb;
            font-size:14px;
            color:#555;
            display:flex;
            gap:20px;
        ">

            <span>👤 <?= $noticia['autor_nombre'] ?? 'Autor' ?></span>

            <span>📅 Creada: <?= date('d/m/Y', strtotime($noticia['fecha_creacion'])) ?></span>

            <?php if ($noticia['estado'] == 'Publicada'): ?>

            <span>
                📅 Publicada: 
                <?= date('d/m/Y', strtotime($noticia['fecha_publicacion'])) ?>
            </span>

            <?php endif; ?>

        </div>

        <!-- IMAGEN -->
        <div style="
            margin-top:20px;
            background:white;
            border-radius:10px;
            overflow:hidden;
        ">

            <?php if ($noticia['imagen']): ?>
                <img src="<?= base_url('uploads/' . $noticia['imagen']) ?>" 
                style="
                    width:100%;
                    max-height:400px;
                    object-fit:cover;
                ">
            <?php else: ?>
                <div style="padding:40px; text-align:center; color:#999;">
                    Sin imagen
                </div>
            <?php endif; ?>

        </div>
        <!-- DESCRIPCIÓN -->
        <p style="margin-top:20px; font-size:14px;">
            <?= $noticia['descripcion'] ?>
        </p>

        <hr>

        <!-- BOTONES -->
        <div style="display:flex; justify-content:space-between; align-items:center;">

            <!-- VOLVER -->
            <?php
            $urlVolver = 'noticias/mis';

            if (session()->get('rol_validador')) {
                $urlVolver = 'noticias/pendientes';
            }
            ?>

            <a href="<?= base_url($urlVolver) ?>" 
            style="text-decoration:none; color:black;">
                ← Volver
            </a>

            <!-- ACCIONES -->
            <div style="display:flex; gap:10px;">

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
                    
                    <form method="post" action="/noticias/cambiarEstado/<?= $noticia['id'] ?>">
                        <button name="accion" value="validar" style="background:#3b82f6; color:white; padding:8px 12px; border:none; border-radius:8px;">
                            Reenviar
                        </button>
                    </form>

                <?php elseif ($noticia['estado'] == 'Lista para Validación'): ?>

                    <?php if (session()->get('rol_validador')): ?>

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

                <?php else: ?>

                    <!--<span style="color:#777;">Sin acciones disponibles</span>-->

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>