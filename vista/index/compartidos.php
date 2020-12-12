<?php $Titulo = "Ver archivos compartidos - FiDrive"; 
include_once("../../vista/estructura/cabecera.php");
// Llama al objeto con métodos para manejar carga de archivos:
$control = new control_archivos();
// Llama al objeto con métodos para manejar ABM de archivos cargados:
$AbmArchivoCargado = new abmarchivocargado();
// Llama al objeto con métodos para manejar ABM del estado de archivos cargados:
$AbmEstadoArchivo = new abmarchivocargadoestado();
?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">Ver archivos compartidos</h1>
	<hr class=my-4>
	<ul class="lead">
		<li>Crear un archivo, en la carpeta vista, llamado compartidos.php que muestre recursivamente 
			los archivos contenidos en la carpeta llamada archivo y que estén compartidos. Este archivo debe incluir los archivos: cabecera.php, pie.php y menu.php.</li>
		<li>Agregar al archivo compartidos.php un botón, que permita dejar de compartir un archivo actualmente compartido.
			Este botón, debe llamar al formulario eliminararchivocompartido.php creado en la Entrega 1.</li>
	</ul>
</div> <!-- Fin div consigna -->

<hr class=my-4>

<div class="container p-2" id=contenido> <!-- Comienzo div contenido -->
	<h4 class="text-md-center"><i class='fas fa-share-alt-square mx-2'></i>Listado de archivos compartidos:</h4>
	<div class="row justify-content-start">
		<div class="col-md-4 justify-content-start">
			<a href='../index/contenido.php' class="btn btn-info"><i class='fas fa-folder mx-2'></i>Ver cargados</a>
		</div>
		<div class="col-md-8 form-inline justify-content-end">
			<p><i>Se muestran todos los archivos que no hayan expirado ni hayan superado el límite de usos del link.</i></p>
		</div>
	</div> <!-- Fin menú navegación -->
	<hr class=my-4>

	<div class="container-md row"> <!-- Comienzo div archivos mostrados -->
	<?php  // Procede a buscar todos los archivos cargados:
	$listaArchivos = $AbmArchivoCargado->buscar(null);
	// Recorre todo el listado de archivos:
	if (empty($listaArchivos)) {
	echo "<div class='col alert alert-secondary text-center' role='alert'>
	<i class='fas fa-question-circle mx-2'></i>No hay archivos almacenados</div>";
	} else {
	// Como el modal no funcionó, se muestran iconos apilados uno abajo del otro, donde la segunda columna muestra algunos detalles del archivo
	echo "<div class=row> <!-- Comienzo lista apilada de archivos -->\n";
	foreach ($listaArchivos as $archivo) {
	if($AbmEstadoArchivo->estaHabilitado($archivo->getidarchivocargado()) && $archivo->estaCompartido()) {
	// Muestra cada archivo en una tarjeta animada cajaIcono:
	echo "<div class='card col-md-12 col-sm-12 m-1 border-info cajaIcono' title='Archivo: ".$archivo->getacnombre()."'>
	
	<div class='card-body row p-1'>
	<div class='col-md-3 col-sm-4'> <!-- Div columna icono y botones -->";
		echo "<h1 class='text-center'><i class='".$archivo->getacicono()." mt-3'></i></h1>
		<h5 class='card-title text-center elipsis'>".$archivo->getacnombre()."</h5>\n";
		echo "<a class='btn btn-info btn-block btn-sm' href='".$archivo->getaclinkacceso()."' target=_blank>
			Abrir <i class='fas fa-external-link-alt mx-1'></i></a>
		<div class='btn-group btn-block' role='group'>
			<a class='btn btn-secondary btn-sm' title='Dejar de compartir' href='../index/eliminararchivocompartido.php?id=".$archivo->getidarchivocargado()."'>
				<i class='fas fa-minus-circle'></i></a>
			<a class='btn btn-secondary btn-sm' title=Modificar href='../index/amarchivo.php?id=".$archivo->getidarchivocargado()."&mod=1'>
				<i class='fas fa-pen'></i></a>
			<a class='btn btn-secondary btn-sm' title=Eliminar href='../index/eliminararchivo.php?id=".$archivo->getidarchivocargado().
			"'>
				<i class='fas fa-trash'></i></a>
		</div> <!-- Fin botonera -->
	</div> <!-- Fin columna icono y botones -->

	<div class='col-md-9 col-sm-8'> <!-- Div columna detalles -->
	<dl class=row>
		<dd class=col>
			<b>Autor:</b> ".$archivo->getobjusuario()->getusnombre()." ".$archivo->getobjusuario()->getusapellido()
				." (ID ".$archivo->getobjusuario()->getidusuario().").
		</dd>
		<dd class=col>
			<b>Tiene clave:</b> ";
			echo empty($archivo->getacprotegidoclave()) ? "NO" : "SI";
		echo "</dd>
	</dl>
	<dl class=row>
		<dd class=col>
			<b>Límite de usos del link:</b> <br>";
			echo "0" == $archivo->getaccantidaddescarga() ?
				"<i>(Sin límite)</i>" : $archivo->getacfechainiciocompartir();
		echo "</dd>
		<dd class=col>
			<b>Cantidad usada:</b> ".$archivo->getaccantidadusada().".
		</dd>
	</dl>
	<dl class=row>
		<dd class=col>
			<b>Fecha compartido:</b> <br>";
			echo "0000-00-00 00:00:00" == $archivo->getacfechainiciocompartir() ? 
				"<i>(Sin compartir)</i>" : $archivo->getacfechainiciocompartir();
		echo "</dd>
		<dd class=col>
			<b>Fecha expiración compartido:</b> <br>";
			echo "0000-00-00 00:00:00" == $archivo->getacefechafincompartir() ? 
			"<i>(Sin compartir)</i>" : $archivo->getacefechafincompartir();
	echo "</dd>
	</dl>
	<dl class=row><dd class=col>
		<b>Descripción:</b> ".$archivo->getacdescripcion()."</a>
	</dd></dl>
	</div> <!-- Fin columna detalles -->
	</div>
	</div> <!-- Fin tarjeta archivo -->\n";
		
	} // Fin if estáHabilitado y estaCompartido
	} // Fin foreach
	echo "</div> <!-- Fin lista apilada de archivos -->\n";
	} // -- Termina de listar archivos --
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->

<hr class=my-4>
<a href="../index/index.php" class="btn btn-outline-dark"><i class='fas fa-home mx-2'></i>Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); 

/* Versión anterior sencilla (no cumple función), explorando carpetas:

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
*/
?>
