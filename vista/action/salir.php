<?php include_once("../../configuracion.php");
// Sin importar si hay sesión activa, borra la sesión al ejecutarse este sitio, y redirige a la página principal
$sesion = new Session;
$sesion->cerrar();
header('Location: http://'.$_SERVER['HTTP_HOST'].'/FAI1157FiDrive/vista/index/index.php?login=2');
?>