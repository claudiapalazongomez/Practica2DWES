<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Regalo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Editar Regalo</h1>
        <?php
        require_once 'conexion.php';

        class Regalos extends Conexion {
            public function modificarRegalo($idRegalo, $nombre, $precio, $idReyFK) {
                $consulta = "UPDATE regalos SET nombre = '$nombre', precio = '$precio', idReyFK = '$idReyFK' WHERE idRegalo = $idRegalo";
                $resultado = mysqli_query($this->conexion, $consulta);

                if ($resultado) {
                    echo "<p>Cambios guardados exitosamente.</p>";
                } else {
                    echo "<p>Error al guardar cambios.</p>";
                }
            }
        }

        $regaloExistente = new Regalos();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idRegalo = $_POST['idRegalo'];
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $idReyFK = $_POST['idReyFK'];

            $regaloExistente->modificarRegalo($idRegalo, $nombre, $precio, $idReyFK);
        }

        if (isset($_GET['id'])) {
            $idRegalo = $_GET['id'];
            $conexion = new Conexion(); 
            $consulta = "SELECT * FROM regalos WHERE idRegalo = $idRegalo";
            $resultado = mysqli_query($conexion->conexion, $consulta);

            if ($resultado && mysqli_num_rows($resultado) > 0) {
                $fila = mysqli_fetch_assoc($resultado);
        ?>
        <form action="editar_regalo.php" method="post">
            <input type="hidden" name="idRegalo" value="<?php echo $fila['idRegalo']; ?>">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Regalo:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $fila['nombre']; ?>">
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" id="precio" name="precio" value="<?php echo $fila['precio']; ?>">
            </div>
            <div class="mb-3">
                <label for="idReyFK" class="form-label">Elegir Rey:</label>
                <select class="form-select" id="idReyFK" name="idReyFK">
                    <option value="1" <?php if ($fila['idReyFK'] == 1) echo 'selected'; ?>>Melchor</option>
                    <option value="2" <?php if ($fila['idReyFK'] == 2) echo 'selected'; ?>>Gaspar</option>
                    <option value="3" <?php if ($fila['idReyFK'] == 3) echo 'selected'; ?>>Baltasar</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
        </form>
        <?php
                } else {
                    echo "<p>No se encontró el regalo.</p>";
                }
            }
        ?>
        <a class="btn btn-dark mt-3" href="regalos.php">Volver a Regalos</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
