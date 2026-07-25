<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que exista el ID
if (!isset($_GET["id"])) {

    header("Location: consultar_mascotas.php");
    exit();

}

$id = intval($_GET["id"]);

// Verificar que la mascota exista
$sql = "SELECT * FROM mascotas WHERE id_mascota = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {

    echo "<script>
            alert('La mascota no existe.');
            window.location='consultar_mascotas.php';
          </script>";

    exit();
}

$stmt->close();

// Eliminar mascota
$sql = "DELETE FROM mascotas WHERE id_mascota = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    echo "<script>
            alert('Mascota eliminada correctamente.');
            window.location='consultar_mascota.php';
          </script>";

} else {

    echo "<script>
            alert('No fue posible eliminar la mascota.');
            window.location='consultar_mascota.php';
          </script>";

}

$stmt->close();
$conexion->close();

?>