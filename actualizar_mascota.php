<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: consultar_mascotas.php");
    exit();
}

// Recibir datos
$id = intval($_POST["id_mascota"]);
$nombre = trim($_POST["nombre"]);
$raza = trim($_POST["raza"]);
$edad = intval($_POST["edad"]);
$sexo = trim($_POST["sexo"]);
$dueno = trim($_POST["dueno"]);
$telefono = trim($_POST["telefono"]);
$observaciones = trim($_POST["observaciones"]);

// Validar campos obligatorios
if (
    empty($nombre) ||
    empty($raza) ||
    empty($sexo) ||
    empty($dueno) ||
    empty($telefono)
) {

    echo "<script>
            alert('Todos los campos obligatorios deben llenarse.');
            window.location='editar_mascota.php?id=$id';
          </script>";
    exit();
}

// Actualizar registro
$sql = "UPDATE mascotas
        SET nombre = ?,
            raza = ?,
            edad = ?,
            sexo = ?,
            dueno = ?,
            telefono = ?,
            observaciones = ?
        WHERE id_mascota = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "ssissssi",
    $nombre,
    $raza,
    $edad,
    $sexo,
    $dueno,
    $telefono,
    $observaciones,
    $id
);

if ($stmt->execute()) {

    echo "<script>
            alert('Mascota actualizada correctamente.');
            window.location='consultar_mascotas.php';
          </script>";

} else {

    echo "<script>
            alert('Error al actualizar la mascota.');
            window.location='editar_mascota.php?id=$id';
          </script>";
}

$stmt->close();
$conexion->close();
?>