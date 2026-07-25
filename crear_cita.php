<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Obtener mascotas
$sqlMascotas = "SELECT * FROM mascotas ORDER BY nombre ASC";
$resultadoMascotas = mysqli_query($conexion, $sqlMascotas);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registrar Cita</title>

<link rel="stylesheet" href="estilos.css">

</head>

<body>

<div class="contenedor">

    <!-- Menú -->

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

            <h1>Registrar Nueva Cita</h1>

            <div class="usuario">

                Bienvenido:

                <strong>

                    <?php echo htmlspecialchars($_SESSION["nombre"]); ?>

                </strong>

            </div>
                        <div class="controles">
    <button id="btnDaltonismo" class="btn-daltonismo">
        👁️ Modo Daltonismo
    </button>
</div>



        </header>

        <section class="formulario">

            <form action="guardar_cita.php" method="POST">

                <label>Mascota</label>

                <select name="id_mascota" required>

                    <option value="">Seleccione una mascota</option>

                    <?php

                    while($fila=mysqli_fetch_assoc($resultadoMascotas)){

                    ?>

                    <option value="<?php echo $fila["id_mascota"]; ?>">

                        <?php

                        echo $fila["nombre"] .
                        " - " .
                        $fila["dueno"];

                        ?>

                    </option>

                    <?php

                    }

                    ?>

                </select>

                <label>Fecha</label>

                <input
                type="date"
                name="fecha"
                required>

                <label>Hora</label>

                <input
                type="time"
                name="hora"
                required>

                <label>Servicio</label>

                <select name="servicio" required>

                    <option value="">Seleccione</option>

                    <option>Baño</option>

                    <option>Corte de Pelo</option>

                    <option>Baño y Corte</option>

                    <option>Corte de Uñas</option>

                    <option>Limpieza de Oídos</option>

                    <option>Deslanado</option>

                    <option>Tratamiento Antipulgas</option>

                    <option>Spa Canino</option>

                </select>

                <label>Estado</label>

                <select name="estado">

                    <option>Programada</option>

                    <option>En Proceso</option>

                    <option>Finalizada</option>

                    <option>Cancelada</option>

                </select>

                <br><br>

                <input
                type="submit"
                value="Registrar Cita"
                class="boton">

                <input
                type="reset"
                value="Limpiar"
                class="boton">

            </form>

        </section>

    </main>

</div>

<script>

const boton = document.getElementById("btnDaltonismo");

boton.addEventListener("click", function(){

    document.body.classList.toggle("daltonismo");

    if(document.body.classList.contains("daltonismo")){
        boton.innerHTML="🌈 Modo Normal";
    }else{
        boton.innerHTML="👁️ Modo Daltonismo";
    }

});

</script>

</body>

</html>