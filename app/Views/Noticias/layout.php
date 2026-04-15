<!DOCTYPE html>
<html>
<head>
    <title>Panel</title>
    <link rel="stylesheet" href="/app_tp1/public/css/crear.css">
    <link rel="stylesheet" href="/app_tp1/public/css/MisNoticias.css">
</head>
<body style="margin:0; font-family: Arial;">

    <!-- HEADER -->
    <?= view('components/header') ?>

    <!-- CONTENIDO -->
    <div style="padding: 30px; background: #2F4A8A; min-height: 100vh;">
        <?= $this->renderSection('contenido') ?>
    </div>

   <div id="loginModal" style="
    display:none;
    position:fixed;
    top:65px;
    left:0;
    width:100%;
    height:calc(100% - 65px);
    background:#2F4A8A;
    justify-content:center;
    align-items:center;
    z-index:3000;
">

    <div style="
        background:#e6e6e6;
        padding:40px 30px;
        border-radius:15px;
        width:380px;
        text-align:center;
        border:3px solid #3bb3ff;
        box-shadow:0 10px 25px rgba(0,0,0,0.2);
        position:relative;
    ">

        <!-- CERRAR -->
        <span onclick="cerrarLogin()" style="
            position:absolute;
            top:10px;
            right:15px;
            cursor:pointer;
            font-size:18px;
        ">✖</span>

        <!-- LOGO -->
        <img src="/app_tp1/public/img/logo-noticias.png"
             style="width:80px; margin-bottom:15px;">

        <h2 style="margin-bottom:25px;">
            GESTIÓN DE NOTICIAS
        </h2>

        <!-- BOTONES -->
        <div style="margin:20px 0;">

            <button onclick="abrirRegistro()" style="
                width:100%;
                padding:14px;
                background:#3b6eea;
                color:white;
                border:none;
                border-radius:12px;
                margin-bottom:15px;
                font-size:16px;
                box-shadow:0 4px 10px rgba(0,0,0,0.2);
                cursor:pointer;
            ">
                Registrarse
            </button>

            <button onclick="abrirLoginForm()" style="
                width:100%;
                padding:14px;
                background:#e6e6e6;
                border:2px solid #3b6eea;
                border-radius:12px;
                font-size:16px;
                cursor:pointer;
            ">
                Iniciar sesión
            </button>

        </div>

    </div>
</div>
<div id="loginFormModal" style="
    display:none;
    position:fixed;
    top:65px;
    left:0;
    width:100%;
    height:calc(100% - 65px);
    background:#2F4A8A;
    justify-content:center;
    align-items:center;
    z-index:3000;
">

    <div style="
        background:#e6e6e6;
        padding:40px 30px;
        border-radius:15px;
        width:380px;
        text-align:center;
        border:3px solid #3bb3ff;
        box-shadow:0 10px 25px rgba(0,0,0,0.2);
        position:relative;
    ">

        <span onclick="cerrarLoginForm()" style="float:right; cursor:pointer;">✖</span>

        <!-- LOGO -->
        <img src="/app_tp1/public/img/logo-noticias.png"
             style="width:80px; margin-bottom:15px;">

        <h2 style="margin-bottom:25px;">
            GESTIÓN DE NOTICIAS
        </h2>

        <?= view('components/login_form') ?>

    </div>

</div>
<div id="registroModal" style="
    display:none;
    position:fixed;
    top:65px;
    left:0;
    width:100%;
    height:calc(100% - 65px);
    background:#2F4A8A;
    justify-content:center;
    align-items:center;
    z-index:3000;
">

    <div style="
        background:#e6e6e6;
        padding:40px 30px;
        border-radius:15px;
        width:350px;
        text-align:center;
        border:3px solid #3bb3ff;
        box-shadow:0 10px 25px rgba(0,0,0,0.2);
        position:relative;
    ">

        <span onclick="cerrarRegistro()" style="float:right; cursor:pointer;">✖</span>

        <!-- LOGO -->
        <img src="/app_tp1/public/img/logo-noticias.png"
             style="width:80px; margin-bottom:15px;">

        <h2 style="margin-bottom:25px;">
            GESTIÓN DE NOTICIAS
        </h2>

        <?= view('components/register_form') ?>

    </div>

</div>
</body>
</html>

<script>
function abrirLogin() {
    document.getElementById("loginModal").style.display = "flex";
}

function cerrarLogin() {
    document.getElementById("loginModal").style.display = "none";
}

function abrirLoginForm() {
    cerrarLogin();
    document.getElementById("loginFormModal").style.display = "flex";
}

function cerrarLoginForm() {
    document.getElementById("loginFormModal").style.display = "none";
}

function abrirRegistro() {
    cerrarLogin();
    document.getElementById("registroModal").style.display = "flex";
}

function cerrarRegistro() {
    document.getElementById("registroModal").style.display = "none";
}
</script>
