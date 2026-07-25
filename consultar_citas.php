<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Buscar cita
$buscar = "";

if(isset($_GET["buscar"])){

    $buscar = trim($_GET["buscar"]);

    $sql = "SELECT citas.*, mascotas.nombre, mascotas.dueno
            FROM citas
            INNER JOIN mascotas
            ON citas.id_mascota = mascotas.id_mascota
            WHERE mascotas.nombre LIKE ?
            ORDER BY citas.fecha ASC, citas.hora ASC";

    $stmt = $conexion->prepare($sql);

    $texto = "%".$buscar."%";

    $stmt->bind_param("s",$texto);

    $stmt->execute();

    $resultado = $stmt->get_result();

}else{

    $sql = "SELECT citas.*, mascotas.nombre, mascotas.dueno
            FROM citas
            INNER JOIN mascotas
            ON citas.id_mascota = mascotas.id_mascota
            ORDER BY citas.fecha ASC, citas.hora ASC";

    $resultado = mysqli_query($conexion,$sql);

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Consultar Citas</title>

<link rel="stylesheet" href="estilos.css">

</head>

<body>

<div class="contenedor">

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

<main class="principal">

<header class="encabezado">

<h1>Consultar Citas</h1>

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

<form method="GET">

<input
type="text"
name="buscar"
placeholder="Buscar por mascota"
value="<?php echo htmlspecialchars($buscar); ?>">

<input
type="submit"
value="Buscar"
class="boton">

<a href="consultar_citas.php" class="boton">

Mostrar Todas

</a>

</form>

<br>

<table border="1" width="100%">

<tr>

<th>ID</th>

<th>Mascota</th>

<th>Dueño</th>

<th>Fecha</th>

<th>Hora</th>

<th>Servicio</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

<?php

while($fila=mysqli_fetch_assoc($resultado)){

?>

<tr>

<td><?php echo $fila["id_cita"]; ?></td>

<td><?php echo htmlspecialchars($fila["nombre"]); ?></td>

<td><?php echo htmlspecialchars($fila["dueno"]); ?></td>

<td><?php echo $fila["fecha"]; ?></td>

<td><?php echo $fila["hora"]; ?></td>

<td><?php echo htmlspecialchars($fila["servicio"]); ?></td>

<td><?php echo htmlspecialchars($fila["estado"]); ?></td>

<td>

<a href="editar_cita.php?id=<?php echo $fila["id_cita"]; ?>">

Editar

</a>

|

<a href="eliminar_cita.php?id=<?php echo $fila["id_cita"]; ?>">

Eliminar

</a>

</td>

</tr>

<?php

}

?>

</table>

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