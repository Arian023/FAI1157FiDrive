<?php
class abmusuariorol{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return usuariorol
 */
private function cargarObjeto($param){
    $obj = null;
    if( array_key_exists('idusuario',$param) &&
        array_key_exists('idrol',$param)
    ){
        // Carga los objetos que hacen referencia a sus ID
        $objusuario = new usuario;
        $objusuario->setidusuario($param['idusuario']);
        $objusuario->cargar();

        $objrol = new rol;
        $objrol->setidrol($param['idrol']);
        $objrol->cargar();

        $obj = new usuariorol();
        $obj->setear($objusuario, $objrol);
    }
    return $obj;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return usuariorol
 */
private function cargarObjetoConClave($param){
    $obj = null;
    if( isset($param['idusuario']) ){
        $obj = new usuariorol();
        $obj->setear($param['idusuario'], null);
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
    $Objusuariorol = $this->cargarObjeto($param);
    // Se filtra si ya existe la combinación de idusuario e idrol
    // Es decir, que el usuario ya tenga asignado el mismo rol que el ingresado por formulario
    if (!empty($this->buscar($param))) {
        $resp = true;
    } else {
        // Caso contrario, realiza el alta normalmente
        if ($Objusuariorol!=null and $Objusuariorol->insertar()){
            $resp = true;
        }
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
        $Objusuariorol = $this->cargarObjetoConClave($param);
        if ($Objusuariorol!=null and $Objusuariorol->eliminar()){
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
    // echo "<i>**Realizando la modificación**</i>"; var_dump($param);
    $resp = false;
    if ($this->seteadosCamposClaves($param)){
        $Objusuariorol = $this->cargarObjeto($param);
        if($Objusuariorol!=null and $Objusuariorol->modificar()){
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
        if  (isset($param['idrol']))
            $where.=" and idrol ='".$param['idrol']."'";
    }
    $arreglo = usuariorol::listar($where);  
    return $arreglo;
}

} // Fin clase abmusuariorol
?>