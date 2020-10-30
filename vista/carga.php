<?php $Titulo = "Carga del archivo - FiDrive"; 
include_once("../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-upload mx-2"></i>Carga del archivo:</h4>

	<div class="container-md">
	<?php
	// Llama al objeto con métodos para manejar carga de archivos:
	$control = new control_archivos();
	$datosIng = data_submitted();

	// Muestra error si no hay datos recibidos:
	if ( empty($datosIng) ) {
		echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>No se recibieron datos para generar la carga.</div>";
	} else {
		// Si fue alta, se lee el nombre del archivo subido
		$archivo = $_FILES['archivoIng'];
		if ($datosIng['mod'] == 0) {
			// Compara también el cero con null, es decir que realiza un alta si no hay parámetro modificar
			if (empty($_FILES) )  {
				echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
				<i class='fas fa-question-circle mx-2'></i>No hay ningún archivo cargado.</div>";
			} else {
				// Guarda el archivo en el servidor
				switch ($control->guardarComo($archivo, $datosIng)) {
				case 0: 
					echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
					<i class='fas fa-check-circle mx-2'></i><h6>Carga exitosa: </h6>"
					.$control->datosArchivo($archivo).
					"<button type=button class=close data-dismiss=alert aria-label=Close>
					<span aria-hidden=true>&times;</span></button>
					</div>";
					break;
				case 1:
					echo "<div class='alert alert-danger' role='alert'>
					<i class='fas fa-times-circle mx-2'></i><b>Error en la copia del archivo</b>: ".$control->errorCarga($archivo)."
					</div>";
					break;
				case 2:
					echo "<div class='alert alert-danger' role='alert'>
					<i class='fas fa-times-circle mx-2'></i><b>Error al cargar datos en archivocargado (¿El usuario no existe?)</b> 
					</div>";
					break;
				case 3:
					echo "<div class='alert alert-danger' role='alert'>
					<i class='fas fa-times-circle mx-2'></i><b>Error al cargar datos en archivocargadoestado (¿El estadotipos 1 de 'Cargado' no existe?)</b> 
					</div>";
					break;
				default:
					echo "<div class='alert alert-warning' role='alert'>
					<i class='fas fa-question-circle mx-2'></i><b>Error desconocido</b> 
					</div>";
					break;
				}
			}
		} else { // Si campo 'modificar' es cualquier otro valor, toma dicha operación
			// Llama a un control que más adelante conectaría con la base de datos para ingresar los nuevos datos
			if ( $control->modificar($datosIng) ) {
				echo "<div class='alert alert-success' role='alert'><i class='fas fa-check-circle mx-2'></i>Modificación exitosa: ".$titulo.".</div>";
			} else {
				echo "<div class='alert alert-danger' role='alert'><i class='fas fa-times-circle mx-2'></i>Hubo un error al modificar: ".$titulo.".</div>";
			}
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
