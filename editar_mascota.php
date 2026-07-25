<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que exista el ID
if (!isset($_GET["id"])) {

    header("Location: consultar_mascota.php");
    exit();

}

$id = intval($_GET["id"]);

// Buscar la mascota
$sql = "SELECT * FROM mascotas WHERE id_mascota = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    echo "<script>
            alert('La mascota no existe.');
            window.location='consultar_mascota.php';
          </script>";

    exit();

}

$mascota = $resultado->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Mascota</title>

<link rel="stylesheet" href="estilos.css">

</head>

<body>

<div class="contenedor">

    <!-- Menú -->

    <aside class="menu">

        <div class="logo">

            <img src="imagenes/logo.png" width="120">

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

            <h1>Editar Mascota</h1>

            <div class="usuario">

                Bienvenido:

                <strong><?php echo htmlspecialchars($_SESSION["nombre"]); ?></strong>

            </div>

        </header>

        <section class="formulario">

            <form action="actualizar_mascota.php" method="POST">

                <input
                type="hidden"
                name="id_mascota"
                value="<?php echo $mascota["id_mascota"]; ?>">

                <label>Nombre de la mascota</label>

                <input
                type="text"
                name="nombre"
                value="<?php echo htmlspecialchars($mascota["nombre"]); ?>"
                required>

                <label>Raza</label>

                <input
                type="text"
                name="raza"
                value="<?php echo htmlspecialchars($mascota["raza"]); ?>"
                required>

                <label>Edad</label>

                <input
                type="number"
                name="edad"
                value="<?php echo $mascota["edad"]; ?>"
                required>

                <label>Sexo</label>

                <select name="sexo" required>

                    <option value="Macho"
                    <?php if($mascota["sexo"]=="Macho") echo "selected"; ?>>
                    Macho
                    </option>

                    <option value="Hembra"
                    <?php if($mascota["sexo"]=="Hembra") echo "selected"; ?>>
                    Hembra
                    </option>

                </select>

                <label>Nombre del dueño</label>

                <input
                type="text"
                name="dueno"
                value="<?php echo htmlspecialchars($mascota["dueno"]); ?>"
                required>

                <label>Teléfono</label>

                <input
                type="text"
                name="telefono"
                value="<?php echo htmlspecialchars($mascota["telefono"]); ?>"
                required>

                <label>Observaciones</label>

                <textarea
                name="observaciones"
                rows="4"><?php echo htmlspecialchars($mascota["observaciones"]); ?></textarea>

                <br><br>

                <input
                type="submit"
                value="Actualizar Mascota"
                class="boton">

                <a href="consultar_mascota.php" class="boton">
                    Cancelar
                </a>

            </form>

        </section>

    </main>

</div>

</body>

</html>