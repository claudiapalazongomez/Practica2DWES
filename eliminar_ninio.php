<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $idNinio = $_GET['id'];
    $conexion = new Conexion();
    $consulta = "DELETE FROM ninios WHERE idNinio = $idNinio";
    $resultado = mysqli_query($conexion->conexion, $consulta);

    if ($resultado) {
        header("Location: ninos.php");
        exit();
    } else {
        echo "Error al eliminar al niño.";
    }
} else {
    echo "No se proporcionó un ID de niño válido.";
}
?>