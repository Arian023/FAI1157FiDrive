<?php $Titulo = "Ver contenido - FiDrive"; 
include_once("../vista/estructura/cabecera.php");
// Llama al objeto con métodos para manejar carga de archivos:
$control = new control_archivos(); // >>>> USAR ACCESO A BASE DE DATOS <<<<

// Llama al objeto con métodos para manejar ABM de archivos cargados:
$AbmArchivoCargado = new abmarchivocargado();
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
	<h4 class="text-md-center"><i class='fas fa-folder mx-2'></i>Listado de archivos:</h4>
	<div class="row justify-content-start">
		<div class="col-md-4 justify-content-start">
		<a href='../vista/amarchivo.php?&modificar=0' class="btn btn-info"><i class='fas fa-file-upload mx-2'></i>Cargar archivo</a>
		</div>
		<div class="col-md-8 form-inline justify-content-end">
		
		</div>
	</div> <!-- Fin menú navegación -->
	<hr>

	<div class="container-md row"> <!-- Comienzo div archivos mostrados -->
	<?php // Procede a buscar todos los archivos cargados:
	$listaArchivos = $AbmArchivoCargado->buscar(null);
	// Recorre todo el listado de archivos:
	if (empty($listaArchivos)) {
		echo "<div class='col alert alert-secondary text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>No hay archivos almacenados</div>";
	} else {
	foreach ($listaArchivos as $archivo) {
		// Muestra cada archivo en una tarjeta animada cajaIcono:
		echo "<div class='card col-md-4 col-sm-5 m-1 border-info cajaIcono' title='Archivo: ".$archivo->getacnombre()."'>";
		echo "<h1 class='text-center'><i class='".$archivo->getacicono()." m-3'></i></h1>";
		echo "<div class='card-body p-1'>";
		// Por CSS se corta el texto largo con clase .elipsis
		echo "<h5 class='card-title text-center elipsis'>".$archivo->getacnombre()."</h5>";
		/* Se reemplaza botón de abrir archivo por modal para ver detalles:
		echo "<a class='btn btn-secondary btn-block btn-sm' href='\"'".$archivo->getaclinkacceso()."'\"' >Abrir <i class='fas fa-eye mx-1'></i></a>"; */
		echo "<!-- Botón para activar modal #".$archivo->getidarchivocargado()." de ".$archivo->getacnombre()." -->
			<div class='btn-group btn-block' role='group'>
			<button type=button class='btn-lg btn-primary col-md-4' data-toggle=modal data-target=#".$archivo->getidarchivocargado().">
			<i class='fas fa-eye'></i>Ver detalles</button>
			<a class='btn btn-secondary btn-sm' title=Compartir href='../vista/compartirarchivo.php?id=".$archivo->getidarchivocargado()."'>
			<i class='fas fa-share'></i></a>
			<a class='btn btn-secondary btn-sm' title=Modificar href='../vista/amarchivo.php?id=".$archivo->getidarchivocargado()."&mod=1'>
			<i class='fas fa-pen'></i></a>
			<a class='btn btn-secondary btn-sm' title=Eliminar href='../vista/eliminararchivo.php?id=".$archivo->getidarchivocargado()."'>
			<i class='fas fa-trash'></i></a>
		</div>";
		// Tip: Hacer que el botón dirija a una página: onclick="window.location.href='https://w3docs.com';"
		echo "</div>\n</div> <!-- Fin tarjeta archivo -->";
		// Modal que permanece oculto hasta cliquear Abrir:
		echo "<div class='modal fade modal-lg' id=".$archivo->getidarchivocargado()." tabindex=-1>
		<div class=modal-dialog>
			<div class=modal-content>
			<div class=modal-header>
				<h5 class=modal-title><i class='".$archivo->getacicono()." mx-2'></i> Detalles: ".$archivo->getacnombre()."</h5>
				<button type=button class=close data-dismiss=modal>
				<span>&times;</span>
				</button>
			</div> <!-- Fin div header modal -->
			<div class=modal-body>
				<div class=row>
					<div class=col>
						Cargado por el usuario ID ".$archivo->getidusuario().".
					</div>
					<div class=col>
						Protegido con clave: ".$archivo->getacprotegidoclave().".
					</div>
				</div>
				<div class=row>
					Enlace: ".$archivo->getaclinkacceso()."
				</div>
				<div class=row>
					<div class=col>
						Cantidad descarga: ".$archivo->getaccantidaddescarga().".
					</div>
					<div class=col>
						Cantidad usada: ".$archivo->getaccantidadusada().".
					</div>
				</div>
				<div class=row>
					<div class=col>
						Fecha compartido: ".$archivo->getacfechainiciocompartir().".
					</div>
					<div class=col>
						Fecha expiración compartido: ".$archivo->getacefechafincompartir().".
					</div>
				</div>
			</div> <!-- Fin div body modal -->
			<div class=modal-footer>
				<a class='btn btn-secondary' title=Compartir href='../vista/compartirarchivo.php?id=".$archivo->getidarchivocargado()."'>
				<i class='fas fa-share mx-2'></i>Compartir</a>
				<a class='btn btn-secondary' title=Modificar href='../vista/amarchivo.php?id=".$archivo->getidarchivocargado()."&mod=1'>
				<i class='fas fa-pen mx-2'></i>Modificar</a>
				<a class='btn btn-secondary' title=Eliminar href='../vista/eliminararchivo.php?id=".$archivo->getidarchivocargado()."'>
				<i class='fas fa-trash mx-2'></i>Eliminar</a>
				<button type=button class='btn btn-outline-dark' data-dismiss=modal>Cerrar</button>
			</div> <!-- Fin div pie modal -->
			</div>
		</div>
		</div> <!-- Fin div modal #".$archivo->getidarchivocargado()." de ".$archivo->getacnombre()." -->";
		// IDEA: Usar un Modal para ver detalles de X archivo, donde se muestre el título, link para compartir (directo al archivo subido), fecha subida, tamaño y la descripción
	}
	} // -- Termina de listar archivos --
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->

<hr>
<a href="../vista/index.php" class="btn btn-outline-dark"><i class='fas fa-home mx-2'></i>Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../vista/estructura/pie.php"); ?>
