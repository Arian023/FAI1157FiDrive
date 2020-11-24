<?php $Titulo = "Inicio - FiDrive"; 
include_once("../../vista/estructura/cabecera.php")?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->
<div class="jumbotron jumbotron-fluid p-2 m-auto"> <!-- Comienzo div consigna -->
	<h1 class="display-4">FiDrive - Bienvenido al sitio</h1>
	<hr class="my-2">
	<p class="lead">FiDrive es una aplicación Web que nos permite subir a la nube archivos, ya sea luego necesitamos compartirlos o simplemente para guardarlos.<br>
	Con FiDrive podrás compartir todos los archivos que desees de manera sencilla. Podrá determinar cuánto tiempo deberá estar disponible la URL y cuántas veces se podrá acceder a él; para limitar la cantidad de descargas. 
	</p>
	<hr class="my-2">
	<h3 class="lead"><b>Funcionalidades y detalles:</b></h3>
	<ul>
		<li>Listado de archivos con funciones de compartir/modificar/eliminar</li>
		<li>Íconos mostrados según ingresados por el usuario <small>(en entrega 3 por extensión de archivo)</small></li>
		<li>Crear carpeta y navegar por subcarpetas <small>(en entrega 3)</small></li>
		<li>Animación al pasar cursor por cada caja de icono</li>
		<li>Botón de "Volver arriba" al navegar por páginas largas <small>(aparece flotando en la esquina inferior derecha)</small></li>
		<li>Buscador de palabras en el mismo sitio <small>(integrado a la barra de navegación)</small></li>
		<li>Plugins de formularios para generar texto enriquecido, validar fortaleza de contraseña y confirmar salir sin enviar</li>
		<li>Sitio web mayormente responsive y visualmente organizado</li>
		<li>Navegación en barra superior y mapa del sitio a continuación <small>(Demás opciones accesibles directamente a modo ilustrativo)</small></li>
	</ul>
</div> <!-- Fin div consigna -->

<div class="alert alert-warning alert-dismissible fade show my-2" role='alert'>
	Publicado en: <a href="https://github.com/Arian023/FAI1157FiDrive/">https://github.com/Arian023/FAI1157FiDrive</a><br><br>
	<b>Pendientes 23/11:</b> <br>
	<ul>
		<li>Gestionar link compartido y dejar de compartir</li>
		<li>Integrar login del usuario</li>
	</ul>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	<span aria-hidden="true">&times;</span></button>
</div>

<div class="container p-2" id=mapa> <!-- Comienzo div mapa -->
	<br>
	<h3 class="text-md-center"><i class="fas fa-layer-group mx-2"></i> Mapa del sitio:</h3><br>
	<ul class="list-unstyled">
	<div class="row">
		<div class="col-md-6">
			<li><a href="contenido.php" class="btn btn-block btn-lg btn-outline-info">Ver listado de archivos</a></li><br>
			<li><a href="amarchivo.php" class="btn btn-block btn-lg btn-outline-info">Nuevo archivo</a></li><br>
			<li><a href="compartidos.php" class="btn btn-block btn-lg btn-outline-info">Mostrar compartidos</a></li><br>
		</div>
		<div class="col-md-6">
			<li><a href="compartirarchivo.php" class="btn btn-block btn-lg btn-outline-dark">Compartir archivo <small>(sin seleccionar)</small></a></li><br>
			<li><a href="eliminararchivocompartido.php" class="btn btn-block btn-lg btn-outline-dark">Dejar de compartir archivo <small>(sin seleccionar)</small></a></li><br>
			<li><a href="eliminararchivo.php" class="btn btn-block btn-lg btn-outline-dark">Eliminar archivo <small>(sin seleccionar)</small></a></li><br>
		</div>
	</div>
	</ul>
</div> <!-- Fin div mapa -->

</div> <!-- Fin div cuerpo -->
<?php include_once("../../vista/estructura/pie.php"); ?>
