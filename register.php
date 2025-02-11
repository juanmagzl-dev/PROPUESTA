<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = htmlspecialchars($_POST['usuario']);
    $password = $_POST['password'];

    $usuarios = file('usuarios.txt', FILE_IGNORE_NEW_LINES);
    foreach ($usuarios as $linea) {
        list($user, $pass) = explode(':', $linea);
        if ($user == $usuario) {
            $error = "El usuario ya existe.";
            break;
        }
    }

    if (!isset($error)) {
        file_put_contents('usuarios.txt', $usuario . ':' . $password . PHP_EOL, FILE_APPEND);
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Registro</h1>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <br>
    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</div>
</body>
</html>
