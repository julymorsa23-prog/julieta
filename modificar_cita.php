<?php
session_start();


include("conexion.php");

// Verificar que venga el ID
if (!isset($_GET["id"])) {
    header("Location: consultar_citas.php");
    exit();
}

$id_cita = intval($_GET["id"]);

// Obtener datos de la cita
$sql = "SELECT * FROM citas WHERE id_cita = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_cita);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    echo "<script>
            alert('La cita no existe');
            window.location='consultar_citas.php';
          </script>";
    exit();
}

$cita = $resultado->fetch_assoc();

// Obtener mascotas
$mascotas = mysqli_query(
    $conexion,
    "SELECT id_mascota, nombre FROM mascotas ORDER BY nombre"
);

// Obtener servicios
$servicios = mysqli_query(
    $conexion,
    "SELECT id_servicio, nombre FROM servicios ORDER BY nombre"
);

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar Cita</title>

<link rel="stylesheet" href="estilos.css">

<style>

body{
    background:linear-gradient(135deg,#fce4ec,#e3f2fd);
    font-family:'Segoe UI',sans-serif;
    margin:0;
}

.contenedor{
    max-width:650px;
    margin:50px auto;
    background:white;
    padding:35px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
}

h1{
    text-align:center;
    color:#8e44ad;
    margin-bottom:25px;
}

.grupo{
    margin-bottom:18px;
}

.grupo label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#333;
}

.grupo input,
.grupo select,
.grupo textarea{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:10px;
    font-size:15px;
    box-sizing:border-box;
}

.grupo input:focus,
.grupo select:focus,
.grupo textarea:focus{
    outline:none;
    border-color:#9c27b0;
}

textarea{
    resize:vertical;
    min-height:90px;
}

.botones{
    display:flex;
    justify-content:space-between;
    margin-top:30px;
}

.btn{
    width:48%;
    padding:12px;
    border:none;
    border-radius:10px;
    font-size:16px;
    cursor:pointer;
    color:white;
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

    <h1>Modificar Cita</h1>

    <form action="actualizar_cita.php" method="POST">

        <input type="hidden" name="id_cita"
               value="<?php echo $cita['id_cita']; ?>">

        <div class="grupo">
            <label>Mascota</label>
            <select name="id_mascota" required>
                <option value="">Seleccione una mascota</option>

                <?php while($m = mysqli_fetch_assoc($mascotas)){ ?>

                    <option
                        value="<?php echo $m['id_mascota']; ?>"

                        <?php
                        if($m['id_mascota'] == $cita['id_mascota']){
                            echo 'selected';
                        }
                        ?>
                    >

                        <?php echo $m['nombre']; ?>

                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="grupo">
            <label>Servicio</label>
            <select name="id_servicio" required>
                <option value="">Seleccione un servicio</option>

                <?php while($s = mysqli_fetch_assoc($servicios)){ ?>

                    <option
                        value="<?php echo $s['id_servicio']; ?>"

                        <?php
                        if($s['id_servicio'] == $cita['id_servicio']){
                            echo 'selected';
                        }
                        ?>
                    >

                        <?php echo $s['nombre']; ?>

                    </option>

                <?php } ?>

            </select>
        </div>

        <div class="grupo">
            <label>Fecha</label>
            <input type="date"
                   name="fecha"
                   value="<?php echo $cita['fecha']; ?>"
                   required>
        </div>

        <div class="grupo">
            <label>Hora</label>
            <input type="time"
                   name="hora"
                   value="<?php echo $cita['hora']; ?>"
                   required>
        </div>

        <div class="grupo">
            <label>Estado</label>
            <select name="estado" required>

                <option value="Pendiente"
                    <?php if($cita['estado']=='Pendiente') echo 'selected'; ?>>
                    Pendiente
                </option>

                <option value="Confirmada"
                    <?php if($cita['estado']=='Confirmada') echo 'selected'; ?>>
                    Confirmada
                </option>

                <option value="Finalizada"
                    <?php if($cita['estado']=='Finalizada') echo 'selected'; ?>>
                    Finalizada
                </option>

                <option value="Cancelada"
                    <?php if($cita['estado']=='Cancelada') echo 'selected'; ?>>
                    Cancelada
                </option>

            </select>
        </div>

        <div class="grupo">
            <label>Notas</label>
            <textarea name="notas"
                      placeholder="Observaciones de la cita"><?php echo $cita['notas']; ?></textarea>
        </div>

        <div class="botones">

            <button type="submit"
                    class="btn guardar">
                Actualizar
            </button>

            <button type="button"
                    class="btn cancelar"
                    onclick="window.location='consultar_citas.php'">
                Cancelar
            </button>

        </div>

    </form>

</div>

</body>
</html>