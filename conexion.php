<?php
class Conexion {
    private $servidor = "localhost"; // Cambia esto si tu base de datos está en otro servidor
    private $usuario = "studium";
    private $password = "studium__";
    private $bd = "studium_dws_p2";
    public $conexion;

    public function __construct() {
        $this->conexion = mysqli_connect($this->servidor, $this->usuario, $this->password, $this->bd);

        if (!$this->conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }
    }
}
?>

