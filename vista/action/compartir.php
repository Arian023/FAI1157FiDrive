<?php $Titulo = "Compartir archivo - FiDrive"; 
include_once("../../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-share-alt-square mx-2"></i>Compartir archivo:</h4>

	<div class="container-md">
	<?php
	// Llama al objeto con métodos para manejar carga de archivos:
	$control = new control_archivos();
	$datosIng = data_submitted();

	// Muestra error si no hay datos recibidos:
	if ( empty($datosIng) ) {
		echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>No se recibieron datos para realizar la operación.</div>";
	} else {
		if ( $control->compartir($datosIng) ) {
			echo "<div class='alert alert-success text-center m-3 p-3' role='alert'>
			<i class='fas fa-check-circle mx-2'></i>Se compartió $nombre - Enlace:<br><br>
			<input type=text class=form-control name=enlace id=enlace readonly value=".$datosIng['enlace']." >
			</div>";
		} else {
			echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
			<i class='fas fa-times-circle mx-2'></i><b>Hubo un problema en la operación</b></div>";
		}
	}
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->

<hr>
<div class=row>
	<div class=col><a href="../index/contenido.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-folder mx-2'></i>Volver al Listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); ?>
