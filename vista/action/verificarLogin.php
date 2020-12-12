<?php include_once("../../configuracion.php");
// Lee los datos recibidos:
$datosIng = data_submitted();
if ( !empty($datosIng) )  {
    $sesion = new Session;
    
    // echo "<h3> Clave recibida: ".$datosIng['usclave']." </h3>";

    // El método iniciar verifica si el usuario está habilitado, y su clave es correcta
    if ($sesion->iniciar($datosIng['uslogin'], $datosIng['usclave'])){
        echo "<h3> Inició con éxito</h3>";
        // Si se encuentra usuario, inicia la sesión y redirige a la página segura:
        //header('Location: http://'.$_SERVER['HTTP_HOST'].$datosIng['enlaceVolver'].'?login=0');
    } else {
        echo "<h3> No inició </h3>";
        // Si no se encuentra, regresa al login mostrando error de usuario o clave:
        //header('Location: http://'.$_SERVER['HTTP_HOST'].$datosIng['enlaceVolver'].'?login=1');
    }
} else {
    // Muestra error si directamente no hay datos recibidos:
    header('Location: ../index/index.php?login=9');
} ?>