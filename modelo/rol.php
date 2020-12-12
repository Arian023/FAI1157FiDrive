<?php 
class rol {
private $idrol;
private $roldescripcion;
private $mensajeoperacion;


public function __construct(){
    $this->idrol="";
    $this->roldescripcion="";
    $this->mensajeoperacion ="";
}
public function setear($idrol, $roldescripcion) {
    $this->setidrol($idrol);
    $this->setroldescripcion($roldescripcion);
}

public function cargar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="SELECT * FROM rol WHERE idrol = ".$this->getidrol();
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $base->Registro();
                $this->setear($row['idrol'], $row['roldescripcion']);
            }
        }
    } else {
        $this->setMensajeoperacion("rol->listar: ".$base->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    $base=new BaseDatos();
    // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
    $sql="INSERT INTO rol(roldescripcion) 
        VALUES('".$this->getroldescripcion()."');";
    if ($base->Iniciar()) {
        if ($esteid = $base->Ejecutar($sql)) {
            // Si se usa ID autoincrement, descomentar lo siguiente:
            $this->setidrol($esteid);
            $resp = true;
        } else {
            $this->setMensajeoperacion("rol->insertar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("rol->insertar: ".$base->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="UPDATE rol 
    SET roldescripcion='".$this->getroldescripcion()
    ."' WHERE idrol=".$this->getidrol();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("rol->modificar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("rol->modificar: ".$base->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="DELETE FROM rol WHERE idrol=".$this->getidrol();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            return true;
        } else {
            $this->setMensajeoperacion("rol->eliminar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("rol->eliminar: ".$base->getError());
    }
    return $resp;
}

public static function listar($parametro=""){
    $arreglo = array();
    $base=new BaseDatos();
    $sql="SELECT * FROM rol ";
    if ($parametro!="") {
        $sql.='WHERE '.$parametro;
    }
    $res = $base->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $base->Registro()){
                $obj= new rol();
                $obj->setear($row['idrol'], $row['roldescripcion']);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeoperacion("rol->listar: ".$base->getError());
    }

    return $arreglo;
}
    
// -- Métodos get y set --

public function getidrol() {
    return $this->idrol;
}
public function setidrol($idrol) {
    $this->idrol = $idrol;
    return $this;
}

public function getroldescripcion() {
    return $this->roldescripcion;
}
public function setroldescripcion($roldescripcion) {
    $this->roldescripcion = $roldescripcion;
    return $this;
}

public function getMensajeoperacion() {
    return $this->mensajeoperacion;
}
public function setMensajeoperacion($mensajeoperacion) {
    $this->mensajeoperacion = $mensajeoperacion;
    return $this;
}
} // Fin clase rol
?>