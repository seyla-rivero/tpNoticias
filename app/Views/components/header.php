<div style="background: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd;">

    <!-- IZQUIERDA -->
    <div style="display: flex; align-items: center; gap: 15px;">
        
        <!-- BOTÓN HAMBURGUESA -->
        <button onclick="toggleMenu()" style="font-size: 22px; background: none; border: none; cursor: pointer;">
            ☰
        </button>
        <!-- LOGO + NOMBRE -->
        <div style="display: flex; align-items: center; gap: 10px;">

        <img src="/app_tp1/public/img/logo-noticias.png"
         alt="Logo"
         style="width: 35px; height: 35px; object-fit: contain;">

        <span style="font-size: 18px; font-weight: bold;">
        Gestion de Noticias
        </span>

</div>

    </div>

    <!-- DERECHA -->
<div style="position: relative; display: flex; align-items: center; gap: 10px;">

<?php if (session()->get('logueado')): ?>

    <!-- AVATAR -->
    <img src="/app_tp1/public/img/avatar.png"
         onclick="toggleUserMenu()"
         style="width:35px; height:35px; border-radius:50%; cursor:pointer;">

    <!-- NOMBRE -->
    <span><?= session()->get('nombre') ?></span>

    <!-- MENU -->
    <div id="userMenu" style="
        display:none;
        position:absolute;
        top:50px;
        right:0;
        background:white;
        border:1px solid #ddd;
        border-radius:10px;
        box-shadow:0 4px 10px rgba(0,0,0,0.15);
        padding:10px;
        min-width:160px;
        z-index:2000;
    ">

        <div style="font-size:12px; color:#888; margin-bottom:5px;">
            Sesión iniciada como
        </div>

        <div style="font-weight:bold; margin-bottom:10px;">
            <?= session()->get('nombre') ?>
        </div>

        <a href="<?= base_url('index.php/logout') ?>" style="
            display:flex;
            align-items:center;
            justify-content:center;
            padding:10px;
            text-decoration:none;
            background:#7e7777;
            color:white;
            border-radius:8px;
            font-size:14px;
            transition:0.2s;
        "
        onmouseover="this.style.background='#3b3838'"
        onmouseout="this.style.background='#7e7777'">

            Cerrar sesión

        </a>

    </div>

<?php else: ?>
   
    <div onclick="abrirLogin()" style="
        display:flex;
        align-items:center;
        gap:8px;
        cursor:pointer;
    ">

        <!-- ICONO -->
        <img src="/app_tp1/public/img/avatar.png"
            style="width:35px; height:35px; border-radius:50%;">

        <!-- TEXTO -->
        <span style="font-weight:500;">
            Iniciar sesión
        </span>

    </div>

<?php endif; ?>

</div>

    <!-- MENÚ DESPLEGABLE -->
    <div id="userMenu" style="
        display: none;
        position: absolute;
        top: 50px;
        right: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        padding: 10px;
        min-width: 150px;
        z-index: 2000;
    ">
    </div>

</div>

</div>

<!-- MENÚ LATERAL DESLIZABLE -->
<div id="sidebar" style="
    position: fixed;
    z-index: 1000;
    top: 65px;
    left: -300px;
    width: 250px;
    height: 100vh;
    background: #1e1e2f;
    color: white;
    padding: 20px;
    transition: 0.3s;
">

    <h2>Menú</h2>

    <a href="/app_tp1/public/noticias" style="display:block; color:white; margin:12px 0; text-decoration:none;">
    📰 Mis Noticias
    </a>

    <a href="/app_tp1/public/noticias/crear" style="display:block; color:white; margin:12px 0; text-decoration:none;">
    ➕ Crear Noticia
    </a>

    <a href="#" style="display:block; color:white; margin:12px 0; text-decoration:none;">
    ⚙ Configuración
    </a>

</div>

<!-- FONDO OSCURO -->
<div id="overlay" onclick="toggleMenu()" style="
    display:none;
    position: fixed;
    top:65px;
    left:0;
    width:100%;
    height:100vh;
    background: rgba(0,0,0,0.5);
    z-index: 500;
"></div>

<script>
function toggleMenu() {
    var sidebar = document.getElementById("sidebar");
    var overlay = document.getElementById("overlay");

    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-300px";
        overlay.style.display = "none";
    } else {
        sidebar.style.left = "0px";
        overlay.style.display = "block";
    }
}
function toggleUserMenu() {
    var menu = document.getElementById("userMenu");

    if (menu.style.display === "block") {
        menu.style.display = "none";
    } else {
        menu.style.display = "block";
    }
}

/* Cerrar si se hace click afuera */
window.addEventListener("click", function(event) {

    var menu = document.getElementById("userMenu");

    if (!event.target.closest("#userMenu") &&
        !event.target.closest("img[onclick='toggleUserMenu()']")) {

        menu.style.display = "none";
    }

});
</script>