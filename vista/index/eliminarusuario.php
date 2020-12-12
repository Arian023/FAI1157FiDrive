<?php $Titulo = "Eliminar usuario - FiDrive"; 
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

<div class="container text-center p-2" id=formulario> <!-- Comienzo div formulario -->
    <?php // Si no inició sesión, muestra solo aviso
	if ( null == $sesion->getuslogin() ) {
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>
		Esta sección del sitio es para usuarios registrados. Por favor utiliza el botón [Iniciar sesión] del menú superior para ingresar.</div>";
	} else if ($datosIng['idusuario'] != $sesion->getidusuario() && !$sesion->esadmin()) {
		// Se verifica que sea el usuario activo o un administrador para modificar los datos
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-exclamation-circle mx-2'></i>
		No puedes eliminar otro usuario que no sea el propio. Caso contrario, contacta al administrador.</div>";
    } else { // Sino, muestra el resto del contenido normalmente:
        // Si existe el usuario, muestra formulario y rellena los campos:
        if (null != $usuario){
        if(isset($datosIng['usactivo']) && $datosIng['usactivo'] == 1) {
            echo "<h4 class=mb-4><i class='fas fa-user-plus mx-2'></i>Confirmar habilitar usuario:</h4>";
        } else {
            echo "<h4 class=mb-4><i class='fas fa-user-minus mx-2'></i>Confirmar eliminar usuario:</h4>";
        } 
    ?>
    <h5><?=$usuario->getusnombre()." ".$usuario->getusapellido()?></h5>
    <form method=post action="../action/eliminarlogin.php">
        <input id=idusuario name=idusuario type=hidden value="<?=$datosIng['idusuario']?>">
        <a href="listausuarios.php" class="btn btn-outline-dark"><i class="fas fa-undo mx-2"></i>Cancelar</a>
        <input type="submit" value="Eliminar" class="btn btn-danger mx-2">
    </form>
    <?php   } else {
            echo "<h4 class=mb-4><i class='fas fa-user-minus mx-2'></i>Confirmar eliminar usuario:</h4>
            <div class='alert alert-danger' role='alert'>
                <i class='fas fa-question-circle mx-2'></i>No se encontró el usuario a eliminar.
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