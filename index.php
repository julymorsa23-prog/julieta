<?php
session_start();

if(isset($_SESSION["id_usuario"])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dog Estética</title>

<link rel="stylesheet" href="estilos.css">

</head>

<body>

<div id="login">
    <img src="cane1.jpg" alt="Logo de Dog Estética" id="logo" width="300" height="200">
    <h1>Dog Estética</h1>

    <p>Inicio de sesión</p>

    <form action="validar.php" method="POST">

        <input
        type="text"
        name="usuario"
        placeholder="Usuario"
        required>

        <input
        type="password"
        name="contrasena"
        placeholder="Contraseña"
        required>

        <input
        type="submit"
        value="Entrar"
        class="boton">

    </form>

    <br>

    <a href="registrar_usuario.php" class="registro"> Crear una cuenta </a>

</div>


</body>
</html>