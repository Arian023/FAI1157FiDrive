<?php

class usuariorol {
private $objusuario;
private $objrol;
private $mensajeoperacion;


public function __construct(){
    $this->objusuario="";
    $this->objrol="";
    $this->mensajeoperacion ="";
}
public function setear($objusuario, $objrol) {
    $this->setobjusuario($objusuario);
    $this->setobjrol($objrol);
}

public function cargar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="SELECT * FROM usuariorol WHERE idusuario = ".$this->getobjusuario()
        .' AND idrol='.$this->getobjrol();
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $base->Registro();
                
                // Carga el objeto que hace referencia a ID de usuario
                $usuario = new usuario;
                $usuario->setidusuario($row['idusuario']);
                $usuario->cargar();

                $rol = new rol;
                $rol->setidrol($row['idrol']);
                $rol->cargar();

                $this->setear($usuario, $rol);
            }
        }
    } else {
        $this->setMensajeoperacion("usuariorol->listar: ".$base->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    $base=new BaseDatos();
    // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
    $sql="INSERT INTO usuariorol(idusuario, idrol) 
        VALUES ('".$this->getobjusuario()->getidusuario()
                ."','".$this->getobjrol()->getidrol()."');";
    if ($base->Iniciar()) {
        if ($esteid = $base->Ejecutar($sql)) {
            // Si se usa ID autoincrement, descomentar lo siguiente:
            $this->setobjusuario($esteid);
            $resp = true;
        } else {
            $this->setMensajeoperacion("usuariorol->insertar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("usuariorol->insertar: ".$base->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="UPDATE usuariorol 
    SET idrol='".$this->getobjrol()->getidrol().", "
    ."' WHERE idusuario=".$this->getobjusuario()->getidusuario();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("usuariorol->modificar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("usuariorol->modificar: ".$base->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="DELETE FROM usuariorol WHERE idusuario=".$this->getobjusuario()->getidusuario()." AND idrol=".$this->getobjrol()->getidrol();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            return true;
        } else {
            $this->setMensajeoperacion("usuariorol->eliminar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("usuariorol->eliminar: ".$base->getError());
    }
    return $resp;
}

public static function listar($parametro=""){
    $arreglo = array();
    $base=new BaseDatos();
    $sql="SELECT * FROM usuariorol ";
    if ($parametro!="") {
        $sql.='WHERE '.$parametro;
    }
    $res = $base->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $base->Registro()){
                $obj= new usuariorol();

                // Carga los objetos que hacen referencia a sus ID
                $usuario = new usuario;
                $usuario->setidusuario($row['idusuario']);
                $usuario->cargar();

                $rol = new rol;
                $rol->setidrol($row['idrol']);
                $rol->cargar();

                $obj->setear($usuario, $rol);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeoperacion("usuariorol->listar: ".$base->getError());
    }

    return $arreglo;
}
    
// -- Métodos get y set --

public function getobjusuario() {
    return $this->objusuario;
}
public function setobjusuario($objusuario) {
    $this->objusuario = $objusuario;
    return $this;
}

public function getobjrol() {
    return $this->objrol;
}
public function setobjrol($objrol) {
    $this->objrol = $objrol;
    return $this;
}

public function getMensajeoperacion() {
    return $this->mensajeoperacion;
}
public function setMensajeoperacion($mensajeoperacion) {
    $this->mensajeoperacion = $mensajeoperacion;
    return $this;
}
} // Fin clase usuariorol


?>