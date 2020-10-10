<?php $Titulo = "Ver contenido - FiDrive"; 
include_once("../vista/estructura/cabecera.php");
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

<div class="container p-2" id=contenido> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class='fas fa-folder mx-2'></i>Listado en "<?= $posActual ?>":</h4>
	<div class="row justify-content-start">
		<div class="col-md-4 justify-content-start">
		<?php // Agrega botón si no está parado en la raíz. Es más complejo armar la navegación yendo a nivel arriba (idea: cortar substring por barra '/' )
		if ($posActual != "../archivos/") echo "<a href='../vista/contenido.php' class='btn btn-secondary'><i class='fas fa-arrow-left mx-2'></i>Volver a raíz</a>";
		?>
		<a href='../vista/amarchivo.php?ruta=<?=$posActual?>&modificar=0' class="btn btn-info"><i class='fas fa-file-upload mx-2'></i>Cargar archivo</a>
		</div>
		<div class="col-md-8 form-inline justify-content-end">
		<form name=nuevacarpeta method=post action="contenido.php?en=<?=$posActual?>" class="needs-validation" novalidate>
			<div class="input-group">
				<input type=text name=nombre id=nombre class="form-control" placeholder="Nombre de la carpeta..." required>
				<div class="invalid-tooltip">Ingrese un nombre</div>
				<div class="input-group-append">
					<button type=submit id=nuevo class="btn btn-info"><i class='fas fa-folder-plus mx-2'></i>Nueva carpeta</button>
				</div>
			</div>
		</form>
		</div>
	</div> <!-- Fin menú navegación -->
	<hr>

	<?php
	// Ignora creación de archivos si no hay dato cargado:
	if ( !empty($_POST) ) {
		if ( $control->crearCarpeta($posActual, $_POST['nombre']) ) {
			echo "<div class='alert alert-info alert-dismissible fade show' role='alert'> <i class='fas fa-check-circle mx-2'></i>
			Carpeta <a href=\"../vista/contenido.php?en=".($posActual.$_POST['nombre'])."/\">".$_POST['nombre']."</a> creada
			<button type=button class=close data-dismiss=alert aria-label=Close><span aria-hidden=true>&times;</span></button></div>";
		} else {
			echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'><i class='fas fa-times-circle mx-2'></i>
			La carpeta <a href=\"../vista/contenido.php?en=".($posActual.$_POST['nombre'])."\">".$_POST['nombre']."</a> ya existe
			<button type=button class=close data-dismiss=alert aria-label=Close><span aria-hidden=true>&times;</span></button></div>";
		}
	}
	?>

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
		foreach ($listadoCarpetas as $clave => $nombreCarpeta) { // CORREGIR, aún no lista carpetas
			// Muestra cada carpeta en una tarjeta animada cajaIcono:
			echo "<div class='card col-md-4 col-sm-5 m-1 border-info cajaIcono' title='Carpeta: $nombreCarpeta'>";
			echo "<h1 class='text-center'><i class='fas fa-folder m-3'></i></h1>";
			echo "<div class='card-body p-1'>";
			// Por CSS se corta el texto largo con clase .elipsis
			echo "<h5 class='card-title text-center elipsis'>".$nombreCarpeta."</h5>";
			// El link generado concatena la ruta a la carpeta raíz, la carpeta, y una barra:
			echo "<a class='btn btn-secondary btn-block btn-sm' href=\"../vista/contenido.php?en=".($posActual.$nombreCarpeta)."/\"/>
			Ir a carpeta<i class='fas fa-folder-open mx-1'></i></a>";
			echo "</div>\n</div>\n <!-- Fin tarjeta carpeta -->";
		}
	} // -- Termina de listar carpetas --
	
	// Obtiene los nombres de archivos en la ubicación actual:
	$listadoArchivos = $control->listarArchivos($posActual);
	// Recorre todo el listado de archivos:
	if (empty($listadoArchivos) && empty($listadoCarpetas)) {
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
		echo "<div class='btn-group btn-block' role='group'>
			<a class='btn btn-secondary btn-block btn-sm' href=\"".($posActual.$nombreArchivo)."\" >Abrir <i class='fas fa-eye mx-1'></i></a>
			<a class='btn btn-secondary btn-sm' title=Compartir href='../vista/compartirarchivo.php?nombre=$nombreArchivo&ruta=$posActual' >
			<i class='fas fa-share'></i></a>
			<a class='btn btn-secondary btn-sm' title=Modificar href='../vista/amarchivo.php?nombre=$nombreArchivo&ruta=$posActual&modificar=1' >
			<i class='fas fa-pen'></i></a>
			<a class='btn btn-secondary btn-sm' title=Eliminar href='../vista/eliminararchivo.php?nombre=$nombreArchivo&ruta=$posActual' >
			<i class='fas fa-trash'></i></a>
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
<a href="../vista/index.php" class="btn btn-outline-dark"><i class='fas fa-home mx-2'></i>Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../vista/estructura/pie.php"); ?>
