<?php $Titulo = "Actualizar rol - FiDrive"; 
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
	} else if (!$sesion->esadmin()) {
		// Se verifica que sea el usuario activo o un administrador para modificar los datos
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-exclamation-circle mx-2'></i>
		Solamente usuarios autorizados pueden modificar roles. Caso contrario, contacta al administrador.</div>";
	} else { // Sino, muestra el resto del contenido normalmente:	
?>
	<h4 class="text-center mb-4"><i class="fas fa-user-tag mx-2"></i>Actualizar rol del usuario:</h4>
	<?php 
	// Si existe el usuario, muestra formulario y rellena los campos:
	if (null != $usuario){?>
	<form name=actualizarrol id=actualizarrol method=post action="../action/rolasignado.php" class="validarClave" autocomplete=off novalidate onsubmit="claveSegura()">
	<input id=idusuario name=idusuario type=hidden value="<?=$datosIng['idusuario']?>">
		<div class=form-row>
			<div class="form-group col-md-6">
				<label for=idrol class=font-weight-bold>Elija un nuevo rol para <?=$usuario->getusnombre().' '.$usuario->getusapellido().':'?></label>
				<div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                    </div>
					<select class=form-control name=idrol id=idrol>
						<option value=Ninguno disabled selected value>Seleccione una opción...</option>
						<?php // Lee los usuarios de la base de datos, y completa las opciones:
						$AbmRol = new abmrol;
						$listaRol = $AbmRol->buscar(null);
						if(!empty($listaRol)){
							foreach ($listaRol as $rol) {
								echo '<option value='.$rol->getidrol().'>'
									.$rol->getroldescripcion().'</option>';
							}
						}?>
					</select>
				</div>
			</div>
		</div>
		<div class="form-row col-md-6">
			<input type="submit" value="Actualizar rol" class="btn btn-info">
		</div>
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