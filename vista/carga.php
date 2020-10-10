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
		// Datos a usar para alta o modificación:
		$ruta = $datosIng['ruta'];
		if (isset($_FILES)) {
			// Si fue alta, se lee el nombre del archivo subido
			$archivo = $_FILES['archivoIng'];
			$nombre = $archivo['name'];
		} else {
			// Si fue una modificación, se lee el nombre del archivo seleccionado desde contenido
			$nombre = $datosIng['nombre'];
		}
		// Usados en futura entrega:
		$desc = $datosIng['descripcion'];
		$icono = $datosIng['icono'];
		$titulo = $datosIng['titulo'];
		// Provisoriamente para esta entrega se asume que el título es igual al nombre del archivo:
		if (!isset($titulo)) $titulo = $nombre;

		if ($datosIng['modificar'] == 0) {
			// Compara también el cero con null, es decir que realiza un alta si es true
			if (empty($_FILES) )  {
				echo "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
				<i class='fas fa-question-circle mx-2'></i>No hay ningún archivo cargado.</div>";
			} else {
				if (empty($ruta) || $ruta == "null") {
					// Revisa si se recibió ruta por parámetro (viene de contenido.php a amarchivo.php)
					$ruta = "../archivos/";
					echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>\n
					Aviso: Ruta no definida, se guardará en carpeta raíz de archivos.\n
					<button type=button class=close data-dismiss=alert aria-label=Close><span aria-hidden=true>&times;</span></button></div>";
				}
				// Guarda el archivo en el servidor
				// Nota: en otra entrega se llamará a guardarComo() con los demás parámetros (titulo, descripcion e icono)
				if ( $control->guardarEn($archivo, $ruta) ) {
					echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>\n
					<i class='fas fa-check-circle mx-2'></i><h6>Carga exitosa: </h6>\n"
					.$control->datosArchivo($archivo).
					"<button type=button class=close data-dismiss=alert aria-label=Close><span aria-hidden=true>&times;</span></button>\n
					</div>";
					echo "<a href='".$ruta.$nombre."' class='btn btn-outline-primary'> Ver archivo <b>".$titulo."</b> </a>";
				} else {
					// Si falló, muestra mensaje de error
					echo "<div class='alert alert-danger' role='alert'><i class='fas fa-times-circle mx-2'></i>
					<b>Error</b>: ".$control->errorCarga($archivo)." </div>";
				}
			}
		} else { // Si campo 'modificar' es cualquier otro valor, toma dicha operación
			// Revisa si falta la ruta o el nombre del archivo a modificar:
			if ( empty($ruta) || $ruta == "null" || empty($nombre) || $nombre = "null" ) {
				echo "<div class='alert alert-danger' role='alert'> Error: No está seleccionado ningún archivo o ruta al cual ingresar datos.</div>";
			} else {
				// Llama a un control que más adelante conectaría con la base de datos para ingresar los nuevos datos
				if ( $control->modificar($ruta, $nom, $titulo, $desc, $icono) ) {
					echo "<div class='alert alert-success' role='alert'><i class='fas fa-check-circle mx-2'></i>Modificación exitosa: ".$titulo.".</div>";
				} else {
					echo "<div class='alert alert-danger' role='alert'><i class='fas fa-times-circle mx-2'></i>Hubo un error al modificar: ".$titulo.".</div>";
				}
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
