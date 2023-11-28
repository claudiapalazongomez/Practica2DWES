<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Búsqueda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Búsqueda</h1>
<?php
require_once 'conexion.php';

class BusquedaRegalos extends Conexion {
    public function mostrarFormularioBusqueda() {
        $conexion = $this->conexion;

        // Obtener nombres de los niños
        $consulta = "SELECT idNinio, CONCAT(nombre, ' ', apellidos) AS nombre_completo FROM ninios";
        $resultado = mysqli_query($this->conexion, $consulta);

        if (!$resultado) {
            echo "Error al obtener los datos: " . mysqli_error($this->conexion);
            return [];
        }

        if ($resultado->num_rows > 0) {
?>
        <h2>Buscar Regalos por Niño</h2>
        <form method="get">
            <label for="idNinio">Seleccionar Niño:</label>
            <select name="idNinio" id="idNinio" onchange="this.form.submit()">
            <option value="">Seleccionar Niño</option>

<?php
while ($row_ninio = $resultado->fetch_assoc()) {
$idNinio = $row_ninio['idNinio'];
$nombreNinio = $row_ninio['nombre_completo'];
echo "<option value='$idNinio'>$nombreNinio</option>";
}
?>

            </select>
        </form>
                    <?php

                    if (isset($_GET['idNinio'])) {
                        $idNinioSeleccionado = $_GET['idNinio'];

                        // Consulta para obtener los regalos del niño seleccionado
                        $query_regalos_ninio = "SELECT regalos.nombre AS nombre_regalo
                                                FROM regalos
                                                INNER JOIN pedidos ON regalos.idRegalo = pedidos.idRegaloFK
                                                WHERE pedidos.idNinioFK = $idNinioSeleccionado";

                        $result_regalos_ninio = $conexion->query($query_regalos_ninio);

                        if ($result_regalos_ninio->num_rows > 0) {
                            ?>
                            <h2>Regalos del Niño Seleccionado</h2>
                            <ul>
                                <?php
                                while ($row_regalo = $result_regalos_ninio->fetch_assoc()) {
                                    $nombreRegalo = $row_regalo['nombre_regalo'];
                                    echo "<li>$nombreRegalo</li>";
                                }
                                ?>
                            </ul>

                            <h2>Agregar Regalo al Niño Seleccionado</h2>
                            <form method="post" action="agregar_regalo.php">
                                <input type="hidden" name="idNinio" value="<?php echo $idNinioSeleccionado; ?>">
                                <!-- Desplegable para seleccionar un regalo -->
                                <label for="idRegalo">Seleccionar Regalo:</label>
                                <select name="idRegalo" id="idRegalo">
                                    <!-- Obtener opciones de regalos -->
                                    <?php
                                    $query_todos_regalos = "SELECT idRegalo, nombre FROM regalos";
                                    $result_todos_regalos = $conexion->query($query_todos_regalos);

                                    while ($row_regalo = $result_todos_regalos->fetch_assoc()) {
                                        $idRegalo = $row_regalo['idRegalo'];
                                        $nombreRegalo = $row_regalo['nombre'];
                                        echo "<option value='$idRegalo'>$nombreRegalo</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit">Agregar Regalo</button>
                            </form>
                            <?php
                        } else {
                            echo "<p>No se encontraron regalos para este niño.</p>";
                        }
                    }
                } else {
                    echo "<p>No hay niños registrados.</p>";
                }
                $conexion->close();
            }
        }

        $busquedaRegalos = new BusquedaRegalos();
        $busquedaRegalos->mostrarFormularioBusqueda();
        ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>