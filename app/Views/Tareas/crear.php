<h1>Nueva Tarea</h1>

<form method="post" action="<?= base_url('tareas/guardar') ?>">
    <input type="text" name="titulo" required>
    <button type="submit">Guardar</button>
</form>