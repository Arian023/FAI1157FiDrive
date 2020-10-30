<?php
class abmestadotipos{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return estadotipos
 */
private function cargarObjeto($param){
    $obj = null;
    if( array_key_exists('idestadotipos',$param) &&
        array_key_exists('etdescripcion',$param) &&
        array_key_exists('etactivo',$param)
    ){
        $obj = new estadotipos();
        $obj->setear($param['idestadotipos'],  
            $param['etdescripcion'], $param['etactivo']);
    }
    return $obj;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return estadotipos
 */
private function cargarObjetoConClave($param){
    $obj = null;
    if( isset($param['idestadotipos']) ){
        $obj = new estadotipos();
        $obj->setear($param['idestadotipos'], null, null, null, 
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
    if (isset($param['idestadotipos']))
        $resp = true;
    return $resp;
}

/**
 * 
 * @param array $param
 */
public function alta($param){
    $resp = false;
    // $param['idestadotipos'] =null;
    $Objestadotipos = $this->cargarObjeto($param);
    // verEstructura($Objestadotipos);
    if ($Objestadotipos!=null and $Objestadotipos->insertar()){
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
        $Objestadotipos = $this->cargarObjetoConClave($param);
        if ($Objestadotipos!=null and $Objestadotipos->eliminar()){
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
        $Objestadotipos = $this->cargarObjeto($param);
        if($Objestadotipos!=null and $Objestadotipos->modificar()){
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
        if  (isset($param['idestadotipos']))
            $where.=" and idestadotipos =".$param['idestadotipos'];
        if  (isset($param['etdescripcion']))
            $where.=" and etdescripcion ='".$param['etdescripcion']."'";
        if  (isset($param['etactivo']))
            $where.=" and etactivo ='".$param['etactivo']."'";
    }
    $arreglo = estadotipos::listar($where);  
    return $arreglo;
}

} // Fin clase abmestadotipos
?>