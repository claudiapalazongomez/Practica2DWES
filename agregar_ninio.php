<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Niño</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Añadir Nuevo Niño</h1>
<?php
require_once 'conexion.php';

class Ninios extends Conexion {
    public function agregarNinio($nombre, $apellidos, $fechaNacimiento, $buenoMalo) {
        $fechaFormateada = date('Y-m-d', strtotime($fechaNacimiento));
        // Preparar la consulta SQL para la inserción
        $consulta = "INSERT INTO ninios (nombre, apellidos, fechaNacimiento, buenoMalo) VALUES ('$nombre', '$apellidos', '$fechaFormateada', '$buenoMalo')";
        $sentencia = mysqli_prepare($this->conexion, $consulta);

        // Comprobar si la consulta está preparada correctamente
        if ($sentencia) {
            // Ejecutar la declaración
            mysqli_stmt_execute($sentencia);

            // Verificar si se realizó la inserción correctamente
            if (mysqli_stmt_affected_rows($sentencia) > 0) {
                echo "<p>Niño añadido exitosamente.</p>";
            } else {
                echo "<p>Error al añadir al niño.</p>";
            }

            // Cerrar la declaración
            mysqli_stmt_close($sentencia);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($this->conexion);
        }
    }
}
?>
        <form action="agregar_ninio.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" required>
            </div>
            <div class="mb-3">
                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
            </div>
            <div class="mb-3">
                <label for="buenoMalo" class="form-label">Bueno/Malo:</label>
                <select class="form-select" id="buenoMalo" name="buenoMalo" required>
                    <option value="bueno">Bueno</option>
                    <option value="malo">Malo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Añadir</button>
        </form>
<?php
$nuevoNinio = new Ninios();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $buenoMalo = ($_POST['buenoMalo'] === 'bueno') ? 1 : 0; // Convertir a booleano

    $nuevoNinio->agregarNinio($nombre, $apellidos, $fechaNacimiento, $buenoMalo);
}
?>
        <a class="btn btn-dark mt-3" href="ninios.php">Volver a Niños</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
