<?php $Titulo = "Dejar de compartir archivo - FiDrive"; 
include_once("../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-lock mx-2"></i>Dejar de compartir archivo:</h4>

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
		// Se identifica la ruta y nombre del archivo a dejar de compartir:
		$ruta = $datosIng['ruta'];
		$nombre = $datosIng['nombre'];
		// Usado en futura entrega:
		$motivo = $datosIng['descripcion'];
		
		// Nota: En otra entrega se completará la función para insertar en la base de datos
		// Realiza operación y según resultado que retorna, muestra éxito o error
		if ( $control->noCompartir($ruta, $nombre, $motivo) ) { 
			echo "<div class='alert alert-success text-center m-3 p-3' role='alert'><i class='fas fa-check-circle mx-2'></i>Se dejó de compartir $nombre con éxito</div>";
		} else {
			echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'><i class='fas fa-times-circle mx-2'></i><b>Hubo un problema en la operación</b></div>";
		}
	}
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->

<hr>
<div class=row>
	<div class=col><a href="../vista/contenido.php" class="btn btn-outline-dark btn-block"><i class='fas fa-folder mx-2'></i>Volver al Listado</a></div>
	<div class=col><a href="../vista/index.php" class="btn btn-outline-dark btn-block"><i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../vista/estructura/pie.php"); ?>
