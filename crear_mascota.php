<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registrar Mascota</title>

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

            <li><a href="consultar_mascota.php">📋 Consultar Mascotas</a></li>

            <li><a href="crear_cita.php">📅 Registrar Cita</a></li>

            <li><a href="consultar_citas.php">📅 Consultar Citas</a></li>

            <li><a href="registrar_usuario.php">👤 Registrar Usuario</a></li>

            <li><a href="cerrar_sesion.php">🚪 Cerrar Sesión</a></li>

        </ul>

    </aside>

    <!-- Contenido -->

    <main class="principal">

        <header class="encabezado">

            <h1>Registrar Mascota</h1>

            <div class="usuario">

                Bienvenido:

                <strong>

                    <?php echo htmlspecialchars($_SESSION["nombre"]); ?>

                </strong>

            </div>

        </header>

        <section class="formulario">

            <form action="guardar_mascota.php" method="POST">

                <label>Nombre de la mascota</label>

                <input
                type="text"
                name="nombre"
                required>

                <label>Raza</label>

                <input
                type="text"
                name="raza"
                required>

                <label>Edad (años)</label>

                <input
                type="number"
                name="edad"
                min="0"
                required>

                <label>Sexo</label>

                <select name="sexo" required>

                    <option value="">Seleccione</option>

                    <option value="Macho">Macho</option>

                    <option value="Hembra">Hembra</option>

                </select>

                <label>Nombre del dueño</label>

                <input
                type="text"
                name="dueno"
                required>

                <label>Teléfono</label>

                <input
                type="text"
                name="telefono"
                maxlength="10"
                required>

                <label>Observaciones</label>

                <textarea
                name="observaciones"
                rows="4"
                placeholder="Alergias, medicamentos, comportamiento, etc."></textarea>

                <br><br>

                <input
                type="submit"
                value="Registrar Mascota"
                class="boton">

                <input
                type="reset"
                value="Limpiar"
                class="boton">

            </form>

        </section>

    </main>

</div>

</body>
</html>