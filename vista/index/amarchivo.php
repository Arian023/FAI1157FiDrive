<?php $Titulo = "Alta o modificación - FiDrive"; 
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
	<h1 class="display-4">Alta o modificación</h1>
	<hr class="my-2">
    <p class="lead">Creamos el archivo amarchivo.php para alta o modificación de un Archivo. Este archivo debe incluir los archivos: cabecera.php, pie.php y menu.php
	</p>
	<ul class="lead">
		<li>Nombre del Archivo (Colocar valor por defecto 1234.png)</li>
		<li>Descripción del Archivo</li>
		<li>Usuario que lo carga (Seleccionar desde un Combo, los usuarios posibles son: admin, visitante, y usted)</li>
		<li>Seleccionar Icono que se va a utilizar (Imagen, Zip, Doc, PDF, XLS). Usar CheckBox.</li>
		<li>Clave del Archivo a modificar. (Este debe ser un campo Oculto.</li>
	</ul>
	<b class="lead">
	Controles para amarchivo.php:
	</p>
	<ul class="lead">
		<li>Nombre del Archivo no debe quedar vacío.</li>
		<li>La descripción del Archivo, es contenido enriquecido, buscar un editor para cargarlo
		<li>Agregar siempre la siguiente descripción por defecto: "Esta es una descripción genérica, si lo necesita la puede cambiar."</li>
		<li>El usuario debe ser Seleccionado</li>
		<li>El icono, debería ser sugerido teniendo en cuenta la extensión del archivo seleccionado. Todo esto usado JavaScript.</li>
		<li>Si el campo Clave es igual a cero, al submitir el formulario, se debe enviar el parámetro accion = Alta; caso contrario debe enviar en el parámetro accion = Modificar</li>
	</ul>
</div> <!-- Fin div consigna -->

<hr>

<div class="container p-2" id=formulario> <!-- Comienzo div formulario -->
	<h4 class="text-md-center"><i class="fas fa-upload mx-2"></i>Ingrese los siguientes datos para <?= empty($modificar) ? "cargar" : "modificar" ?> el archivo:</h4>
	<form name=amarchivo id=amarchivo method=post action="../action/carga.php" enctype="multipart/form-data" novalidate>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="titulo" class="font-weight-bold">Título del archivo</label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
					<input type=text class=form-control name=acnombre id=titulo 
						value= <?php 
							if ( isset($archivoSelec[0]) ) 
								echo "'".$archivoSelec[0]->getacnombre()."'";
							else
								echo "1234.png";
						?> >
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for=archivoIng class="font-weight-bold">Archivo seleccionado</label>
				<?php // Puedo mostrar un campo de texto ilustrativo sobre el archivo seleccionado, en lugar de botón de carga
				if ( isset($archivoSelec[0]) )  {
					echo "<input type=text class='form-control' name=archivoIng id=archivoIng 
						value='".$archivoSelec[0]->getaclinkacceso()."' readonly>";
				} else {
					echo "<input type=file class=form-control name=archivoIng id=archivoIng onchange=elegirIcono()>
						<!-- Corre método para marcar icono sugerido según extensión de archivo -->";
				} ?>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="descripcion" class="font-weight-bold">Escriba una descripción</label>
				<textarea class=form-control name=acdescripcion id=descripcion rows=2>
				<?php 
					if ( isset($archivoSelec[0]) ) 
						echo $archivoSelec[0]->getacdescripcion();
					else
						echo "Esta es una descripción genérica, si lo necesita la puede cambiar.";
				?>	
				</textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="usuario" class="font-weight-bold">Usuario</label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
					<select class=form-control name=usuario id=usuario>
						<option value=Ninguno disabled selected value>Seleccione una opción...</option>
						<?php // Lee los usuarios de la base de datos, y completa las opciones:
						$listaUsuario = $AbmUsuario->buscar(null);
						if(!empty($listaUsuario)){
							foreach ($listaUsuario as $clave=>$usuario) {
								echo '<option value='.$usuario->getidusuario().'>'
									.$usuario->getusnombre().'</option>';
							}
						}?>
					</select>
                </div>
			</div>
			<div class="form-group col-md-6">
				<!-- Hace un echo del valor de ID y mod que recibe desde contenido.php -->
				<input type=hidden class=form-control name=idarchivocargado id=idarchivocargado 
					<?php if (isset($_GET['id']) ) echo 'value="'.$_GET['id'].'"'?> >
				<input type=hidden class=form-control name=mod id=mod 
					<?php if (isset($_GET['mod']) ) echo 'value="'.$_GET['mod'].'"'?> >
				<script type="text/javascript">
					// Deshabilitar campo archivoIng cuando se recibe valor de modificar desde contenido.php
					if (document.getElementById('mod').value != 0) {
						document.getElementById('archivoIng').disabled = true;
					}
				</script>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<div class="flex-row-reverse">
					<label for="icono" class="col-form-label font-weight-bold">Ícono a utilizar</label>
				</div>
				<div class="flex-row-reverse">
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=img type=radio value=img>
						<label for=img class="form-check-label">
						<i class="fas fa-file-image mx-2"></i>Imagen</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=zip type=radio value=zip>
						<label for=zip class="form-check-label">
						<i class="fas fa-file-archive mx-2"></i>Comprimido</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=doc type=radio value=doc>
						<label for=doc class="form-check-label">
						<i class="fas fa-file-word mx-2"></i>Documento de texto</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=pdf type=radio value=pdf>
						<label for=pdf class="form-check-label">
						<i class="fas fa-file-pdf mx-2"></i>Libro PDF</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=xls type=radio value=xls>
						<label for=xls class="form-check-label">
						<i class="fas fa-file-excel mx-2"></i>Planilla de cálculo</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
			</div>
			<div class="form-group col-md-6 text-right">
				<input id=enviar type=submit value="Enviar archivo" class="btn btn-info">
			</div>
		</div>
	</form> <!-- Fin formulario amarchivo -->
</div> <!-- Fin div formulario -->

<hr>
<div class=row>
	<div class=col><a href="../index/contenido.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-folder mx-2'></i>Volver al Listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); ?>
