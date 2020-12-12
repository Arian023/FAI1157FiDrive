<?php $Titulo = "Compartir archivo - FiDrive"; 
include_once("../../vista/estructura/cabecera.php");

// Llama al objeto con métodos para manejar carga de archivos:
$control = new control_archivos();
$datosIng = data_submitted();

// Muestra error si no hay datos recibidos:
if ( empty($datosIng) ) {
	echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
	<i class='fas fa-question-circle mx-2'></i>No se recibieron datos para realizar la operación.</div>";
} else {
	switch ( $control->compartir($datosIng) ) {
		case 0: 
			$mensaje = "<div class='alert alert-success text-center m-3 p-3' role='alert'>
			<i class='fas fa-check-circle mx-2'></i>Se compartió ".$datosIng['acnombre']." - Enlace:<br><br>
			<input type=text class='form-control user-select-all' name=enlace id=enlace readonly value=".$datosIng['enlace']." >
			</div>";
			break;
		case 1:
			$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
			<i class='fas fa-times-circle mx-2'></i>
			<b>Error al cargar datos de ".$datosIng['acnombre']." en tabla archivocargado</b>."
			."</div>";
			break;
		case 2:
			$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
			<i class='fas fa-times-circle mx-2'></i>
			<b>Error al cargar datos de ".$datosIng['acnombre']." en tabla archivocargadoestado</b>."
			."</div>";
			break;
		default:
			$mensaje = "<div class='alert alert-warning text-center m-3 p-3' role='alert'>
			<i class='fas fa-question-circle mx-2'></i>
			<b>Error desconocido en la operación</b> 
			</div>";
			break;
	}
}
?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-share-alt-square mx-2"></i>Compartir archivo:</h4>

	<div class="container-md">
		<?=$mensaje?>
	</div> <!-- Fin div mensaje -->
</div> <!-- Fin div contenido -->

<hr class=my-4>
<div class=row>
	<div class=col><a href="../index/contenido.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-folder mx-2'></i>Volver al Listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); ?>
