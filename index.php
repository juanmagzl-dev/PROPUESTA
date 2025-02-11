<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

$usuario = $_SESSION['usuario'];
$archivo_tareas = 'tareas_' . $usuario . '.txt';
$tareas = file_exists($archivo_tareas) ? file($archivo_tareas, FILE_IGNORE_NEW_LINES) : [];

// Agregar nueva tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tarea'])) {
    $tarea = htmlspecialchars($_POST['tarea']);
    file_put_contents($archivo_tareas, $tarea . PHP_EOL, FILE_APPEND);
    header('Location: index.php');
    exit();
}

// Eliminar una tarea
if (isset($_GET['eliminar'])) {
    $indice = $_GET['eliminar'];
    if (isset($tareas[$indice])) {
        unset($tareas[$indice]);
        file_put_contents($archivo_tareas, implode(PHP_EOL, $tareas) . PHP_EOL);
    }
    header('Location: index.php');
    exit();
}

// Marcar una tarea como completada
if (isset($_GET['completar'])) {
    $indice = $_GET['completar'];
    if (isset($tareas[$indice])) {
        $tareas[$indice] = '[Completada] ' . $tareas[$indice];
        file_put_contents($archivo_tareas, implode(PHP_EOL, $tareas) . PHP_EOL);
    }
    header('Location: index.php');
    exit();
}

// Vaciar todas las tareas
if (isset($_GET['vaciar'])) {
    file_put_contents($archivo_tareas, '');
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Hola, <?= $usuario ?>!</h1>
    <h2>Mis Tareas</h2>
    <ul>
        <?php foreach ($tareas as $indice => $tarea): ?>
            <li>
                <?= htmlspecialchars($tarea) ?>
                <a href="index.php?completar=<?= $indice ?>" class="btn-completar">Completar</a>
                <a href="index.php?eliminar=<?= $indice ?>" class="btn-eliminar">Eliminar</a>
            </li>
        <?php endforeach; ?>
    </ul>
    <form method="POST">
        <input type="text" name="tarea" placeholder="Escribe una nueva tarea" required>
        <button type="submit">Agregar</button>
    </form>
    <br>
    <a href="index.php?vaciar=true" class="btn-vaciar">Vaciar tareas</a>
    <br>
    <a href="logout.php">Cerrar sesión</a>
</div>
</body>
</html>
