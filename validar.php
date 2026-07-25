<?php
session_start();
include("conexion.php");

// Verificar que el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit();
}

// Recibir datos del formulario
$usuario = trim($_POST["usuario"]);
$contrasena = $_POST["contrasena"];

// Validar que no estén vacíos
if (empty($usuario) || empty($contrasena)) {
    echo "<script>
            alert('Debe ingresar usuario y contraseña.');
            window.location='index.php';
          </script>";
    exit();
}

// Buscar usuario
    $sql = "SELECT * FROM usuarios WHERE usuario='$usuario'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) == 1) {

        $fila = mysqli_fetch_assoc($resultado);

    // Verificar la contraseña encriptada
    if (password_verify($contrasena, $fila["contrasena"])) {

            $_SESSION["id_usuario"] = $fila["id_usuario"];
            $_SESSION["nombre"] = $fila["nombre"];
            $_SESSION["usuario"] = $fila["usuario"];

            header("Location: dashboard.php");
            exit();

    } else {

        echo "<script>
                alert('Contraseña incorrecta.');
                window.location='index.php';
              </script>";
    }

} else {

    echo "<script>
            alert('El usuario no existe.');
            window.location='index.php';
          </script>";
}

$stmt->close();
$conexion->close();
?>