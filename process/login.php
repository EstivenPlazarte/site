<?php
session_start();
include '../library/configServer.php';
include '../library/consulSQL.php';
sleep(2);

$nombre = $_POST['nombre-login'];
$clave = md5($_POST['clave-login']);
$radio = $_POST['optionsRadios'];

if (!$nombre == "" && !$clave == "") {
    $conexion = ejecutarSQL::conectar(); // Obtener conexión establecida

    // Consultar clientes
    $verUser = $conexion->query("SELECT * FROM cliente WHERE Nombre='$nombre' AND Clave='$clave'");

    // Consultar administradores
    $verAdmin = $conexion->query("SELECT * FROM administrador WHERE Nombre='$nombre' AND Clave='$clave'");

    if ($radio == "option2") {
        $AdminC = $verAdmin->num_rows; // Contar filas de la consulta de administradores
        if ($AdminC > 0) {
            $_SESSION['nombreAdmin'] = $nombre;
            $_SESSION['claveAdmin'] = $clave;
            echo '<script> location.href="index.php"; </script>';
        } else {
            echo '<img src="assets/img/error.png" class="center-all-contens"><br>Error nombre o contraseña inválido';
        }
    }
    if ($radio == "option1") {
        $UserC = $verUser->num_rows; // Contar filas de la consulta de clientes
        if ($UserC > 0) {
            $_SESSION['nombreUser'] = $nombre;
            $_SESSION['claveUser'] = $clave;
            echo '<script> location.href="index.php"; </script>';
        } else {
            echo '<img src="assets/img/error.png" class="center-all-contens"><br>Error nombre o contraseña inválido';
        }
    }
} else {
    echo '<img src="assets/img/error.png" class="center-all-contens"><br>Error campo vacío<br>Intente nuevamente';
}
