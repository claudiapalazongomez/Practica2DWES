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

        // Obtener nombres completos de los niños
        $consulta = "SELECT idNinio, CONCAT(nombre, ' ', apellidos) AS nombreCompleto FROM ninios";
        $resultado = mysqli_query($this->conexion, $consulta);

        if (!$resultado) {
            echo "Error al obtener los datos: " . mysqli_error($this->conexion);
            return [];
        }

        if (mysqli_affected_rows($conexion) > 0) {
?>
        <h2 class="py-4">Buscar los regalos de...</h2>
        <form method="get">
            <label for="idNinio">Seleccionar Niño:</label>
            <select name="idNinio" id="idNinio" onchange="this.form.submit()">
            <option value="">Seleccionar Niño</option>

<?php
        while ($ninio = mysqli_fetch_assoc($resultado)) {
        $idNinio = $ninio['idNinio'];
        $nombreCompleto = $ninio['nombreCompleto'];
        echo "<option value='$idNinio'>$nombreCompleto</option>";
        }
?>

            </select>
        </form>

<?php
        if (isset($_GET['idNinio'])) {
            $idNinioSeleccionado = $_GET['idNinio'];

            // Consulta para obtener el nombre del niño seleccionado
            $nombreNinio = "SELECT CONCAT(nombre, ' ', apellidos) AS nombreCompleto 
                            FROM ninios 
                            WHERE idNinio = $idNinioSeleccionado";
            $resultadoNombreNinio = mysqli_query($this->conexion, $nombreNinio);

            if ($resultadoNombreNinio && mysqli_num_rows($resultadoNombreNinio) > 0) {
                $filaNombreNinio = mysqli_fetch_assoc($resultadoNombreNinio);
                $nombreNinioElegido = $filaNombreNinio['nombreCompleto'];
            }

            // Consulta para obtener los regalos del niño seleccionado
            $regalosNinio = "SELECT regalos.nombre AS nombreRegalo
                             FROM regalos
                             INNER JOIN pedidos ON regalos.idRegalo = pedidos.idRegaloFK
                             WHERE pedidos.idNinioFK = $idNinioSeleccionado";

            $resultadoRegaloNinio = mysqli_query($this->conexion, $regalosNinio);                        

            if (mysqli_affected_rows($conexion) > 0) {
?>
            
            <h2 class="py-4">Regalos de <?php echo $nombreNinioElegido ?></h2>
            <ul>
<?php
            while ($regaloElegido = mysqli_fetch_assoc($resultadoRegaloNinio)) {
            $nombreRegalo = $regaloElegido['nombreRegalo'];
            echo "<li>$nombreRegalo</li>";
            }
?>
            </ul>

            <h2 class="py-4">Agregar regalo a <?php echo $nombreNinioElegido ?></h2>
            <form method="post">
                <input type="hidden" name="idNinio" value="<?php echo $idNinioSeleccionado; ?>">
                <label for="idRegalo">Seleccionar Regalo:</label>
                <select name="idRegalo" id="idRegalo">
                <option value="">Seleccionar Regalo</option>
<?php
            // Consulta para obtener regalos disponibles
            $regalosExistentes = "SELECT idRegalo, nombre FROM regalos";
            $resultadoRegaloExistente = mysqli_query($this->conexion, $regalosExistentes);

            while ($filaRegalo = mysqli_fetch_assoc($resultadoRegaloExistente)) {
                $idRegalo = $filaRegalo['idRegalo'];
                $nombreRegalo = $filaRegalo['nombre'];
                echo "<option value='$idRegalo'>$nombreRegalo</option>";
            }
?>
                </select>
                <br>
                <button type="submit" class="btn btn-success">Agregar Regalo</button>
            </form>
<?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idNinio'], $_POST['idRegalo'])) {
                $idNinio = $_POST['idNinio'];
                $idRegalo = $_POST['idRegalo'];

                // Verificar si el regalo NO ha sido ya seleccionado
                $verificarRegalo = "SELECT COUNT(*) AS contador 
                                    FROM pedidos 
                                    WHERE idNinioFK = $idNinio AND idRegaloFK = $idRegalo";
                $resultadoVerificar = mysqli_query($this->conexion, $verificarRegalo);

                if ($resultadoVerificar) {
                    $filaVerificada = mysqli_fetch_assoc($resultadoVerificar);
                    $contadorRegalo = $filaVerificada['contador'];

                    if ($contadorRegalo > 0) {
                        echo "<p>Este regalo ya fue asignado al niño.</p>";
                    } else {
                        // Agregar el regalo al niño
                        $consultaAgregar = "INSERT INTO pedidos (idNinioFK, idRegaloFK) VALUES ($idNinio, $idRegalo)";
                        $resultadoAgregar = mysqli_query($this->conexion, $consultaAgregar);

                        if ($resultadoAgregar) {
                            echo "<p>Regalo agregado exitosamente al niño.</p>";
                        } else {
                            echo "<p>Error al agregar el regalo al niño.</p>";
                        }
                    }
                } else {
                    echo "<p>Error al verificar el regalo.</p>";
                }
            }
            } else { 
?>        
            <h2 class='py-4'>Regalos de <?php echo $nombreNinioElegido ?></h2>
            <p>No se encontraron regalos para este niño.</p>

            <h2 class='py-4'>Agregar regalo a <?php echo $nombreNinioElegido?></h2>
            <form method='post'>
                <input type='hidden' name='idNinio' value=<?php echo $idNinioSeleccionado; ?>>
                <label for='idRegalo'>Seleccionar Regalo:</label>
                <select name='idRegalo' id='idRegalo'>
                <option value=''>Seleccionar Regalo</option>
<?php          
                // Consulta para obtener regalos disponibles
                $regalosExistentes = "SELECT idRegalo, nombre FROM regalos";
                $resultadoRegaloExistente = mysqli_query($this->conexion, $regalosExistentes);
            
                while ($filaRegalo = mysqli_fetch_assoc($resultadoRegaloExistente)) {
                    $idRegalo = $filaRegalo['idRegalo'];
                    $nombreRegalo = $filaRegalo['nombre'];
                    echo "<option value='$idRegalo'>$nombreRegalo</option>";
                }
?>           
                </select>
                <br>
                <button type='submit' class='btn btn-success'>Agregar Regalo</button>
            </form>
<?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idNinio'], $_POST['idRegalo'])) {
                    $idNinio = $_POST['idNinio'];
                    $idRegalo = $_POST['idRegalo'];
        
                    // Verificar si el regalo NO ha sido ya seleccionado
                    $verificarRegalo = "SELECT COUNT(*) AS contador 
                                        FROM pedidos 
                                        WHERE idNinioFK = $idNinio AND idRegaloFK = $idRegalo";
                    $resultadoVerificar = mysqli_query($this->conexion, $verificarRegalo);
        
                    if ($resultadoVerificar) {
                        $filaVerificada = mysqli_fetch_assoc($resultadoVerificar);
                        $contadorRegalo = $filaVerificada['contador'];
        
                        if ($contadorRegalo > 0) {
                            echo "<p>Este regalo ya fue asignado al niño.</p>";
                        } else {
                            // Agregar el regalo al niño
                            $consultaAgregar = "INSERT INTO pedidos (idNinioFK, idRegaloFK) VALUES ($idNinio, $idRegalo)";
                            $resultadoAgregar = mysqli_query($this->conexion, $consultaAgregar);
        
                            if ($resultadoAgregar) {
                                echo "<p>Regalo agregado exitosamente al niño.</p>";
                            } else {
                                echo "<p>Error al agregar el regalo al niño.</p>";
                            }
                        }
                    } else {
                        echo "<p>Error al verificar el regalo.</p>";
                    }
                }
            }
        }
        } else {
            echo "<p>No hay niños registrados.</p>";
        }
    }
}

    $busquedaRegalos = new BusquedaRegalos();
    $busquedaRegalos->mostrarFormularioBusqueda();
?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>