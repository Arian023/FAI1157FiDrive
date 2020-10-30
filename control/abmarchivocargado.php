<?php
class abmarchivocargado{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return archivocargado
 */
private function cargarObjeto($param){
    $obj = null;
    if( array_key_exists('idarchivocargado',$param) && 
        array_key_exists('acnombre',$param) && 
        array_key_exists('acdescripcion',$param) && 
        array_key_exists('acicono',$param) && 
        array_key_exists('idusuario',$param) && 
        array_key_exists('aclinkacceso',$param) && 
        array_key_exists('accantidaddescarga',$param) && 
        array_key_exists('accantidadusada',$param) && 
        array_key_exists('acfechainiciocompartir',$param) && 
        array_key_exists('acfechafincompartir',$param) && 
        array_key_exists('acprotegidoclave',$param)
        ){
        $obj = new archivocargado();
        $obj->setear($param['idarchivocargado'], $param['acnombre'], 
            $param['acdescripcion'], $param['acicono'], 
            $param['idusuario'], $param['aclinkacceso'], 
            $param['accantidaddescarga'], $param['accantidadusada'], 
            $param['acfechainiciocompartir'], $param['acfechafincompartir'], 
            $param['acprotegidoclave']);
    }
    return $obj;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return archivocargado
 */
private function cargarObjetoConClave($param){
    $obj = null;
    if( isset($param['idarchivocargado']) ){
        $obj = new archivocargado();
        $obj->setear($param['idarchivocargado'], null, null, null, 
            null, null, null, null, 
            null, null, null);
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
    if (isset($param['idarchivocargado']))
        $resp = true;
    return $resp;
}

/**
 * 
 * @param array $param
 */
public function alta($param){
    $resp = false;
    // $param['idarchivocargado'] =null;
    $Objarchivocargado = $this->cargarObjeto($param);
    // verEstructura($Objarchivocargado);
    if ($Objarchivocargado!=null and $Objarchivocargado->insertar()){
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
        $Objarchivocargado = $this->cargarObjetoConClave($param);
        if ($Objarchivocargado!=null and $Objarchivocargado->eliminar()){
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
        $Objarchivocargado = $this->cargarObjeto($param);
        if($Objarchivocargado!=null and $Objarchivocargado->modificar()){
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
        if  (isset($param['idarchivocargado']))
            $where.=" and idarchivocargado =".$param['idarchivocargado'];
        if  (isset($param['acnombre']))
            $where.=" and acnombre ='".$param['acnombre']."'";
        if  (isset($param['acdescripcion']))
            $where.=" and acdescripcion ='".$param['acdescripcion']."'";
        if  (isset($param['acicono']))
            $where.=" and acicono ='".$param['acicono']."'";
        if  (isset($param['idusuario']))
            $where.=" and idusuario ='".$param['idusuario']."'";
        if  (isset($param['aclinkacceso']))
            $where.=" and aclinkacceso ='".$param['aclinkacceso']."'";
        if  (isset($param['accantidaddescarga']))
            $where.=" and accantidaddescarga ='".$param['accantidaddescarga']."'";
        if  (isset($param['accantidadusada']))
            $where.=" and accantidadusada ='".$param['accantidadusada']."'";
        if  (isset($param['acfechainiciocompartir']))
            $where.=" and acfechainiciocompartir ='".$param['acfechainiciocompartir']."'";
        if  (isset($param['acefechafincompartir']))
            $where.=" and acefechafincompartir ='".$param['acefechafincompartir']."'";
        if  (isset($param['acprotegidoclave']))
            $where.=" and acprotegidoclave ='".$param['acprotegidoclave']."'";
    }
    $arreglo = archivocargado::listar($where);  
    return $arreglo;
}

} // Fin clase abmarchivocargado
?>