<?php
require_once 'conexion.php';

if (isset($_GET['id'])) {
    $idRegalo = $_GET['id'];
    $conexion = new Conexion();
    $consulta = "DELETE FROM regalos WHERE idRegalo = $idRegalo";
    $resultado = mysqli_query($conexion->conexion, $consulta);

    if ($resultado) {
        header("Location: regalos.php");
        exit();
    } else {
        echo "Error al eliminar el regalo.";
    }
} else {
    echo "No se proporcionó un ID de regalo válido.";
}
?>