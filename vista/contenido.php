<?php $Titulo = "Ver contenido - FiDrive"; 
include_once("../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">Ver contenido almacenado</h1>
	<hr class="my-2">
	<p class="lead">Crear un archivo, en la carpeta vista, llamado contenido.php que muestre recursivamente los archivos contenidos en la carpeta llamada archivo. Este archivo debe incluir los archivos: cabecera.php, pie.php y menu.php<br>
	Agregar los siguientes botones:<br>
	</p>
	<ul class="lead">
		<li>Que permita generar una nueva carpeta dentro de la carpeta que actualmente este seleccionada.</li>
		<li>Que permita cargar un archivo dentro de la carpeta actualmente este seleccionada. Este botón, debe llamar al formulario amarchivo.php creado en la Entrega 1.</li>
		<li>Que permita compartir un archivo actualmente este seleccionado. Este botón, debe llamar al formulario compartirarchivo.php creado en la Entrega 1. </li>
		<li>Que permita eliminar un archivo actualmente este seleccionado. Este botón, debe llamar al formulario eliminararchivo.php creado en la Entrega 1. </li>
	</ul>
</div> <!-- Fin div consigna -->

<hr>

<div class="container p-2" id=formulario> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class="fas fa-folder mx-2"></i>Listado de archivos:</h4>

	<div class="container-md row">
		
	<?php
	// Llama al objeto con métodos para manejar carga de archivos:
	$control = new control_archivos();
	$listadoArchivos = $control->listarArchivos();
	
	// Recorre todo el listado de archivos:
	if (empty($listadoArchivos)) {
		echo "<div class='alert alert-secondary' role='alert'>No hay ningún archivo cargado.</div>";
	} else {
	foreach ($listadoArchivos as $archivo) {
		if (strlen($archivo)>2 && strpos($archivo, "txt")<=0  && strpos($archivo, "pdf")<=0) {
			// Muestra cada archivo en una caja:
			echo "<div class='col-md3 mb-2'>\n";
			echo "<img alt='$archivo' class='' src='../archivos/$archivo' width='100%' height='80%'>\n";
			echo "<input type='submit' name='Seleccion:$archivo' id='Seleccion:$archivo' class='btn btn-secondary btn-block btn-sm' value='Ver Detalles »'></input>";
			echo "</div>";
		}
	}
	}
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->

<hr>
<a href="../vista/index.php" class="btn btn-outline-dark">Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../vista/estructura/pie.php"); ?>
