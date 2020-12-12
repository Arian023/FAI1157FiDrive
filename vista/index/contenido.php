<?php $Titulo = "Ver contenido cargado - FiDrive"; 
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
	<h1 class="display-4">Ver contenido almacenado</h1>
	<hr class=my-4>
	<p class="lead">Crear un archivo, en la carpeta vista, llamado contenido.php que muestre recursivamente 
	los archivos contenidos en la carpeta llamada archivo. Este archivo debe incluir los archivos: cabecera.php, pie.php y menu.php<br>
	Agregar los siguientes botones:<br>
	</p>
	<ul class="lead">
		<li>Que permita generar una nueva carpeta dentro de la carpeta que actualmente este seleccionada.</li>
		<li>Que permita cargar un archivo dentro de la carpeta actualmente este seleccionada. Este botón, debe llamar al formulario amarchivo.php creado en la Entrega 1.</li>
		<li>Que permita compartir un archivo actualmente este seleccionado. Este botón, debe llamar al formulario compartirarchivo.php creado en la Entrega 1. </li>
		<li>Que permita eliminar un archivo actualmente este seleccionado. Este botón, debe llamar al formulario eliminararchivo.php creado en la Entrega 1. </li>
	</ul>
</div> <!-- Fin div consigna -->

<hr class="my-3">

<div class="container p-2" id=contenido> <!-- Comienzo div contenido -->
<?php // Si no inició sesión, muestra solo aviso
	if ( null == $sesion->getuslogin() ) {
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>
		Esta sección del sitio es para usuarios registrados. Por favor utiliza el botón [Iniciar sesión] del menú superior para ingresar.</div>";
	} else { // Muestra el resto del contenido normalmente:	
?>
	<h4 class="text-md-center"><i class='fas fa-folder mx-2'></i>Listado de archivos cargados:</h4>
	<div class="row justify-content-start">
		<div class="col-md-10 justify-content-start">
		<a href='../index/amarchivo.php?modificar=0' class="btn btn-info"><i class='fas fa-file-upload mx-2'></i>Cargar archivo</a>
		<a href='../index/compartidos.php' class="btn btn-info"><i class='fas fa-share-alt-square mx-2'></i>Ver compartidos</a>
		</div>
		<div class="col-md-2 form-inline justify-content-end">
		
		</div>
	</div> <!-- Fin menú navegación -->
	<hr class=my-4>

	<div class="container-md row"> <!-- Comienzo div archivos mostrados -->
	<?php // Procede a buscar todos los archivos cargados del usuario activo:
	$usuarioActual['idusuario'] = $sesion->getidusuario();
	$listaArchivos = $AbmArchivoCargado->buscar($usuarioActual);
	// echo "<br><div style='white-space: pre-line'>"; print_r($listaArchivos); echo "</div><br>";
	// Recorre todo el listado de archivos:
	if (empty($listaArchivos)) {
	echo "<div class='col alert alert-secondary text-center' role='alert'>
	<i class='fas fa-question-circle mx-2'></i>No hay archivos almacenados</div>";
	} else {
	// Como el modal no funcionó, se muestran iconos apilados uno abajo del otro, donde la segunda columna muestra algunos detalles del archivo
	echo "<div class=row> <!-- Comienzo lista de archivos -->\n";
	foreach ($listaArchivos as $archivo) {
	if($AbmEstadoArchivo->estaHabilitado($archivo->getidarchivocargado())) {
	// Muestra cada archivo en una tarjeta animada cajaIcono:
	echo "<div class='card col-md-12 col-sm-12 m-1 border-info cajaIcono' title='Archivo: ".$archivo->getacnombre()."'>
	
	<div class='card-body row p-1'>
	<div class='col-md-3 col-sm-4'> <!-- Div columna icono y botones -->";
		// Por CSS se corta el texto largo con clase .elipsis
		echo "<h1 class='text-center'><i class='".$archivo->getacicono()." mt-3'></i></h1>
		<h5 class='card-title text-center elipsis'>".$archivo->getacnombre()."</h5>\n";
		// Botonera de opciones para cada archivo:
		echo "<a class='btn btn-info btn-block btn-sm' href='".$archivo->getaclinkacceso()."' target=_blank>
			Abrir <i class='fas fa-external-link-alt mx-1'></i></a>
		<div class='btn-group btn-block' role='group'>
			<a class='btn btn-secondary btn-sm' title=Compartir href='../index/compartirarchivo.php?id=".$archivo->getidarchivocargado()."'>
				<i class='fas fa-share'></i></a>
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
	<dl class=row><dd class=col>
		<b>Descripción:</b> ".$archivo->getacdescripcion()."</a>
	</dd></dl>
	</div> <!-- Fin columna detalles -->
	</div>
	</div> <!-- Fin tarjeta archivo -->\n";
		
	} // Fin if estáHabilitado
	} // Fin foreach
	echo "</div> <!-- Fin lista apilada de archivos -->\n";
	} // -- Termina de listar archivos --
	?>
	</div> <!-- Fin div archivos mostrados -->
</div> <!-- Fin div contenido -->
<?php
	} // Fin else de sesión activa
