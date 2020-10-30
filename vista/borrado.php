<?php $Titulo = "Borrado de archivo - FiDrive"; 
include_once("../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-thrash mx-2"></i>Borrado del archivo:</h4>

	<div class="container-md">
	<?php
	// Llama al objeto con métodos para manejar carga de archivos:
	$control = new control_archivos();
	$datosIng = data_submitted();

	// Muestra error si no hay datos recibidos:
	if ( empty($datosIng) ) {
		echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>No se recibieron datos para realizar el borrado.</div>";
	} else {
		// Se identifica la ruta y nombre del archivo a borrar:
		// $ruta = $datosIng['ruta'];
		$nombre = $datosIng['nombre'];
		// Usado en futura entrega:
		$motivo = $datosIng['descripcion'];
		
		$codError = $control->borrar($ruta, $nombre);
		// Borra el archivo del servidor
		// Nota: en otra entrega se completará la función para borrar demás elementos de la base de datos
		if ( $codError==0 ) { // Abre div según color de resultado
			echo "<div class='alert alert-success text-center m-3 p-3' role='alert'><i class='fas fa-check-circle mx-2'></i>"; // "Archivo X borrado con éxito"
		} else {
			echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'><i class='fas fa-times-circle mx-2'></i><b>Error</b>: ";
		}
		echo $control->errorBorrado($codError, $nombre)."</div>"; // Cierra div con mensaje
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
