<?php $Titulo = "Carga del archivo - FiDrive"; 
include_once("../../vista/estructura/cabecera.php");

// Llama al objeto con métodos para manejar carga de archivos:
$control = new control_archivos();
$datosIng = data_submitted();

// Muestra error si no hay datos recibidos:
if ( empty($datosIng) ) {
	$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
	<i class='fas fa-question-circle mx-2'></i>No se recibieron datos para generar la carga.</div>";
} else {
	if ($datosIng['mod'] == 0) {
		// Compara también el cero con null, es decir que realiza un alta si no hay parámetro modificar
		if (empty($_FILES) )  {
			$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
			<i class='fas fa-question-circle mx-2'></i>No hay ningún archivo cargado.</div>";
		} else {
			// Guarda el archivo en el servidor
			switch ($control->guardarComo($_FILES['archivoIng'], $datosIng)) {
			case 0: 
				$mensaje = "<div class='alert alert-success alert-dismissible fade show text-center m-3 p-3' role='alert'>
				<i class='fas fa-check-circle mx-2'></i><b>Carga exitosa: </b><br>"
				.$control->datosArchivo($_FILES['archivoIng']).
				"<button type=button class=close data-dismiss=alert aria-label=Close>
				<span aria-hidden=true>&times;</span></button>
				</div>";
				break;
			case 1:
				$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
				<i class='fas fa-times-circle mx-2'></i>
				<b>Error en la copia del archivo</b>: ".$control->errorCarga($_FILES['archivoIng'])."
				</div>";
				break;
			case 2:
				$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
				<i class='fas fa-times-circle mx-2'></i>
				<b>Error al cargar datos en archivocargado</b> (¿El usuario no existe?) 
				</div>";
				break;
			case 3:
				$mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
				<i class='fas fa-times-circle mx-2'></i>
				<b>Error al cargar datos en archivocargadoestado</b> (¿El estadotipos 1 de 'Cargado' no existe?) 
				</div>";
				break;
			default:
				$mensaje = "<div class='alert alert-warning text-center m-3 p-3' role='alert'>
				<i class='fas fa-question-circle mx-2'></i>
				<b>Error desconocido en la carga</b> 
				</div>";
				break;
			}
		}
	} else { // Si campo 'modificar' es cualquier otro valor, toma dicha operación
		switch ( $control->modificar($datosIng) ) {
		case 0: $mensaje = "<div class='alert alert-success text-center m-3 p-3' role='alert'>
			<i class='fas fa-check-circle mx-2'></i>
			Modificación exitosa: ".$datosIng['acnombre']
			.".</div>";
			break;
		case 1: $mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
			<i class='fas fa-times-circle mx-2'></i>
			<b>Hubo un error al modificar registro de ".$datosIng['acnombre']
			.".</b></div>";
			break;
		case 2: $mensaje = "<div class='alert alert-danger text-center m-3 p-3' role='alert'>
			<i class='fas fa-times-circle mx-2'></i>
			Modificado con error: <b>No se pudo cargar nuevo estado en archivocargadoestado, del archivo </b> "
			.$datosIng['acnombre'].". </div>";
			break;
		default:
			$mensaje = "<div class='alert alert-warning text-center m-3 p-3' role='alert'>
			<i class='fas fa-question-circle mx-2'></i><b>Error desconocido en la modificación.</b> 
			</div>";
			break;
		}
	}
}
?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-upload mx-2"></i><?php echo $datosIng['mod']==0 ? "Carga" : "Modificación" ?> del archivo:</h4>

	<div class="container-md">
		<?= $mensaje ?>
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
