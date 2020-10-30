<?php
class abmarchivocargadoestado{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return archivocargadoestado
 */
private function cargarObjeto($param){
    $obj = null;
    if( array_key_exists('idarchivocargadoestado',$param) &&
        array_key_exists('idestadotipos',$param) &&
        array_key_exists('acedescripcion',$param) &&
        array_key_exists('idusuario',$param) &&
        array_key_exists('acefechaingreso',$param) &&
        array_key_exists('acefechafin',$param) &&
        array_key_exists('idarchivocargado',$param)
    ){
        $obj = new archivocargadoestado();
        $obj->setear($param['idarchivocargadoestado'], $param['idestadotipos'], 
        $param['acedescripcion'], $param['idusuario'], 
        $param['acefechaingreso'], $param['acefechafin'], 
        $param['idarchivocargado']);
    }
    return $obj;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return archivocargadoestado
 */
private function cargarObjetoConClave($param){
    $obj = null;
    if( isset($param['idarchivocargadoestado']) ){
        $obj = new archivocargadoestado();
        $obj->setear($param['idarchivocargadoestado'], null, null, null, 
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
    if (isset($param['idarchivocargadoestado']))
        $resp = true;
    return $resp;
}

/**
 * 
 * @param array $param
 */
public function alta($param){
    $resp = false;
    // $param['idarchivocargadoestado'] =null;
    $Objarchivocargadoestado = $this->cargarObjeto($param);
    // verEstructura($Objarchivocargadoestado);
    if ($Objarchivocargadoestado!=null and $Objarchivocargadoestado->insertar()){
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
        $Objarchivocargadoestado = $this->cargarObjetoConClave($param);
        if ($Objarchivocargadoestado!=null and $Objarchivocargadoestado->eliminar()){
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
        $Objarchivocargadoestado = $this->cargarObjeto($param);
        if($Objarchivocargadoestado!=null and $Objarchivocargadoestado->modificar()){
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
        if  (isset($param['idarchivocargadoestado']))
            $where.=" and idarchivocargadoestado =".$param['idarchivocargadoestado'];
        if  (isset($param['idestadotipos']))
            $where.=" and idestadotipos ='".$param['idestadotipos']."'";
        if  (isset($param['acedescripcion']))
            $where.=" and acedescripcion ='".$param['acedescripcion']."'";
        if  (isset($param['idusuario']))
            $where.=" and idusuario ='".$param['idusuario']."'";
        if  (isset($param['acefechaingreso']))
            $where.=" and acefechaingreso ='".$param['acefechaingreso']."'";
        if  (isset($param['acefechafin']))
            $where.=" and acefechafin ='".$param['acefechafin']."'";
        if  (isset($param['idarchivocargado']))
            $where.=" and idarchivocargado ='".$param['idarchivocargado']."'";
    }
    $arreglo = archivocargadoestado::listar($where);  
    return $arreglo;
}

} // Fin clase abmarchivocargadoestado
?>