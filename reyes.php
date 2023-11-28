<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reyes Magos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="pb-3 text-center">Reyes Magos</h1>
<?php
require_once 'conexion.php';

class Reyes extends Conexion {
    public function mostrarRegalosPorRey($idReySeleccionado = null) {
        $conexion = $this->conexion;
        $nombresReyes = array(
            1 => 'Melchor',
            2 => 'Gaspar',
            3 => 'Baltasar'
        );
?>
<form method='get' class="text-center">
    <label for='idRey'>Elige la consulta:</label>
    <select name='idRey' id='idRey' onchange='this.form.submit()'>
    <option value=''>Seleccionar Rey Mago</option>
<?php
        // Recorremos cada elemento del array
        foreach ($nombresReyes as $id => $nombre) {
            $selected = ($idReySeleccionado == $id) ? 'selected' : '';
            echo "<option value='$id' $selected>$nombre</option>";
        }
?>
</select>
</form>
<?php
if ($idReySeleccionado !== null && isset($nombresReyes[$idReySeleccionado])) {
    $consultaCarbón = "SELECT ninios.nombre AS Niño, 'Carbón' AS Regalo, 0 AS Precio
                        FROM ninios 
                        WHERE buenoMalo = 0";

    $consultaRegalos = "SELECT ninios.nombre AS Niño, regalos.nombre AS Regalo, regalos.precio AS Precio
                        FROM regalos 
                        INNER JOIN pedidos ON regalos.idRegalo = pedidos.idRegaloFK
                        INNER JOIN ninios ON pedidos.idNinioFK = ninios.idNinio
                        WHERE regalos.idReyFK = $idReySeleccionado AND ninios.buenoMalo = 1";

    if($idReySeleccionado == 1){
    $resultadoCarbon = mysqli_query($conexion, $consultaCarbón);
    }
    $resultadoRegalos = mysqli_query($conexion, $consultaRegalos);

    if ($resultadoRegalos) {
        echo "<h2 class='py-4'>Regalos {$nombresReyes[$idReySeleccionado]}</h2>";
?>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Regalo</th>
                    <th>Niño</th>
                </tr>
            </thead>
            <tbody>
<?php
        $totalPrecio = 0; 
        if($idReySeleccionado == 1){
            while ($filaCarbon = mysqli_fetch_assoc($resultadoCarbon)) {
                echo "<tr><td>{$filaCarbon['Regalo']}</td><td>{$filaCarbon['Niño']}</td></tr>";
            }
        }
        while ($filaRegalo = mysqli_fetch_assoc($resultadoRegalos)) {
            echo "<tr><td>{$filaRegalo['Regalo']}</td><td>{$filaRegalo['Niño']}</td></tr>";
            $totalPrecio += $filaRegalo['Precio']; 
        }

        echo "<tr><td colspan='2' class='text-bg-secondary text-center'>Precio total: {$totalPrecio} €</td></tr>";
?>
                </tbody>
                </table>
<?php
            } 
            else {
                echo "Error al obtener los datos: " . mysqli_error($conexion);
            }
        } elseif ($idReySeleccionado !== null) {
?>
        <h5 class="py-3 text-danger">Por favor, elige un Rey Mago para ver la consulta.</h5>
<?php
        }
    }
}

$reyes = new Reyes();

if (isset($_GET['idRey'])) {
    $idReySeleccionado = $_GET['idRey'];
    $reyes->mostrarRegalosPorRey($idReySeleccionado);
} else {
    $reyes->mostrarRegalosPorRey();
}
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

