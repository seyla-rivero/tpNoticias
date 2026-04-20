<div class="header">

    <!-- IZQUIERDA -->
    <div class="header-left">
        
        <?php if (session()->get('logueado')): ?>
            <button class="menu-btn" onclick="toggleMenu()">
                ☰
            </button>
        <?php endif; ?>

        <div class="logo-container">
            <img src="<?= base_url('img/logo-noticias.png') ?>" class="logo">
            <span class="logo-text">Gestion de Noticias</span>
        </div>

    </div>

    <!-- DERECHA -->
    <div class="header-right">

    <?php if (session()->get('logueado')): ?>

        <img src="<?= base_url('img/avatar.png') ?>"
             onclick="toggleUserMenu()"
             class="avatar">

        <span class="user-name"><?= session()->get('nombre') ?></span>

        <div id="userMenu" class="user-menu">

            <div class="user-menu-text">Sesión iniciada como</div>

            <div class="user-menu-name">
                <?= session()->get('nombre') ?>
            </div>

            <a href="<?= base_url('logout') ?>" class="logout-btn">
                Cerrar sesión
            </a>

        </div>

    <?php else: ?>
       
        <div onclick="abrirLogin()" class="login-box">

            <img src="<?= base_url('img/avatar.png') ?>" class="avatar">

            <span class="login-text">
                Iniciar sesión
            </span>

        </div>

    <?php endif; ?>

    </div>

</div>
<script>
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