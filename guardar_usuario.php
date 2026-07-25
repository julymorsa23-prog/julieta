<?php
session_start();

if (!isset($_SESSION["id_usuario"])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: registrar_usuario.php");
    exit();
}

// Recibir datos
$nombre = trim($_POST["nombre"]);
$correo = trim($_POST["correo"]);
$usuario = trim($_POST["usuario"]);
$contrasena = $_POST["contrasena"];
$confirmar = $_POST["confirmar"];

// Validar campos vacíos
if (
    empty($nombre) ||
    empty($correo) ||
    empty($usuario) ||
    empty($contrasena) ||
    empty($confirmar)
) {

    echo "<script>
            alert('Todos los campos son obligatorios.');
            window.location='registrar_usuario.php';
          </script>";
    exit();
}

// Verificar contraseñas
if ($contrasena != $confirmar) {

    echo "<script>
            alert('Las contraseñas no coinciden.');
            window.location='registrar_usuario.php';
          </script>";
    exit();
}

// Verificar si el usuario ya existe
$sql = "SELECT id_usuario FROM usuarios WHERE usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {

    echo "<script>
            alert('El nombre de usuario ya existe.');
            window.location='registrar_usuario.php';
          </script>";

    $stmt->close();
    $conexion->close();
    exit();
}

$stmt->close();

// Encriptar contraseña
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

// Insertar usuario
$sql = "INSERT INTO usuarios(nombre, correo, usuario, contrasena)
        VALUES(?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

$stmt->bind_param(
    "ssss",
    $nombre,
    $correo,
    $usuario,
    $contrasenaHash
);

if ($stmt->execute()) {

    echo "<script>
            alert('Usuario registrado correctamente.');
            window.location='dashboard.php';
          </script>";

} else {

    echo "<script>
            alert('Error al registrar el usuario.');
            window.location='registrar_usuario.php';
          </script>";
}

$stmt->close();
$conexion->close();

?>