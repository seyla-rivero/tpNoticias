 <!-- Login opcion Registrarse o Iniciar sesion -->
<div id="loginModal" class="modal">

    <div class="modal-box">

        <span onclick="cerrarLogin()" class="modal-close">✖</span>

        <img src="<?= base_url('img/logo-bts.png') ?>" class="modal-logo">

        <h2 class="modal-title">Portal de Noticias de BTS</h2>

        <div class="modal-actions">

            <button onclick="abrirRegistro()" class="btn-modal btn-primario">
                Registrarse
            </button>

            <button onclick="abrirLoginForm()" class="btn-modal btn-secundario">
                Iniciar sesión
            </button>

        </div>

    </div>
</div>


<!-- Login de inicio sesion -->
<div id="loginFormModal" class="modal">

    <div class="modal-box">

        <span onclick="cerrarLoginForm()" class="modal-close">✖</span>

        <img src="<?= base_url('img/logo-bts.png') ?>" class="modal-logo">

        <h2 class="modal-title">Portal de Noticias de BTS</h2>

        <?= view('components/login_form') ?>

    </div>
</div>


<!-- Registro -->
<div id="registroModal" class="modal">

    <div class="modal-box">

        <span onclick="cerrarRegistro()" class="modal-close">✖</span>

        <img src="<?= base_url('img/logo-bts.png') ?>" class="modal-logo">

        <h2 class="modal-title">Portal de Noticias de BTS</h2>

        <?= view('components/register_form') ?>

    </div>
</div>