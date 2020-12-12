<?php $Titulo = "Actualizar usuario - FiDrive"; 
include_once("../estructura/cabecera.php");
// Lee los datosIng recibidos:
$datosIng = data_submitted();
// Llama al objeto con métodos para manejar ABM de usuarios:
$AbmUsuario = new abmusuario();
// Si existe el usuario, lee sus datos:
$usuario=null;
if (isset($datosIng['idusuario'])){
    $listaUsuario = $AbmUsuario->buscar($datosIng);
    if (count($listaUsuario)==1){
        $usuario = $listaUsuario[0];
    }
}
?>
<div class="card p-2 shadow" id=cuerpo> <!-- Comienzo div cuerpo-->
    
<div class="container p-2" id=formulario> <!-- Comienzo div formulario -->
<?php // Si no inició sesión, muestra solo aviso
	if ( null == $sesion->getuslogin() ) {
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>
		Esta sección del sitio es para usuarios registrados. Por favor utiliza el botón [Iniciar sesión] del menú superior para ingresar.</div>";
	} else if ($datosIng['idusuario'] != $sesion->getidusuario() && !$sesion->esadmin()) {
		// Se verifica que sea el usuario activo o un administrador para modificar los datos
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-exclamation-circle mx-2'></i>
		No puedes modificar otro usuario que no sea el propio. Caso contrario, contacta al administrador.</div>";
	} else { // Sino, muestra el resto del contenido normalmente:	
?>
	<h4 class="text-center mb-4"><i class="fas fa-user-edit mx-2"></i>Actualizar datos de usuario:</h4>
	<?php 
	// Si existe el usuario, muestra formulario y rellena los campos:
	if (null != $usuario){?>
	<form name=registro id=registro method=post action="../action/actualizarlogin.php" class="validarClave" autocomplete=off novalidate onsubmit="claveSegura()">
	<input id=idusuario name=idusuario type=hidden value="<?=$datosIng['idusuario']?>">
	<input id=usactivo name=usactivo type=hidden value="<?=$usuario->getusactivo()?>">
	<div class=form-row>
			<div class="form-group col-md-6">
				<label for=usnombre class=font-weight-bold>Nombre</label>
				<div class=input-group>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                    </div>
					<input type=text class=form-control name=usnombre id=usnombre placeholder="Nombre" value="<?=$usuario->getusnombre()?>">
				</div>
			</div>
			<div class="form-group col-md-6">
				<label for=usapellido class=font-weight-bold>Apellido</label>
				<div class=input-group>
                    <div class=input-group-prepend>
                        <span class=input-group-text><i class="fas fa-user-tag"></i></span>
                    </div>
					<input type=text class=form-control name=usapellido id=usapellido placeholder="Apellido" value="<?=$usuario->getusapellido()?>">
				</div>
			</div>
		</div>
		<div class=form-row>
			<div class="form-group col-md-6">
				<label for=uslogin class=font-weight-bold>Nombre de usuario</label>
				<div class=input-group>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                    </div>
					<input type=text class=form-control name=uslogin id=uslogin placeholder="Usuario" value="<?=$usuario->getuslogin()?>">
				</div>
			</div>
		</div>
		<div class=form-row>
			<div class="form-group col-md-6">
				<label for=usclave class=font-weight-bold>Contraseña de usuario</label>
				<div class="input-group">
					<div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
					<input type=password class="validarClave__input form-control" name=usclave id=usclave>
                        <!-- onclick="document.getElementById('usclave').value=md5(document.getElementById('usclave').value)" -->
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
				<noscript>
					<p><i>El navegador no tiene habilitado javascript. Debe habilitarlo para validar su nivel de clave.</i></p>
				</noscript>
			</div>
			<div class="form-group col-md-6">
				<label for=usclave2 class=font-weight-bold>Confirmar contraseña</label>
				<div class=input-group>
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
					<input type=password class=form-control name=confirmarclave id=confirmarclave>
				</div>
			</div>
		</div>
		<input type="submit" value="Actualizar datos" class="btn btn-info">
            <!-- onclick="document.getElementById('usclave').value=md5(document.getElementById('usclave').value)" -->
	</form>
	<?php 	} else {
			echo "<div class='alert alert-danger' role='alert'>
				<i class='fas fa-question-circle mx-2'></i>No se encontró el usuario a modificar.
			</div>";
		} // Fin if else formulario 
	} // Fin else de sesión activa
	?>
</div> <!-- Fin div formulario-->
<hr class=my-4>
<div class=row>
	<div class=col><a href="../index/listausuarios.php" class="btn btn-outline-dark btn-block">
		<i class="fas fa-arrow-left mx-2"></i>Volver al listado</a></div>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../estructura/pie.php");?>