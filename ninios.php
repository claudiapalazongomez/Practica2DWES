<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Niños</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
        <h1 class="pb-3 text-center">Listado de Niños</h1>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Bueno/Malo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php
require_once 'conexion.php';

class Ninios extends Conexion {
    public function getNinios() {
        $query = "SELECT * FROM ninios ORDER BY nombre ASC";
        $result = mysqli_query($this->conexion, $query);

        if (!$result) {
            echo "Error al obtener los datos: " . mysqli_error($this->conexion);
            return [];
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo "<td>{$row['idNinio']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['apellidos']}</td>";
            echo "<td>{$row['fechaNacimiento']}</td>";
            echo "<td>{$row['buenoMalo']}</td>";
            echo "<td><a class='btn btn-outline-primary btn-sm' href='editar.php?id={$row['idNinio']}'>Editar</a> <a class='btn btn-outline-danger btn-sm' href='eliminar.php?id={$row['idNinio']}'>Eliminar</a></td>";
            echo '</tr>';
        }
    }
}

$niniosObj = new Ninios();
$niniosObj->getNinios();
?>
            </tbody>
        </table>
        <a class="btn btn-success" href="añadir.php">Añadir nuevo niño</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

