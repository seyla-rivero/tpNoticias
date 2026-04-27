<?php if (session()->get('logueado')): ?>

<!-- Menu lateral -->
<div id="sidebar" class="sidebar">

    <h2>Menú</h2>

    <?php if (session()->get('rol_editor')): ?>
        <a href="<?= base_url('noticias/mis') ?>" class="icono-menu activo">
            <img src="<?= base_url('img/noticias.png') ?>" width="8" style="vertical-align:middle;" alt="Mis Noticias">
            Mis Noticias
        </a>

        <a href="<?= base_url('noticias/crear') ?>" class="icono-menu">
             <img src="<?= base_url('img/borrador.png') ?>" width="8" style="vertical-align:middle;" alt="Crear Noticia">
            Crear Noticia
        </a>
    <?php endif; ?>

    <?php if (session()->get('rol_validador')): ?>
        <a href="<?= base_url('noticias/pendientes') ?>" class="icono-menu">
            <img src="<?= base_url('img/publicado.png') ?>" width="6" style="vertical-align:middle;" alt="Noticias para validar">
            Noticias para validar</a>
    <?php endif; ?>

    <a href="<?= base_url('noticias/configuracion') ?>" class="icono-menu">
        <img src="<?= base_url('img/confi icon.png') ?>" width="6" style="vertical-align:middle;"  alt="Configuracion">
        Configuración
    </a>

</div>
<!-- Overlay -->
<div id="overlay" onclick="toggleMenu()" class="overlay"></div>

<?php endif; ?>
<script>
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    var overlay = document.getElementById("overlay");

    if (!sidebar) return; 

    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-300px";
        overlay.style.display = "none";
    } else {
        sidebar.style.left = "0px";
        overlay.style.display = "block";
    }
}
</script>
<script>
function toggleMenu() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    if (!sidebar) return;

    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
}
</script>