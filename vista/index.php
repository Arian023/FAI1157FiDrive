<?php $Titulo = "Inicio - FiDrive"; 
include_once("../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">FiDrive - Bienvenido al sitio</h1>
	<hr class="my-2">
	<p class="lead">FiDrive es una aplicación Web que nos permite subir a la nube archivos, ya sea luego necesitamos compartirlos o simplemente para guardarlos.<br>
	Con FiDrive podrás compartir todos los archivos que desees de manera sencilla. Podrá determinar cuánto tiempo deberá estar disponible la URL y cuántas veces se podrá acceder a él; para limitar la cantidad de descargas. 
	</p>
</div> <!-- Fin div consigna -->

<div class="alert alert-info alert-dismissible fade show" role='alert'>
		Segunda entrega (ID commit d5c7912f16ffaa1d45a6ac8c10c37dcd8225a8e1): <a href=https://github.com/Arian023/FAI1157FiDrive/commit/d5c7912f16ffaa1d45a6ac8c10c37dcd8225a8e1>https://github.com/Arian023/FAI1157FiDrive</a>
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>

<div class="container p-2" id=mapa> <!-- Comienzo div mapa -->
	<br>
	<h3 class="text-md-center"><i class="fas fa-layer-group mx-2"></i> Mapa del sitio:</h3><br>
	<ul class="list-unstyled">
	<div class="row">
		<div class="col-md-6">
			<li><a href="amarchivo.php" class="btn btn-block btn-lg btn-outline-info">Alta o modificación</a></li><br>
			<li><a href="compartirarchivo.php" class="btn btn-block btn-lg btn-outline-success">Compartir archivo</a></li><br>
			<li><a href="eliminararchivocompartido.php" class="btn btn-block btn-lg btn-outline-warning">Dejar de compartir archivo</a></li><br>
		</div>
		<div class="col-md-6">
			<li><a href="contenido.php" class="btn btn-block btn-lg btn-outline-dark">Ver contenido carpeta</a></li><br>
			<li><a href="compartidos.php" class="btn btn-block btn-lg btn-outline-dark">Mostrar compartidos</a></li><br>
			<li><a href="eliminararchivo.php" class="btn btn-block btn-lg btn-outline-danger">Eliminar archivo</a></li><br>
		</div>
	</div>
	</ul>
</div> <!-- Fin div mapa -->

</div> <!-- Fin div cuerpo -->
<?php include_once("../vista/estructura/pie.php"); ?>
