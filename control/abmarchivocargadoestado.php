<?php
class abmarchivocargadoestado{

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto
 * @param array $param
 * @return archivocargadoestado
 */
private function cargarObjeto($param){
    $nuevoObjeto = null;
    if( array_key_exists('idarchivocargadoestado',$param) &&
        array_key_exists('idestadotipos',$param) &&
        array_key_exists('acedescripcion',$param) &&
        array_key_exists('idusuario',$param) &&
        array_key_exists('acefechaingreso',$param) &&
        array_key_exists('acefechafin',$param) &&
        array_key_exists('idarchivocargado',$param)
    ){

        // Carga los objetos que hacen referencia a sus ID
        $objusuario = new usuario;
        $objusuario->setidusuario($param['idusuario']);
        $objusuario->cargar();

        $objestadotipos = new estadotipos;
        $objestadotipos->setidestadotipos($param['idestadotipos']);
        $objestadotipos->cargar();
        
        $objarchivocargado = new archivocargado;
        $objarchivocargado->setidarchivocargado($param['idarchivocargado']);
        $objarchivocargado->cargar();

        // Define todos los atributos del objeto archivocargadoestado
        $nuevoObjeto = new archivocargadoestado();
        $nuevoObjeto->setear($param['idarchivocargadoestado'], $objestadotipos, 
        $param['acedescripcion'], $objusuario, 
        $param['acefechaingreso'], $param['acefechafin'], 
        $objarchivocargado);
    }
    return $nuevoObjeto;
}

/**
 * Espera como parametro un arreglo asociativo donde las claves coinciden 
 * con los nombres de las variables instancias del objeto que son claves
 * @param array $param
 * @return archivocargadoestado
 */
private function cargarObjetoConClave($param){
    $nuevoObjeto = null;
    if( isset($param['idarchivocargadoestado']) ){
        $nuevoObjeto = new archivocargadoestado();
        $nuevoObjeto->setear($param['idarchivocargadoestado'], null, null, null, 
            null, null, null, null, 
            null, null, null);
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
    $Objarchivocargadoestado = $this->cargarObjeto($param);
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

/**
 * permite obtener el objeto correspondiente al último estado que no haya expirado
 * @param int $idarchivocargado
 * @return archivocargadoestado / false si no encuentra
 */
public function ultimoEstadoVigente($idarchivocargado) {
    // Busca el registro de estados del archivo según ID y que su estado no haya expirado:
	$estado = $this->buscar(
        array('idarchivocargado' => $idarchivocargado, 'acefechafin' => "0000-00-00 00:00:00")
    );

    /* DEBUG:
    if (!empty($estado) ) {
        echo "<i>Hay un estado vigente para ID $idarchivocargado, fecha ingreso: ".$estado[0]->getacefechaingreso()." y fecha fin: ".$estado[0]->getacefechafin()." </i>| ";
    } else {
        echo "<i>NO hay estado vigente para ID $idarchivocargado</i>| ";
    }*/

    /* Se asume que solo habrá un único registro con fecha fin en cero, 
     * ya que en cada llamado a la tabla abmarchivocargadoestado, 
     * se setea la fecha fin de cada registro anterior y se abre uno nuevo en cero.
     */
    if (!empty($estado) && "0000-00-00 00:00:00" < $estado[0]->getacefechaingreso()) {
        // Protip: En formato Y-m-d, se pueden comparar Strings como fechas, fuente: https://es.stackoverflow.com/a/254916
        $ultimoEstado = end($estado);
    } else {
        $ultimoEstado = false;
    }
    return $ultimoEstado;
}

/**
 * permite averiguar si un archivo fue eliminado por borrado lógico
 * @param int $idarchivocargado
 * @return boolean $habilitado
 */
public function estaHabilitado($idarchivocargado) {
    // Obtiene el último estado vigente:
    $ultimoEstado = $this->ultimoEstadoVigente($idarchivocargado);
    // Si el método ultimoEstadoVigente retorna falso, quiere decir que incluso el primer estado Cargado ya venció. Posiblemente esté eliminado. Caso contrario, se evalúa el idestadotipos:
    if ($ultimoEstado == false) {
        $habilitado = false;
    } else {
        $idestadotipos = $ultimoEstado->getobjestadotipos()->getidestadotipos();
        // Comprueba si los estados son distintos de borrado o deshabilitado:
        $habilitado = ($idestadotipos != 3 && $idestadotipos != 4) ? true : false;
    }
    return $habilitado;
}

/* Versión anterior, antes de hacer ultimoEstadoVigente():

public function estaHabilitado($idarchivocargado) {
    $fechaUltimoEstado = "0000-00-00 00:00:00";
    $ultimoDeshabilitado = "0000-00-00 00:00:00"; // date('Y-m-d H:i:s', "0000-00-00 00:00:00");
    $habilitado = true;

    // Busca el registro de estados del archivo, que tenga configurado el estado en "Eliminado":
	$listaEstados = $this->buscar(
        array('idarchivocargado' => $idarchivocargado)
    );
    foreach($listaEstados as $estado) {
        if ($fechaUltimoEstado < $estado->getacefechaingreso() && $estado->getacefechafin() == "0000-00-00 00:00:00") {
            // Guarda el último estado y su tipo, siempre que no sea un estado expirado (que tenga fecha fin)
            $idestadotipos = $estado->getobjestadotipos()->getidestadotipos();
            $fechaUltimoEstado = $estado->getacefechaingreso();
        }
    }
    // Comprueba si los estados son distintos de borrado o deshabilitado:
    $habilitado = ($idestadotipos != 3 || $idestadotipos != 4) ? true : false;
    return $habilitado;
}
*/

} // Fin clase abmarchivocargadoestado
?>