?>
<hr class=my-4>
<a href="../index/index.php" class="btn btn-outline-dark"><i class='fas fa-home mx-2'></i>Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); 

/* MODAL NO FUNCIONA - Botón de abrir archivo por modal para ver detalles:
		echo "<!-- Botón para activar modal #'".$archivo->getidarchivocargado()."' de ".$archivo->getacnombre()." -->
		<div class='btn-group btn-block' role='group'>
			<button type=button class='btn btn-primary col-md-4' data-toggle=modal data-target='#".$archivo->getidarchivocargado()."'>
			<i class='fas fa-eye'></i></button>";
		// Modal que permanece oculto hasta cliquear Abrir:
		echo "<div class='modal fade modal-lg' id='".$archivo->getidarchivocargado()."' tabindex='-1' aria-hidden=true>
		<div class=modal-dialog>
			<div class=modal-content>
				<div class=modal-header>
					<h5 class=modal-title><i class='".$archivo->getacicono()." mx-2'></i> Detalles: ".$archivo->getacnombre()."</h5>
					<button type=button class=close data-dismiss=modal>
					<span aria-hidden=true>&times;</span>
					</button>
				</div> <!-- Fin div header modal -->
				<div class=modal-body>
					<div class=row>
						<div class=col>
							Cargado por el usuario ".$archivo->getobjusuario()->getusnombre()." ".$archivo->getobjusuario()->getusapellido()." (ID ".$archivo->getobjusuario()->getidusuario().").
						</div>
						<div class=col>
							Protegido con clave: ";
					echo empty($archivo->getacprotegidoclave()) ? "NO" : "SI";
					echo "</div>
					</div>
					<div class=row>
						Enlace: <a href='".$archivo->getaclinkacceso()."'>".$archivo->getaclinkacceso()."</a>
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
				<div class=modal-footer>";
					<a class='btn btn-secondary' title=Compartir href='../index/compartirarchivo.php?id=".$archivo->getidarchivocargado()."'>
					<i class='fas fa-share mx-2'></i>Compartir</a>
					<a class='btn btn-secondary' title=Modificar href='../index/amarchivo.php?id=".$archivo->getidarchivocargado()."&mod=1'>
					<i class='fas fa-pen mx-2'></i>Modificar</a>
					<a class='btn btn-secondary' title=Eliminar href='../index/eliminararchivo.php?id=".$archivo->getidarchivocargado()."'>
					<i class='fas fa-trash mx-2'></i>Eliminar</a>
					<button type=button class='btn btn-outline-dark' data-dismiss=modal>Cerrar</button>
				</div> <!-- Fin div pie modal -->
			</div>
		</div>
		</div> <!-- Fin div modal #".$archivo->getidarchivocargado()." de ".$archivo->getacnombre()." -->";*/
?>