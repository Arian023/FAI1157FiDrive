<?php $Titulo = "Dejar de compartir archivo - FiDrive"; 
include_once("../../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">Dejar de compartir archivo</h1>
	<hr class="my-2">
    <p class="lead">Creamos el archivo eliminararchivocompartido.php para eliminar las opciones de compartir un Archivo. Este archivo debe incluir los archivos: cabedera.php, pie.php y menu.php
	</p>
	<ul class="lead">
		<li>Etiqueta que muestra nombre del archivo compartido (Colocar valor por defecto 1234.png)</li>
		<li>Etiqueta que muestra la cantidad de veces que se compartió</li>
		<li>Motivo de ya no compartir el Archivo</li>
		<li>Usuario que lo carga (Seleccionar desde un Combo, los usuarios posibles son: admin, visitante, y usted)</li>
	</ul>
</div> <!-- Fin div consigna -->

<hr>

<div class="container p-2" id=formulario> <!-- Comienzo div formulario -->
	<h4 class="text-md-center"><i class="fas fa-lock mx-2"></i>Eliminar compartido:</h4>
	<form name=nocompartir id=nocompartir method=post action="../action/nocompartir.php" novalidate>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="nombre" class="font-weight-bold">Nombre del compartido</label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
					</div>
					<input type=text class=form-control name=nombre id=nombre readonly 
					<?php if (isset($_GET['nombre']) ) {
						echo 'value="'.$_GET['nombre'].'"';
					} else { 
						echo 'value="1234.png"';
					} ?> >
				</div>
				<input type=hidden name=ruta id=ruta 
					<?php if (isset($_GET['ruta']) ) echo 'value="'.$_GET['ruta'].'"'?> >
			</div>
			<div class="form-group col-md-6">
				<label for=cant class="font-weight-bold" readonly>Cantidad compartidos</label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                    </div>
					<input type=number class="form-control" name=cant id=cant readonly value=999>
                </div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="usuario" class="font-weight-bold">Usuario</label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
					<select class="form-control" name=usuario id=usuario>
						<option value=Ninguno disabled selected value>Seleccione una opción...</option>
						<option value=admin>Administrador</option>
						<option value=visitante>Visitante</option>
						<option value=usted>Usted</option>
					</select>
                </div>
			</div>
			<div class="form-group col-md-12">
				<label for="descripcion" class="font-weight-bold">Motivo por dejar de compartir:</label>
				<textarea class="form-control" name=descripcion id=descripcion rows=2>Esta es una descripción genérica, si lo necesita la puede cambiar.</textarea>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
			</div>
			<div class="form-group col-md-6 text-right">
				<input name=enviar id=enviar type=submit value="Dejar de compartir" class="btn btn-warning border-dark">
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
