<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Niño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Editar Niño</h1>
<?php
require_once 'conexion.php';

class Ninios extends Conexion {
    public function modificarNinio($idNinio, $nombre, $apellidos, $fechaNacimiento, $buenoMalo) {
        $fechaFormateada = date('Y-m-d', strtotime($fechaNacimiento));
        $consulta = "UPDATE ninios SET nombre = '$nombre', apellidos = '$apellidos', fechaNacimiento = '$fechaFormateada', buenoMalo = '$buenoMalo' WHERE idNinio = $idNinio";
        $resultado = mysqli_query($this->conexion, $consulta);

        if ($resultado) {
            echo "<p>Cambios guardados exitosamente.</p>";
        } else {
            echo "<p>Error al guardar cambios.</p>";
        }
    }
}

$ninioExistente = new Ninios();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idNinio = $_POST['idNinio'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $buenoMalo = ($_POST['buenoMalo'] === 'bueno') ? 1 : 0; // Convertir a booleano

    $ninioExistente->modificarNinio($idNinio, $nombre, $apellidos, $fechaNacimiento, $buenoMalo);
}

if (isset($_GET['id'])) {
    $idNinio = ($_GET['id']);
    $conexion = new Conexion(); 
    $consulta = "SELECT * FROM ninios WHERE idNinio = $idNinio";
    $resultado = mysqli_query($conexion->conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
?>
        <form action="editar_ninio.php" method="post">
            <input type="hidden" name="idNinio" value="<?php echo $idNinio; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $fila['nombre']; ?>">
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" value="<?php echo $fila['apellidos']; ?>">
            </div>
            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" value="<?php echo $fila['fechaNacimiento']; ?>">
            </div>
            <div class="mb-3">
                <label for="buenoMalo" class="form-label">Bueno/Malo:</label>
                <select class="form-select" id="buenoMalo" name="buenoMalo">
                    <option value="bueno" <?php if ($fila['buenoMalo'] == 1) echo 'selected'; ?>>Bueno</option>
                    <option value="malo" <?php if ($fila['buenoMalo'] == 0) echo 'selected'; ?>>Malo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </form>
<?php
    } else {
        echo "<p>No se encontró el niño.</p>";
    }
}
?>
        <a class="btn btn-dark mt-3" href="ninos.php">Volver a Niños</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
