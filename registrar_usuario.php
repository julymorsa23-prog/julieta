<?php
session_start();

include("conexion.php");

// =====================
// GUARDAR USUARIO
// =====================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

    // Validar correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Ingrese un correo válido.');
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

    // Verificar usuario
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
    $sql = "INSERT INTO usuarios(nombre,correo,usuario,contrasena)
            VALUES(?,?,?,?)";

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
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Usuario</title>

<link rel="stylesheet" href="estilos.css">

<style>

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#fce4ec,#e3f2fd);
}

.contenedor{
    width:100%;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.formulario{

    width:430px;
    background:#fff;
    padding:35px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,.2);

}

.formulario h2{

    text-align:center;
    color:#ff4081;
    margin-bottom:25px;

}

.campo{

    margin-bottom:18px;

}

.campo label{

    display:block;
    font-weight:bold;
    margin-bottom:6px;

}

.campo input{

    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px;
    font-size:15px;
    box-sizing:border-box;

}

.campo input:focus{

    outline:none;
    border-color:#ff4081;

}

.botones{

    display:flex;
    justify-content:space-between;
    margin-top:25px;

}

.btn{

    width:48%;
    padding:12px;
    border:none;
    border-radius:8px;
    color:white;
    font-size:16px;
    cursor:pointer;
    transition:.3s;

}

.guardar{

    background:#43a047;

}

.guardar:hover{

    background:#2e7d32;

}

.cancelar{

    background:#e53935;

}

.cancelar:hover{

    background:#c62828;

}

</style>

</head>

<body>

<div class="contenedor">

<form class="formulario" action="" method="POST">

<h2>Registrar Usuario</h2>

<div class="campo">
<label>Nombre completo</label>
<input
type="text"
name="nombre"
required
maxlength="100">
</div>

<div class="campo">
<label>Correo electrónico</label>
<input
type="email"
name="correo"
required
maxlength="100">
</div>

<div class="campo">
<label>Usuario</label>
<input
type="text"
name="usuario"
required
maxlength="50">
</div>

<div class="campo">
<label>Contraseña</label>
<input
type="password"
name="contrasena"
required
minlength="8">
</div>

<div class="campo">
<label>Confirmar contraseña</label>
<input
type="password"
name="confirmar"
required
minlength="8">
</div>

<div class="botones">

<button class="btn guardar" type="submit">
Guardar Usuario
</button>

<button
class="btn cancelar"
type="button"
onclick="window.location='dashboard.php'">
Cancelar
</button>

</div>

</form>

</div>

</body>
</html>