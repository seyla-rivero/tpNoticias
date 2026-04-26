<!-- Scripts del modal Login y Registro -->
<script>
document.addEventListener("DOMContentLoaded", function() {

    let modal = "<?= session()->getFlashdata('modal') ?>";

    if (modal === 'login') {
        document.getElementById("loginFormModal").style.display = "flex";
    }

    if (modal === 'registro') {
        document.getElementById("registroModal").style.display = "flex";
    }

});

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

window.onload = function() {
    <?php if (session()->getFlashdata('recuperar')): ?>
        abrirModalRecuperar();
    <?php endif; ?>
}

setTimeout(() => {
    const toast = document.querySelector('.toast-success');
    if (toast) {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }
}, 3000);

</script>

<script id="i4f1xr">
function abrirModalRecuperar() {
    document.getElementById('modalRecuperar').style.display = 'flex';
}

function cerrarModalRecuperar() {
    document.getElementById('modalRecuperar').style.display = 'none';
}

</script>  
