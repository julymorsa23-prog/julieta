<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: crear_mascota.php");
    exit();
}

// Recibir datos
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
            window.location='crear_mascota.php';
          </script>";
    exit();
}

// Insertar mascota
$sql = "INSERT INTO mascotas
(nombre, raza, edad, sexo, dueno, telefono, observaciones)
VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "ssissss",
    $nombre,
    $raza,
    $edad,
    $sexo,
    $dueno,
    $telefono,
    $observaciones
);

if ($stmt->execute()) {

    echo "<script>
            alert('Mascota registrada correctamente.');
            window.location='consultar_mascota.php';
          </script>";

} else {

    echo "<script>
            alert('Error al registrar la mascota.');
            window.location='crear_mascota.php';
          </script>";

}

$stmt->close();
$conexion->close();

?>