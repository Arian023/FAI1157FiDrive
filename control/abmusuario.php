<?php
class abmusuario{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return usuario
 */
private function cargarObjeto($param){
    $nuevoObjeto = null;
    if( array_key_exists('idusuario',$param) &&
        array_key_exists('usnombre',$param) &&
        array_key_exists('usapellido',$param) &&
        array_key_exists('uslogin',$param) &&
        array_key_exists('usclave',$param) &&
        array_key_exists('usactivo',$param)
    ){
        $nuevoObjeto = new usuario();
        $nuevoObjeto->setear($param['idusuario'], $param['usnombre'], 
            $param['usapellido'], $param['uslogin'], 
            $param['usclave'], $param['usactivo']);
    }
    return $nuevoObjeto;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return usuario
 */
private function cargarObjetoConClave($param){
    $nuevoObjeto = null;
    if( isset($param['idusuario']) ){
        $nuevoObjeto = new usuario();
        $nuevoObjeto->setear($param['idusuario'], null, null, null, null, null);
    }
    return $nuevoObjeto;
}

/**
 * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
 * @param array $param
 * @return boolean
 */
private function seteadosCamposClaves($param){
    $resp = false;
    if (isset($param['idusuario']))
        $resp = true;
    return $resp;
}

/**
 * 
 * @param array $param
 */
public function alta($param){
    $resp = false;


    echo "<br><div style='white-space: pre-line'>Clave al pasar por alta(): ".var_export($param['usclave'], true)."</div><br>";


    // Se setean valores por defecto durante el alta:
    $param['idusuario'] = null;
    $param['usactivo'] = 1;
    // usclave ya tendría hash md5, se agrega salt sencillo para complejizar cifrado:
    $param['usclave'] = sha1('FiDrive'.$param['usclave']);


    echo "<br><div style='white-space: pre-line'> Valores luego de pasar por alta: ".var_export($param, true)."</div><br>";


    $Objusuario = $this->cargarObjeto($param);

    if ($Objusuario!=null and $Objusuario->insertar()){
        // Al hacer el alta de usuario, también se hace el alta de su rol

        // Igual que en guardarComo() (de control_archivos.php), se obtiene instancia de objeto archivo, aprovechando los mismos datos para el alta:
        $nuevoUsuario = $this->buscar($param);
        $usuarioRol = array('idusuario' => $nuevoUsuario[0]->getidusuario(), 'idrol' => 3);

        
        echo "<br><div style='white-space: pre-line'> Valores de usuarioRol: ".var_export($usuarioRol, true)."</div><br>";


        $AbmUsuarioRol = new abmusuariorol;
        $resp = $AbmUsuarioRol->alta($usuarioRol);
    }
    return $resp;
}

/**
 * Según idusuario y usactivo, desactiva o reactiva la cuenta
 * @param array $param
 * @return boolean
 */
public function baja($param){
    $resp = false;
    if ($this->seteadosCamposClaves($param)){
        // Un poco rebuscado el método, pero busca los datos según el idusuario:
        $usuario = $this->buscar($param);
        // Viene seteado idusuario y usactivo en arreglo $param (si, baja también reactiva la cuenta)
        // Setea los demás datos para crear el objeto con el que modificar:
        $param['usnombre'] = $usuario[0]->getusnombre();
        $param['usapellido'] = $usuario[0]->getusapellido();
        $param['uslogin'] = $usuario[0]->getuslogin();
        $param['usclave'] = $usuario[0]->getusclave();

        echo "<br><div style='white-space: pre-line'>".var_export($param, true)."</div><br>";

        $Objusuario = $this->cargarObjeto($param);
        if ($Objusuario!=null and $Objusuario->modificar()){
            $resp = true;
        }
    }
    
    return $resp;
}

/**
 * permite modificar un objeto
 * @param array $param
 * @return boolean
 */
public function modificacion($param){
    // echo "<i>**Realizando la modificación**</i>";
    // echo "<br><div style='white-space: pre-line'>".var_export($param, true)."</div><br>";
    $resp = false;
    if ($this->seteadosCamposClaves($param)){

        // usclave ya tendría hash md5, se agrega salt sencillo para complejizar cifrado:
        $param['usclave'] = sha1('FiDrive'.$param['usclave']);


        $Objusuario = $this->cargarObjeto($param);
        if($Objusuario!=null and $Objusuario->modificar()){
            $resp = true;
        }
    }
    return $resp;
}

/**
 * permite buscar un objeto
 * @param array $param
 * @return boolean
 */
public function buscar($param){
    $where = " true ";
    if ($param<>NULL){
        if  (isset($param['idusuario']))
            $where.=" and idusuario ='".$param['idusuario']."'";
        if  (isset($param['usnombre']))
            $where.=" and usnombre ='".$param['usnombre']."'";
        if  (isset($param['usapellido']))
            $where.=" and usapellido ='".$param['usapellido']."'";
        if  (isset($param['uslogin']))
            $where.=" and uslogin ='".$param['uslogin']."'";
        if  (isset($param['usclave']))
            $where.=" and usclave ='".$param['usclave']."'";
        if  (isset($param['usactivo']))
            $where.=" and usactivo ='".$param['usactivo']."'";
    }
    $arreglo = usuario::listar($where);  
    return $arreglo;
}

} // Fin clase abmusuario
?>