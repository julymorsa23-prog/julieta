<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: 'consultar_citas.php'");
    exit();
}

// Recibir datos
$id_cita = intval($_POST["id_cita"]);
$id_mascota = intval($_POST["id_mascota"]);
$fecha = trim($_POST["fecha"]);
$hora = trim($_POST["hora"]);
$servicio = trim($_POST["servicio"]);
$estado = trim($_POST["estado"]);

// Validar campos
if (
    $id_cita <= 0 ||
    $id_mascota <= 0 ||
    empty($fecha) ||
    empty($hora) ||
    empty($servicio) ||
    empty($estado)
) {

    echo "<script>
            alert('Todos los campos son obligatorios.');
            window.location='editar_cita.php?id=$id_cita';
          </script>";

    exit();
}

// Verificar que la mascota exista
$sql = "SELECT id_mascota
        FROM mascotas
        WHERE id_mascota = ?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param("i", $id_mascota);

$stmt->execute();

$resultado = $stmt->get_result();

if($resultado->num_rows==0){

    echo "<script>

    alert('La mascota seleccionada no existe.');

    window.location='editar_cita.php?id=$id_cita';

    </script>";

    exit();

}

$stmt->close();

// Actualizar cita
$sql = "UPDATE citas
SET
id_mascota=?,
fecha=?,
hora=?,
servicio=?,
estado=?
WHERE id_cita=?";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(

"issssi",

$id_mascota,
$fecha,
$hora,
$servicio,
$estado,
$id_cita

);

if($stmt->execute()){

echo "<script>

alert('La cita fue actualizada correctamente.');

window.location='consultar_citas.php';

</script>";

}else{

echo "<script>

alert('Error al actualizar la cita.');

window.location='editar_cita.php?id=$id_cita';

</script>";

}

$stmt->close();

$conexion->close();

?>