<?php $Titulo = "Alta o modificación - FiDrive"; 
include_once("../vista/estructura/cabecera.php")?>
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
</div> <!-- Fin div consigna -->

<hr>

<div class="container p-2" id=formulario> <!-- Comienzo div formulario -->
	<h4 class="text-md-center"><i class="fas fa-upload mx-2"></i>Ingrese los siguientes datos para cargar o modificar el archivo:</h4>
	<form name=amarchivo id=amarchivo method=post action="" enctype="multipart/form-data" novalidate>
		<div class="form-row">
			<div class="form-group col-md-6">
				<label for="nombre" class="font-weight-bold">Nombre del archivo</label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
					<input type=text class="form-control" name=nombre id=nombre value="1234.png">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for=archivoIng class="font-weight-bold">Seleccione un archivo</label>
				<input type=file class="form-control" name=archivoIng id=archivoIng disabled>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-12">
				<label for="descripcion" class="font-weight-bold">Escriba una descripción</label>
				<textarea class="form-control" name=descripcion id=descripcion rows=2>Esta es una descripción genérica, si lo necesita la puede cambiar.</textarea>
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
			<div class="form-group col-md-6">
				<label for="clave" class="font-weight-bold">Clave del archivo</label>
					<div class=input-group>
					<div class="input-group-prepend">
					<span class="input-group-text"><i class="fas fa-key"></i></span>
					</div>
					<input type=password class="form-control" name=clave id=clave>
				</div>
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
						<i class="fas fa-file-image mx-2"></i>
						<label for=atp class="form-check-label">Imagen</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=zip type=radio value=zip>
						<i class="fas fa-file-archive mx-2"></i>
						<label for=m7 class="form-check-label">Comprimido</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=doc type=radio value=doc>
						<i class="fas fa-file-word mx-2"></i>
						<label for=m18 class="form-check-label">Documento de texto</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=pdf type=radio value=pdf>
						<i class="fas fa-file-pdf mx-2"></i>
						<label for=m18 class="form-check-label">Libro PDF</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" name=icono id=xls type=radio value=xls>
						<i class="fas fa-file-excel mx-2"></i>
						<label for=m18 class="form-check-label">Planilla de cálculo</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-row">
			<div class="form-group col-md-6">
			</div>
			<div class="form-group col-md-6 text-right">
				<input name=enviar id=enviar type=submit value="Enviar archivo" class="btn btn-primary">
			</div>
		</div>
	</form> <!-- Fin formulario amarchivo -->
</div> <!-- Fin div formulario -->

<hr>
<a href="../vista/index.php" class="btn btn-outline-dark">Volver al inicio</a>
</div> <!-- Fin div cuerpo -->
<?php include_once("../vista/estructura/pie.php"); ?>
