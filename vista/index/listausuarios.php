<?php $Titulo = "Usuarios registrados - FiDrive";
include_once("../estructura/cabecera.php");
// Llama al objeto con métodos para manejar ABM de usuarios:
$AbmUsuario = new abmusuario();
// Procede a buscar todas los usuarios en la tabla:
$listaUsuario = $AbmUsuario->buscar(null);
//print_R ($listaUsuario);
?>
<div class="card p-2 shadow-lg" id=cuerpo> <!-- Comienzo div cuerpo-->

<div class="container p-2" id=contenido> <!-- Comienzo div contenido -->
<?php // Si no inició sesión, muestra solo aviso
	if ( null == $sesion->getuslogin() && $sesion->esadmin()) {
		echo "<div class='col alert alert-warning text-center' role='alert'>
		<i class='fas fa-question-circle mx-2'></i>
		Esta sección del sitio es para administradores. Por favor utiliza el botón [Iniciar sesión] del menú superior para ingresar.</div>";
	} else { // Muestra el resto del contenido normalmente:	
?>
	<h4 class="text-center mb-4"><i class="fas fa-users mx-2"></i>Listado de usuarios:</h4>
    <a href="registro.php" class='btn btn-info mx-2'><i class="fas fa-plus mx-2"></i>Cargar nuevo</a>
	<hr class=my-4>
    <table class='table table-striped table-hover table-responsive text-center'>
    <?php 
    if( count($listaUsuario)>0){
        // Se arma el encabezado, sabiendo las columnas que tiene la tabla:
		echo "<thead>
            <tr>
                <th scope=col>ID</th>
                <th scope=col>Nombre</th>
                <th scope=col>Apellido</th>
                <th scope=col>Usuario</th>
                <th scope=col>Activo</th>
                <th scope=col>Editar datos</th>
                <th scope=col>Roles</th>
                <th scope=col>Editar rol</th>
                <th scope=col>Des/habilitar</th>
            </tr>
        </thead>
        <tbody>";
        foreach ($listaUsuario as $objUsuario) {
            // No estoy ubicando la condición adecuada para marcar en cursiva si tiene fecha de deshabilitado. ¡Pero aún así funciona!
            if ($objUsuario->getusactivo() == 1) {
                echo '<td>'.$objUsuario->getidusuario().'</td>
                    <td>'.$objUsuario->getusnombre().'</td>
                    <td>'.$objUsuario->getusapellido().'</td>
                    <td>'.$objUsuario->getuslogin().'</td>
                    <td> SI </td>';
                echo '<td><a href="actualizarusuario.php?idusuario='.$objUsuario->getidusuario().'" class="btn btn-info btn-sm">
                <i class="fas fa-user-edit mx-2"></i> datos</a></td>';
                // Para mostrar los roles, genera un select:
				echo '<td><select class=form-control>';
                $AbmUsRol = new abmusuariorol;
                // Buscar en tabla usuariorol, por el id del usuario:
                $param['idusuario'] = $objUsuario->getidusuario();
                $listaUsRol = $AbmUsRol->buscar($param);
                if(!empty($listaUsRol)){
                    foreach ($listaUsRol as $usrol) {
                        echo '<option value='.$usrol->getobjrol()->getidrol().'>'
                            .$usrol->getobjrol()->getroldescripcion().'</option>';
                    }
                }
                echo '</select></td>';
                echo '<td><a href="actualizarrol.php?idusuario='.$objUsuario->getidusuario().'" class="btn btn-info btn-sm">
                <i class="fas fa-user-tag mx-2"></i> rol</a></td>';
                echo '<td><a href="eliminarusuario.php?idusuario='.$objUsuario->getidusuario().'&usactivo=0" class="btn btn-info btn-sm">
                <i class="fas fa-user-minus mx-2"></i> deshabilitar</a></td>
                </tr>';
            } else {
                echo '<td class="font-italic">'.$objUsuario->getidusuario().'</td>
                    <td class="font-italic">'.$objUsuario->getusnombre().'</td>
                    <td class="font-italic">'.$objUsuario->getusapellido().'</td>
                    <td class="font-italic">'.$objUsuario->getuslogin().'</td>
                    <td class="font-italic"> NO </td>';
                echo '<td class="font-italic"><a href="actualizarusuario.php?idusuario='.$objUsuario->getidusuario().'" class="btn btn-info btn-sm">
                <i class="fas fa-user-edit mx-2"></i> datos</a></td>';
                // Para mostrar los roles, genera un select:
				echo '<td class="font-italic"><select class=form-control>';
                $AbmUsRol = new abmusuariorol;
                // Buscar en tabla usuariorol, por el id del usuario:
                $param['idusuario'] = $objUsuario->getidusuario();
                $listaUsRol = $AbmUsRol->buscar($param);
                if(!empty($listaUsRol)){
                    foreach ($listaUsRol as $usrol) {
                        echo '<option value='.$usrol->getobjrol()->getidrol().'>'
                            .$usrol->getobjrol()->getroldescripcion().'</option>';
                    }
                }
                echo '</select></td>';
                echo '<td class="font-italic"><a href="actualizarrol.php?idusuario='.$objUsuario->getidusuario().'" class="btn btn-info btn-sm">
                <i class="fas fa-user-tag mx-2"></i> rol</a></td>';
                echo '<td class="font-italic"><a href="eliminarusuario.php?idusuario='.$objUsuario->getidusuario().'&usactivo=1" class="btn btn-info btn-sm">
                <i class="fas fa-user-plus mx-2"></i> habilitar</a></td>
                </tr>';
            }
        }
		echo "</tbody>";
    } else {
    echo "<div class='alert alert-info' role='alert'> El listado de usuarios está vacío. </div>";
    }
    ?>
    </table>
<?php
	} // Fin else de sesión activa
?>
</div> <!-- Fin div contenido -->
<hr class=my-4>
<div class=row>
	<div class=col><a href="../index/index.php" class="btn btn-outline-dark btn-block">
		<i class='fas fa-home mx-2'></i>Volver al Inicio</a></div>
</div>
</div> <!-- Fin div cuerpo -->
<?php include_once("../estructura/pie.php"); ?>