<h1>Lista de Tareas</h1>

<a href="<?= base_url('tareas/crear') ?>">Nueva tarea</a>

<ul>
<?php foreach ($tareas as $tarea): ?>
    <li><?= $tarea['titulo'] ?></li>
<?php endforeach; ?>
</ul>