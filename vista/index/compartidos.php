<?php $Titulo = "Ver archivos compartidos - FiDrive"; 
include_once("../../vista/estructura/cabecera.php");
// Llama al objeto con métodos para manejar carga de archivos:
$control = new control_archivos();

if (empty($_GET)) {
	// Si carga la página desde afuera (por defecto)
	$posActual = "../archivos/";
} else {
	// Si entró a una subcarpeta
	$posActual = $_GET['en'];
}
?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">Ver archivos compartidos</h1>
	<hr class="my-2">
	<ul class="lead">
		<li>Crear un archivo, en la carpeta vista,  llamado compartidos.php que muestre recursivamente los archivos contenidos en la carpeta llamada archivo y que estén compartidos. Este archivo debe incluir los archivos: cabecera.php, pie.php y menu.php.</li>
		<li>Agregar al archivo  compartidos.php un botón, que permita dejar de compartir un archivo actualmente compartido. Este botón, debe llamar al formulario eliminararchivocompartido.php creado en la Entrega 1.</li>
	</ul>
</div> <!-- Fin div consigna -->

<hr>

<div class="container p-2" id=contenido> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class='fas fa-folder mx-2'></i>Listado en "<?= $posActual ?>":</h4>
	<div class="row justify-content-start">
		<div class="col-md-4 justify-content-start">
		<?php // Agrega botón si no está parado en la raíz. Es más complejo armar la navegación yendo a nivel arriba (idea: cortar substring por barra '/' )
		if ($posActual != "../archivos/") echo "<a href='../vista/contenido.php' class='btn btn-secondary'><i class='fas fa-arrow-left mx-2'></i>Volver a raíz</a>";
		?>
		</div>
	</div> <!-- Fin menú navegación -->
	<hr>

	<div class="container-md row"> <!-- Comienzo div archivos mostrados -->
		
	<?php
	// Controla que la ubicación actual exista, para evitar ejecutar con errores al listar
	if (!is_dir($posActual)) {
		echo "<div class='col alert alert-secondary text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>La ubicación actual no existe</div>";
	} else {
	// Obtiene los nombres de carpetas en la ubicación actual:
	$listadoCarpetas = $control->listarCarpetas($posActual);
	// Recorre todo el listado de archivos:
	if (!empty($listadoCarpetas)) {
		foreach ($listadoCarpetas as $clave => $nombreCarpeta) {
			// Muestra cada carpeta en una tarjeta animada cajaIcono:
			echo "<div class='card col-md-4 col-sm-5 m-1 border-info cajaIcono' title='Carpeta: $nombreCarpeta'>";
			echo "<h1 class='text-center'><i class='fas fa-folder m-3'></i></h1>";
			echo "<div class='card-body p-1'>";
			// Por CSS se corta el texto largo con clase .elipsis
			echo "<h5 class='card-title text-center elipsis'>".$nombreCarpeta."</h5>";
			// El link generado concatena la ruta a la carpeta raíz, la carpeta, y una barra:
			echo "<a class='btn btn-secondary btn-block btn-sm' href=\"../vista/compartidos.php?en=".($posActual.$nombreCarpeta)."/\"/>
			Ir a carpeta<i class='fas fa-folder-open mx-1'></i></a>";
			echo "</div>\n</div>\n <!-- Fin tarjeta carpeta -->";
		}
	} // -- Termina de listar carpetas --
	
	// Obtiene los nombres de archivos en la ubicación actual:
	$listadoArchivos = $control->listarArchivos($posActual);
	// Recorre todo el listado de archivos:
	if (empty($listadoArchivos)) {
		echo "<div class='col alert alert-secondary text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>No hay archivos en esta carpeta</div>";
	} else {
	foreach ($listadoArchivos as $clave => $nombreArchivo) {
		// De manera provisoria por esta entrega, lo toma en base a la extensión del archivo, luego se reemplazará leyendo de la BD según el elegido por el usuario
		$iconoFA = $control->mostrarIcono($nombreArchivo);
		// Muestra cada archivo en una tarjeta animada cajaIcono:
		echo "<div class='card col-md-4 col-sm-5 m-1 border-info cajaIcono' title='Archivo: $nombreArchivo'>";
		echo "<h1 class='text-center'><i class='$iconoFA m-3'></i></h1>";
		echo "<div class='card-body p-1'>";
		// Por CSS se corta el texto largo con clase .elipsis
		echo "<h5 class='card-title text-center elipsis'>".$nombreArchivo."</h5>";
		echo "<div class='btn-group' role='group'>
			<a class='btn btn-secondary btn-block btn-sm' href=\"".($posActual.$nombreArchivo)."\" >Detalles <i class='fas fa-eye mx-1'></i></a>
			<a class='btn btn-secondary btn-sm' title=Compartir href='../vista/compartirarchivo.php?nombre=$nombreArchivo&ruta=$posActual' >
			<i class='fas fa-share'></i></a>
			<a class='btn btn-secondary btn-sm' title='Dejar de compartir' href='../vista/eliminararchivocompartido.php?nombre=$nombreArchivo&ruta=$posActual&modificar=1' >
			<i class='fas fa-ban'></i></a>
		</div>";
		// Tip: Hacer que el botón dirija a una página: onclick="window.location.href='https://w3docs.com';"
		echo "</div>\n</div> <!-- Fin tarjeta archivo -->";
		// IDEA: Usar un Modal para ver detalles de X archivo, donde se muestre el título, link para compartir (directo al archivo subido), fecha subida, tamaño y la descripción
	}
	} // -- Termina de listar archivos --
	} // -- Fin if para evitar error de que la ubicación no existe --
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->

<hr>
<a href="../index/index.php" class="btn btn-outline-dark"><i class='fas fa-home mx-2'></i>Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); ?>
