<?php if (session()->get('logueado')): ?>

<!-- MENÚ LATERAL -->
<div id="sidebar" class="sidebar">

    <h2>Menú</h2>

    <?php if (session()->get('rol_editor')): ?>
        <a href="<?= base_url('noticias') ?>">Inicio</a>
        <a href="<?= base_url('noticias/mis') ?>">📰 Mis Noticias</a>
        <a href="<?= base_url('noticias/crear') ?>">➕ Crear Noticia</a>
    <?php endif; ?>

    <?php if (session()->get('rol_validador')): ?>
        <a href="<?= base_url('noticias') ?>">Inicio</a>
        <a href="<?= base_url('noticias/pendientes') ?>">✔ Noticias para validar</a>
    <?php endif; ?>

    <a href="<?= base_url('noticias/configuracion') ?>">⚙ Configuración</a>

</div>

<!-- OVERLAY -->
<div id="overlay" onclick="toggleMenu()" class="overlay"></div>

<?php endif; ?>
<script>
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    var overlay = document.getElementById("overlay");

    if (!sidebar) return; // evita error si no está logueado

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