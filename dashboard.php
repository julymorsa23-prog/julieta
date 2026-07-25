<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Total de mascotas
$sqlMascotas = "SELECT COUNT(*) AS total FROM mascotas";
$resultadoMascotas = mysqli_query($conexion, $sqlMascotas);
$totalMascotas = 0;

if ($resultadoMascotas) {
    $fila = mysqli_fetch_assoc($resultadoMascotas);
    $totalMascotas = $fila["total"];
}

// Total de citas
$sqlCitas = "SELECT COUNT(*) AS total FROM citas";
$resultadoCitas = mysqli_query($conexion, $sqlCitas);
$totalCitas = 0;

if ($resultadoCitas) {
    $fila = mysqli_fetch_assoc($resultadoCitas);
    $totalCitas = $fila["total"];
}

// Total de usuarios
$sqlUsuarios = "SELECT COUNT(*) AS total FROM usuarios";
$resultadoUsuarios = mysqli_query($conexion, $sqlUsuarios);
$totalUsuarios = 0;

if ($resultadoUsuarios) {
    $fila = mysqli_fetch_assoc($resultadoUsuarios);
    $totalUsuarios = $fila["total"];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Panel Principal</title>

<link rel="stylesheet" href="estilos.css">

</head>

<body>

<div class="contenedor">

    <!-- Menú lateral -->

    <aside class="menu">

        <div class="logo">

            <img src="logo.jpg" width="120">

            <h2>Dog Estética</h2>

        </div>

        <ul>

            <li><a href="dashboard.php">🏠 Inicio</a></li>

            <li><a href="crear_mascota.php">🐶 Registrar Mascota</a></li>

            <li><a href="crear_cita.php">📅 Registrar Cita</a></li>

            <li><a href="consultar_citas.php">📋 Consultar Citas</a></li>

            <li><a href="modificar_cita.php">✏️ Modificar Cita</a></li>

            <li><a href="eliminar_cita.php">🗑️ Eliminar Cita</a></li>

            <li><a href="registrar_usuario.php">👤 Registrar Usuario</a></li>

            <li><a href="cerrar_sesion.php">🚪 Cerrar Sesión</a></li>

        </ul>

    </aside>

    <!-- Contenido principal -->

    <main class="principal">

        <header class="encabezado">

            <h1>Estética Canina</h1>

            <div class="usuario">

                Bienvenido:

                <strong>

                    <?php echo htmlspecialchars($_SESSION["nombre"]); ?>

                </strong>

            </div>

        </header>

        <section class="tarjetas">

            <div class="tarjeta">

                <h3>Total de Mascotas</h3>

                <h2><?php echo $totalMascotas; ?></h2>

            </div>

            <div class="tarjeta">

                <h3>Total de Citas</h3>

                <h2><?php echo $totalCitas; ?></h2>

            </div>

            <div class="tarjeta">

                <h3>Usuarios Registrados</h3>

                <h2><?php echo $totalUsuarios; ?></h2>

            </div>

        </section>

        <section class="bienvenida">

            <h2>Bievenido al Sistema de Estetica Canina</h2>

        </section>

    </main>

</div>


</body>

</html>