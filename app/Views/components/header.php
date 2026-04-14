<div style="background: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd;">

    <!-- IZQUIERDA -->
    <div style="display: flex; align-items: center; gap: 15px;">
        
        <!-- BOTÓN HAMBURGUESA -->
        <button onclick="toggleMenu()" style="font-size: 22px; background: none; border: none; cursor: pointer;">
            ☰
        </button>

        <!-- LOGO / NOMBRE -->
        <span style="font-size: 18px; font-weight: bold;">
            Gestión de Noticias
        </span>

    </div>

    <!-- DERECHA -->
    <div style="display: flex; align-items: center; gap: 10px;">
        <span>Usuario Editor</span>
        <div style="width: 35px; height: 35px; background: #ccc; border-radius: 50%;"></div>
    </div>

</div>

<!-- MENÚ LATERAL DESLIZABLE -->
<div id="sidebar" style="
    position: fixed;
    z-index: 1000;
    top: 60px;
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
    top:60px;
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
</script>