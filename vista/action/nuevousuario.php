<?php $Titulo = "Nuevo usuario - FiDrive"; 
include_once("../estructura/cabecera.php");
// Lee los datos recibidos:
$datosIng = data_submitted();
// Llama al objeto con métodos para manejar ABM de usuarios:
$objAbmUsuario = new abmusuario();
if ( !empty($datosIng) )  {
    // Realiza la operación y muestra el resultado:
    if ($objAbmUsuario->alta($datosIng)){
        $sesion->iniciar($datosIng['uslogin'], $datosIng['usclave']);
        echo "<h3> Clave recibida: ".$datosIng['usclave']." - Clave segura: ".sha1('FiDrive'.$datosIng['usclave'])." </h3>";
        $mensaje = "<div class='alert alert-info' role='alert'>
        <i class='fas fa-check-circle mx-2'></i> <b>Ya estás registrado y puedes comenzar a utilizar el sitio.</b><br>
        <a href='../index/contenido.php' class='btn btn-outline-dark btn-block'>
		<i class='fas fa-upload mx-2'></i>Comenzar a cargar archivos</a>
        </div>";
    } else {
        $mensaje = "<div class='alert alert-danger' role='alert'>
        <i class='fas fa-times-circle mx-2'></i> <b>Hubo un problema al registrar tu cuenta.</b> (¿El nombre de usuario ya está ocupado?)
        </div>";
    }
} else {
    // Muestra error si directamente no hay datos recibidos:
    $mensaje = "<div class='alert alert-danger' role='alert'>No se recibieron datos para realizar el registro.</div>";
}?>

<div class="card p-2 shadow" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=ejercicio> <!-- Comienzo div resultado -->
	<h4 class="text-center mb-4"><i class="fas fa-user-plus mx-2"></i>Registro de usuario:</h4>
    <?=$mensaje?>

</div> <!-- Fin div resultado-->

<hr class=my-4>

<div class=row>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../estructura/pie.php");?>
