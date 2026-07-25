<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: crear_cita.php");
    exit();
}

// Recibir datos
$id_mascota = intval($_POST["id_mascota"]);
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];
$servicio = trim($_POST["servicio"]);
$estado = trim($_POST["estado"]);

// Validar campos
if (
    $id_mascota <= 0 ||
    empty($fecha) ||
    empty($hora) ||
    empty($servicio) ||
    empty($estado)
) {

    echo "<script>
            alert('Todos los campos son obligatorios.');
            window.location='crear_cita.php';
          </script>";
    exit();
}

// Verificar que la mascota exista
$sql = "SELECT id_mascota FROM mascotas WHERE id_mascota = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_mascota);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    echo "<script>
            alert('La mascota seleccionada no existe.');
            window.location='crear_cita.php';
          </script>";

    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();

// Insertar cita
$sql = "INSERT INTO citas
(id_mascota, fecha, hora, servicio, estado)
VALUES (?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "issss",
    $id_mascota,
    $fecha,
    $hora,
    $servicio,
    $estado
);

if ($stmt->execute()) {

    echo "<script>
            alert('Cita registrada correctamente.');
            window.location='consultar_citas.php';
          </script>";

} else {

    echo "<script>
            alert('Error al registrar la cita.');
            window.location='crear_cita.php';
          </script>";
}

$stmt->close();
$conexion->close();
?>