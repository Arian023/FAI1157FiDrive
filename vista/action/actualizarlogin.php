<?php $Titulo = "TP5 - Actualizar usuario"; 
include_once("../estructura/cabecera.php");
// Lee los datos recibidos:
$datosIng = data_submitted();
// Llama al objeto con métodos para manejar ABM de usuarios:
$objAbmUsuario = new abmusuario();
if ( !empty($datosIng) )  {
    // Realiza la operación y muestra el resultado:
    if ($objAbmUsuario->modificacion($datosIng)){
        $mensaje = "<div class='alert alert-info' role='alert'>
        <i class='fas fa-check-circle mx-2'></i>Se modificó correctamente el usuario.
        </div>";
    } else {
        $mensaje = "<div class='alert alert-danger' role='alert'>
        <i class='fas fa-times-circle mx-2'></i>Hubo un error al modificar el usuario.
        </div>";
    }
} else {
    // Muestra error si directamente no hay datos recibidos:
    $mensaje = "<div class='alert alert-danger' role='alert'>No se recibieron datos.</div>";
} ?>

<div class="card p-2 shadow" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=ejercicio> <!-- Comienzo div resultado -->
	<h4 class="text-center mb-4"><i class="fas fa-search mx-2"></i>Resultado:</h4>
    <?=$mensaje?>
</div> <!-- Fin div resultado-->
<div class=row>
	<div class=col><a href="../index/listausuarios.php" class="btn btn-outline-dark btn-block">
		<i class="fas fa-arrow-left mx-2"></i>Volver al listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../estructura/pie.php");?>