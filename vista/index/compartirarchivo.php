<?php $Titulo = "Compartir archivo - FiDrive";
include_once("../../vista/estructura/cabecera.php");
// Llama a los ABM de archivos cargados y de usuario:
$AbmArchivoCargado = new abmarchivocargado();
$AbmUsuario = new abmusuario();
// Si recibe un ID de archivo por parámetro (opción modificar), busca sus atributos para completar formulario:
if (isset($_GET['id']) ) 
	$archivoSelec = $AbmArchivoCargado->buscar( array('idarchivocargado'=>$_GET['id']) );
?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">Compartir archivo</h1>
	<hr class=my-4>
	<p class="lead">Creamos el archivo compartirarchivo.php para compartir un archivos. Este archivo debe incluir los archivos: cabecera.php, pie.php y menu.php
	</p>
	<ul class="lead">
		<li>Etiqueta que muestra nombre del archivo compartido (Colocar valor por defecto 1234.png)</li>
		<li>Ingresar cantidad de días que se comparte (Si queda vació quiere decir que no expira)</li>
		<li>Ingresar cantidad de descargar posibles (Si queda vació quiere decir que no hay limites) </li>
		<li>Usuario que lo carga (Seleccionar desde un Combo, los usuarios posibles son: admin, visitante, y usted)</li>
		<li>CheckBox para seleccionar que se debe proteger con contraseña</li>
		<li>Un Campo para cargar la contraseña en caso que se seleccione esta opción. </li>
		<li>Etiqueta para mostrar el link de compartir generado</li>
		<li>Botón que permite generar un hash que sera el acceso para compartir el archivo</li>
	</ul>
	<p class="lead">
	Controles para compartirarchivo.php
	</p>
	<ul class="lead">
		<li>El usuario debe ser Seleccionado</li>
		<li>Si se selecciona proteger con contraseña, se debe ingresar una contraseña. Se debe mostrar si la contraseña es:
		<ul>
			<li>Débil: son solo números o letras y longitud es menor a 6</li>
			<li>Normal: contiene números y letras y una longitud mayor a 6</li>
			<li>Fuerte: tiene números, letras y símbolos y una longitud mayor a 6</li>
		</ul>
		<li>El link de descargas debe ser generado con un hash que contenga internamente un numero, la cantidad de descargas y la cantidad de  días. Si estos alguno de estos 2 últimos campos son vacíos usar el valor 9007199254740991</li>
		<li>El usuario debe ser Seleccionado</li>
	</ul>

</div> <!-- Fin div consigna -->

<hr class=my-4>

<div class="container p-2" id=formulario> <!-- Comienzo div formulario -->
<?php // Si no inició sesión, muestra solo aviso
	if ( null == $sesion->getuslogin() ) {
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>
		Esta sección del sitio es para usuarios registrados. Por favor utiliza el botón [Iniciar sesión] del menú superior para ingresar.</div>";
	} else { // Muestra el resto del contenido normalmente:	
?>
	<h4 class="text-md-center"><i class="fas fa-share-alt-square mx-2"></i>Opciones para compartir:</h4>
	<form class="validarClave" name=compartir id=compartir method=post action="../action/compartir.php" novalidate>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="nombre" class="font-weight-bold">Título del archivo a compartir</label>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fas fa-tag"></i></span>
					</div>
					<input type=text class=form-control name=acnombre id=titulo readonly 
					value=<?php 
							if ( isset($archivoSelec[0]) ) 
								echo '"'.$archivoSelec[0]->getacnombre().'"';
							else
								echo "1234.png";
						?> >
					<!-- Hace un echo del valor de ID y ruta que recibe desde contenido.php
						 Ruta es usado por validaciones.js para generar hash -->
					<input type=hidden name=ruta id=ruta 
						value=<?php if ( isset($archivoSelec[0]) ) echo '"'.$archivoSelec[0]->getaclinkacceso().'"'; ?> >
					<input type=hidden name=idarchivocargado id=idarchivocargado 
						value=<?php if (isset($_GET['id']) ) echo '"'.$_GET['id'].'"'?> >
				</div>
			</div>
			<!-- Se selecciona usuario de la sesión actual -->
			<input type=hidden class='form-control' name=usuario id=usuario 
					value='<?=$sesion->getidusuario()?>'>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="cantDias" class="font-weight-bold">Cantidad de días compartido</label>
				<input type=number class=form-control name=cantDias id=cantDias>
				<small>(Dejar vacío indica que no expira)</small>
			</div>
			<div class="form-group col-md-6">
				<label for="cantDescargas" class="font-weight-bold">Cantidad de descargas posibles</label>
				<input type=number class=form-control name=cantDescargas id=cantDescargas>
				<small>(Dejar vacío indica que no hay límite)</small>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6 form-check form-check-inline">
				<input class="form-check-input" name=proteger id=proteger type=checkbox value="si" checked>
				<label for="proteger" class="form-check-label font-weight-bold">Proteger con contraseña</label>
			</div>
			<div class="form-group col-md-6" id=campoClave> <!-- Se muestra u oculta al marcar proteger con clave -->
				<label for="clave" class="font-weight-bold">Indique contraseña</label>
				<div class="input-group">
					<input type=password class="validarClave__input form-control" name=acprotegidoclave id=clave aria-describedby="passwordHelp">
					<div class="input-group-append">
						<button class="validarClave__visibility btn btn-outline-secondary" type="button"><span class="validarClave__visibility-icon" data-visible="hidden"><i class="fas fa-eye-slash"></i></span><span class="validarClave__visibility-icon js-hidden" data-visible="visible"><i class="fas fa-eye"></i></span></button>
					</div>
				</div>
				<small class="validarClave__error text-danger js-hidden">¡Este símbolo no está permitido!</small>
				<small class="form-text text-muted mt-2" id="passwordHelp">(Se recomienda usar 6 caracteres o más, letras, números y símbolos)</small>
				<div class="validarClave__bar-block progress mb-4"> <!-- Barra de nivel -->
					<div class="validarClave__bar progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
				<!-- Carga script para validar fuerza de contraseña -->
				<!-- Nota: Cargarlo en pie.php da error en consola si se ejecuta en otros sitios que no lo usan -->
				<script src="../js/validarClave.js"></script>
				<script type="text/javascript">
					// Deshabilitar o habilitar campo clave - Fuente: https://stackoverflow.com/a/15140254
					document.getElementById('proteger').onchange = function() {
						document.getElementById('clave').disabled = !this.checked;
						// Si está desmarcado, se oculta campo y no se valida
						if (document.getElementById('clave').disabled) {
							document.getElementById('campoClave').style.display = "none";
						} else {
							document.getElementById('campoClave').style.display = "block";
						}
					};
				</script>
				<noscript>
					<p><i>El navegador no tiene habilitado javascript. Debe habilitarlo para validar su nivel de clave.</i></p>
				</noscript>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<input type=hidden name=enlace id=enlace> <!--- Se genera enlace por JS --->
			</div>
			<div class="form-group col-md-6">
				<label for="enlace" class="font-weight-bold"></label>
				<!-- PROBAR USAR BUTTON O INPUT PARA VALIDAR CLAVE -->
				<button type=submit id=enviar onclick="generarLink()" class="btn btn-info validarClave__submit">Generar enlace</button>
			</div>
		</div>
	</form> <!-- Fin formulario amarchivo -->
<?php
	} // Fin else de sesión activa
?>
</div> <!-- Fin div formulario -->

<hr class=my-4>
<div class=row>
	<div class=col><a href="../index/contenido.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-folder mx-2'></i>Volver al Listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); ?>