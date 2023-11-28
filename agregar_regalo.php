<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Nuevo Regalo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Añadir Nuevo Regalo</h1>
        <?php
        require_once 'conexion.php';

        class Regalos extends Conexion {
            public function agregarRegalo($nombre, $precio, $idReyFK) {
                $consulta = "INSERT INTO regalos (nombre, precio, idReyFK) VALUES ('$nombre', '$precio', '$idReyFK')";
                $resultado = mysqli_query($this->conexion, $consulta);

                if ($resultado) {
                    echo "<p>Regalo añadido exitosamente.</p>";
                } else {
                    echo "<p>Error al añadir el regalo.</p>";
                }
            }
        }
        ?>
        <form action="agregar_regalo.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Regalo:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio:</label>
                <input type="text" class="form-control" id="precio" name="precio" placeholder="Ejemplo: 60.95" required>
            </div>
            <div class="mb-3">
                <label for="idReyFK" class="form-label">Elegir Rey:</label>
                <select class="form-select" id="idReyFK" name="idReyFK" required>
                    <option value="1">Melchor</option>
                    <option value="2">Gaspar</option>
                    <option value="3">Baltasar</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Añadir Regalo</button>
            </form>
        <?php
        $nuevoRegalo = new Regalos();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $precio = $_POST['precio'];
            $idReyFK = $_POST['idReyFK'];

            $nuevoRegalo->agregarRegalo($nombre, $precio, $idReyFK);
        }
        ?>
        <a class="btn btn-dark mt-3" href="regalos.php">Volver a Regalos</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
