<?php 
class estadotipos {
private $idestadotipos;
private $etdescripcion;
private $etactivo;
private $mensajeoperacion;


public function __construct(){
    $this->idestadotipos="";
    $this->etdescripcion="";
    $this->etactivo=1;
    $this->mensajeoperacion ="";
}
public function setear($idestadotipos, $etdescripcion, $etactivo) {
    $this->setidestadotipos($idestadotipos);
    $this->setetdescripcion($etdescripcion);
    $this->setetactivo($etactivo);
}

public function cargar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="SELECT * FROM estadotipos WHERE idestadotipos = ".$this->getidestadotipos();
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $base->Registro();
                $this->setear($row['idestadotipos'], $row['etdescripcion'], $row['etactivo']);
            }
        }
    } else {
        $this->setMensajeoperacion("estadotipos->listar: ".$base->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    $base=new BaseDatos();
    // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
    $sql="INSERT INTO estadotipos(etdescripcion, etactivo) 
        VALUES('".$this->getetdescripcion()."', '".$this->getetactivo()."');";
    if ($base->Iniciar()) {
        if ($esteid = $base->Ejecutar($sql)) {
            // Si se usa ID autoincrement, descomentar lo siguiente:
            $this->setidestadotipos($esteid);
            $resp = true;
        } else {
            $this->setMensajeoperacion("estadotipos->insertar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("estadotipos->insertar: ".$base->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="UPDATE estadotipos 
    SET etdescripcion='".$this->getetdescripcion()
    ."', etactivo='".$this->getetactivo()
    ."' WHERE idestadotipos=".$this->getidestadotipos();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("estadotipos->modificar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("estadotipos->modificar: ".$base->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="DELETE FROM estadotipos WHERE idestadotipos=".$this->getidestadotipos();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            return true;
        } else {
            $this->setMensajeoperacion("estadotipos->eliminar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("estadotipos->eliminar: ".$base->getError());
    }
    return $resp;
}

public static function listar($parametro=""){
    $arreglo = array();
    $base=new BaseDatos();
    $sql="SELECT * FROM estadotipos ";
    if ($parametro!="") {
        $sql.='WHERE '.$parametro;
    }
    $res = $base->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $base->Registro()){
                $obj= new estadotipos();
                $obj->setear($row['idestadotipos'], 
                $row['etdescripcion'], $row['etactivo']);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeoperacion("estadotipos->listar: ".$base->getError());
    }

    return $arreglo;
}
    
// -- Métodos get y set --

public function getidestadotipos() {
    return $this->idestadotipos;
}
public function setidestadotipos($idestadotipos) {
    $this->idestadotipos = $idestadotipos;
    return $this;
}

public function getetdescripcion() {
    return $this->etdescripcion;
}
public function setetdescripcion($etdescripcion) {
    $this->etdescripcion = $etdescripcion;
    return $this;
}

public function getetactivo() {
    return $this->etactivo;
}
public function setetactivo($etactivo) {
    $this->etactivo = $etactivo;
    return $this;
}

public function getMensajeoperacion() {
    return $this->mensajeoperacion;
}
public function setMensajeoperacion($mensajeoperacion) {
    $this->mensajeoperacion = $mensajeoperacion;
    return $this;
}
} // Fin clase estadotipos


?>