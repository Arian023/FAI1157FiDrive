<?php $Titulo = "Eliminar usuario - FiDrive"; 
include_once("../estructura/cabecera.php");
// Lee los datos recibidos:
$datosIng = data_submitted();
// Llama al objeto con métodos para manejar ABM de usuarios:
$AbmUsuario = new abmusuario();
if ( !empty($datosIng) )  {
    // Realiza la operación y muestra el resultado:
    if ($AbmUsuario->baja($datosIng)){
        if($datosIng['usactivo'] == 0) {
            $mensaje = "<h4 class='text-center mb-4'><i class='fas fa-user-minus mx-2'></i>Eliminación de cuenta:</h4>
            <div class='alert alert-info' role='alert'>
            <i class='fas fa-check-circle mx-2'></i> Se eliminó correctamente el usuario.
            </div>";
        } else {
            $mensaje = "<h4 class='text-center mb-4'><i class='fas fa-user-plus mx-2'></i>Reactivación de cuenta:</h4>
            <div class='alert alert-info' role='alert'>
            <i class='fas fa-check-circle mx-2'></i> Se habilitó correctamente el usuario.
            </div>";
        }
        
    } else {
        $mensaje = "<h4 class='text-center mb-4'><i class='fas fa-user-minus mx-2'></i>Eliminación de cuenta:</h4>
        <div class='alert alert-danger' role='alert'>
        <i class='fas fa-times-circle mx-2'></i> Hubo un error al eliminar el usuario.
        </div>";
    }
} else {
    // Muestra error si directamente no hay datos recibidos:
    $mensaje = "<h4 class='text-center mb-4'><i class='fas fa-user-times mx-2'></i>Eliminación de cuenta:</h4>
    <div class='alert alert-danger' role='alert'><i class='fas fa-question-circle mx-2'></i>No se especificó el usuario para la baja.</div>";
} ?>

<div class="card p-2 shadow" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=ejercicio> <!-- Comienzo div resultado -->
	
    <?=$mensaje?>
</div> <!-- Fin div resultado-->

<hr class=my-4>

<div class=row>
	<div class=col><a href="../index/listausuarios.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-users mx-2'></i>Volver al Listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../estructura/pie.php");?>