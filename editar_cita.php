<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que exista el ID
if (!isset($_GET["id"])) {
    header("Location: consultar_citas.php");
    exit();
}

$id = intval($_GET["id"]);

// Obtener datos de la cita
$sql = "SELECT * FROM citas WHERE id_cita = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    echo "<script>
            alert('La cita no existe.');
            window.location='consultar_citas.php';
          </script>";
    exit();

}

$cita = $resultado->fetch_assoc();

// Obtener mascotas
$sqlMascotas = "SELECT * FROM mascotas ORDER BY nombre ASC";
$resultadoMascotas = mysqli_query($conexion, $sqlMascotas);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Editar Cita</title>

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

<li><a href="consultar_citas.php">📋 Consultar Citas</a></li>

<li><a href="registrar_usuario.php">👤 Registrar Usuario</a></li>

<li><a href="cerrar_sesion.php">🚪 Cerrar Sesión</a></li>

</ul>

</aside>

<main class="principal">

<header class="encabezado">

<h1>Editar Cita</h1>

<div class="usuario">

Bienvenido:

<strong>

<?php echo htmlspecialchars($_SESSION["nombre"]); ?>

</strong>

</div>

</header>

<section class="formulario">

<form action="actualizar_cita.php" method="POST">

<input
type="hidden"
name="id_cita"
value="<?php echo $cita["id_cita"]; ?>">

<label>Mascota</label>

<select name="id_mascota" required>

<?php

while($mascota = mysqli_fetch_assoc($resultadoMascotas)){

?>

<option
value="<?php echo $mascota["id_mascota"]; ?>"

<?php
if($mascota["id_mascota"] == $cita["id_mascota"]){
echo "selected";
}
?>

>

<?php

echo $mascota["nombre"] . " - " . $mascota["dueno"];

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
value="<?php echo $cita["fecha"]; ?>"
required>

<label>Hora</label>

<input
type="time"
name="hora"
value="<?php echo $cita["hora"]; ?>"
required>

<label>Servicio</label>

<select name="servicio" required>

<?php

$servicios = array(

"Baño",
"Corte de Pelo",
"Baño y Corte",
"Corte de Uñas",
"Limpieza de Oídos",
"Deslanado",
"Tratamiento Antipulgas",
"Spa Canino"

);

foreach($servicios as $servicio){

?>

<option

<?php

if($servicio==$cita["servicio"]){

echo "selected";

}

?>

>

<?php echo $servicio; ?>

</option>

<?php

}

?>

</select>

<label>Estado</label>

<select name="estado">

<?php

$estados=array(

"Programada",
"En Proceso",
"Finalizada",
"Cancelada"

);

foreach($estados as $estado){

?>

<option

<?php

if($estado==$cita["estado"]){

echo "selected";

}

?>

>

<?php echo $estado; ?>

</option>

<?php

}

?>

</select>

<br><br>

<input
type="submit"
value="Actualizar Cita"
class="boton">

<a
href="consultar_citas.php"
class="boton">

Cancelar

</a>

</form>

</section>

</main>

</div>

</body>

</html>