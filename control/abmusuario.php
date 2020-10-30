<?php
class abmusuario{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return usuario
 */
private function cargarObjeto($param){
    $obj = null;
    if( array_key_exists('idusuario',$param) &&
        array_key_exists('usnombre',$param) &&
        array_key_exists('usapellido',$param) &&
        array_key_exists('uslogin',$param) &&
        array_key_exists('usclave',$param) &&
        array_key_exists('usactivo',$param)
    ){
        $obj = new usuario();
        $obj->setear($param['idusuario'], $param['usnombre'], 
            $param['usapellido'], $param['uslogin'], 
            $param['usclave'], $param['usactivo']);
    }
    return $obj;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return usuario
 */
private function cargarObjetoConClave($param){
    $obj = null;
    if( isset($param['idusuario']) ){
        $obj = new usuario();
        $obj->setear($param['idusuario'], null, null, null, null, null);
    }
    return $obj;
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
    // $param['idusuario'] =null;
    $Objusuario = $this->cargarObjeto($param);
    // verEstructura($Objusuario);
    if ($Objusuario!=null and $Objusuario->insertar()){
        $resp = true;
    }
    return $resp;
}

/**
 * permite eliminar un objeto 
 * @param array $param
 * @return boolean
 */
public function baja($param){
    $resp = false;
    if ($this->seteadosCamposClaves($param)){
        $Objusuario = $this->cargarObjetoConClave($param);
        if ($Objusuario!=null and $Objusuario->eliminar()){
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
    var_dump($param);
    $resp = false;
    if ($this->seteadosCamposClaves($param)){
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