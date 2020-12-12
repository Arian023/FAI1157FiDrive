<?php
class Session {

public function __construct() {
	// Inicia o continúa la sesión
	session_start();
}

public function iniciar($uslogin, $usclave) {
	/* Verifica si existe o no el usuario según nombre de usuario recibido
	 * @param int $uslogin El nombre del usuario que intenta acceder
	 * @param int $usclave Contraseña previamente cifrada en md5 por javascript
	 * @return boolean $resp El resultado de la operación
	 */
	$resp = false;
	if ($this->validar($uslogin, $usclave)) {
		// Actualiza arreglo $_SESSION con el usuario
		$_SESSION['uslogin']=$uslogin;
		// Busca el nombre y apellido para tener facil acceso en metodos publicos get
		$usuario = $this->getobjusuario();
		$_SESSION['idusuario'] = $usuario->getidusuario();
		$_SESSION['usnombre'] = $usuario->getusnombre();
		$_SESSION['usapellido'] = $usuario->getusapellido();

		// Opcional, verificar tiempo de conexión en cada página, y cerrar sesión automáticamente por inactividad. - horainicio puede ser útil para algún caso:
		$_SESSION['horainicio'] = date("Y-m-d H:i:s");

		$resp = true;
	}
	return $resp;
}

public function validar($uslogin, $usclave) {
	/* Verifica si existe o no el usuario según nombre de usuario recibido
	 * @param int $uslogin El nombre del usuario que intenta acceder
	 * @param int $usclave Contraseña previamente cifrada en md5 por javascript
	 * @return boolean $resp El resultado de la operación
	 */
	$resp = false;
	$claveSegura = sha1('FiDrive'.$usclave);

	echo "<h3> Clave recibida: $usclave - Clave segura: $claveSegura </h3>";

	$AbmUsuario = new AbmUsuario();
	// Realiza la búsqueda con el parámetro de uslogin, la clave vuelta a cifrar, y si está activo:
	$param['uslogin'] = $uslogin;
	$param['usclave'] = $claveSegura;
	$param['usactivo'] = 1;
	$ListaUsuario = $AbmUsuario->buscar($param);
	if (!empty($ListaUsuario)) {
		$resp=true;
	}
	return $resp;
}

public function activa() {
	// Verifica si la sesión está activa
	$resp=false;
	if (session_status()=== PHP_SESSION_ACTIVE) {
		$resp=true;
	}
	return $resp;
}

private function getobjusuario() {
	// Obtiene según nombre de usuario, y retorna el objeto usuario
	// Nota: Metodo privado para evitar acceso a la contraseña guardada, desde fuera de clase Session
	if ($this->activa() && !empty($this->getuslogin()) ) {
		$AbmUsuario=new AbmUsuario();
		// En $_SESSION tenemos el parametro uslogin para buscar el objeto usuario
		$param['uslogin'] = $this->getuslogin();
		$ListaUsuario = $AbmUsuario->buscar($param);
		$objUsuario = $ListaUsuario[0];
	} else {
		$objUsuario = null;
	}
	return $objUsuario;
}

public function getidusuario() {
	// Retorna el propio usuario activo, seteado en iniciar()
	$idusuario = null;
	if (isset($_SESSION['idusuario'])) {
		$idusuario = $_SESSION['idusuario'];
	}
	return $idusuario;
}
public function getuslogin() {
	// Retorna el propio usuario activo, seteado en iniciar()
	$uslogin = null;
	if (isset($_SESSION['uslogin'])) {
		$uslogin = $_SESSION['uslogin'];
	}
	return $uslogin;
}
public function getusnombre() {
	// Retorna el nombre del usuario activo, seteado en iniciar()
	$usnombre = null;
	if (isset($_SESSION['usnombre'])) {
		$usnombre = $_SESSION['usnombre'];
	}
	return $usnombre;
}
public function getusapellido() {
	// Retorna el apellido del usuario activo, seteado en iniciar()
	$usapellido = null;
	if (isset($_SESSION['usapellido'])) {
		$usapellido = $_SESSION['usapellido'];
	}
	return $usapellido;
}
	
public function getroles() {
	// Obtiene según usuario, y retorna el objeto rol
	
	// Obtiene el objeto usuario:
	$usuario = $this->getobjusuario();
	if ($usuario != null) {
		// Según el idusuario, busca el rol que le pertenece en la tabla relación usuariorol:
		$AbmUsRol = new AbmUsuarioRol();
		$param['idusuario'] = $usuario->getidusuario();
		$ListaUsRol = $AbmUsRol->buscar($param);
	} else {
		$ListaUsRol = null;
	}
	return $ListaUsRol;
}
	
public function cerrar() {
	// Cierra la sesión
	if ($this->activa()) {
		// También sirve session_unset() para borrar todas las variables
		unset($_SESSION['idusuario']);
		unset($_SESSION['uslogin']);
		unset($_SESSION['usnombre']);
		unset($_SESSION['usapellido']);
		unset($_SESSION['horainicio']);
		session_destroy();
	}
}

public function esadmin() {
	// Retorna true si el usuario activo tiene permiso de administrador
	$esAdmin = false;
	$ListaUsRol = $this->getroles();
	foreach ($ListaUsRol as $usuarioRol) {
		// idrol = 1, es Administrador
		if ($usuarioRol->getobjrol()->getidrol() == 1) {
			$esAdmin = true;
			break;
		}
	}
	return $esAdmin;
}

} // Fin clase Session
?>