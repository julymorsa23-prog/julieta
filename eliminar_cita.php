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

// Verificar que la cita exista
$sql = "SELECT id_cita FROM citas WHERE id_cita = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    echo "<script>
            alert('La cita no existe.');
            window.location='consultar_citas.php';
          </script>";

    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();

// Eliminar cita
$sql = "DELETE FROM citas WHERE id_cita = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo "<script>
            alert('Cita eliminada correctamente.');
            window.location='consultar_citas.php';
          </script>";

} else {

    echo "<script>
            alert('Error al eliminar la cita.');
            window.location='consultar_citas.php';
          </script>";
}

$stmt->close();
$conexion->close();

?>