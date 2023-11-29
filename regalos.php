<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Regalos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Listado de Regalos</h1>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Rey Mago</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
<?php
require_once 'conexion.php';

class Regalos extends Conexion {
    public function getRegalos() {
        $consulta = "SELECT regalos.idRegalo, regalos.nombre, regalos.precio, reyes.nombre AS nombre_rey 
                     FROM regalos 
                     INNER JOIN reyes ON idReyFK = idRey 
                     ORDER BY regalos.nombre ASC;";
        $resultado = mysqli_query($this->conexion, $consulta);

        if (!$resultado) {
            echo "Error al obtener los datos: " . mysqli_error($this->conexion);
            return [];
        }

        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo '<tr>';
            echo "<td>{$fila['idRegalo']}</td>";
            echo "<td>{$fila['nombre']}</td>";
            echo "<td>{$fila['precio']}</td>";
            echo "<td>{$fila['nombre_rey']}</td>";
            echo "<td><a class='btn btn-outline-primary btn-sm' href='editar_regalo.php?id={$fila['idRegalo']}'>Editar</a> <a class='btn btn-outline-danger btn-sm' href='eliminar_regalo.php?id={$fila['idRegalo']}'>Eliminar</a></td>";
            echo '</tr>';
        }
    }
}

$listaRegalos = new Regalos();
$listaRegalos->getRegalos();
?>
            </tbody>
        </table>
        <a class="btn btn-success" href="agregar_regalo.php">Añadir un Regalo</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
