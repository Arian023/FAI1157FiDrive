<?php 
class usuario {
private $idusuario;
private $usnombre;
private $usapellido;
private $uslogin;
private $usclave;
private $usactivo;
private $mensajeoperacion;


public function __construct(){
    $this->idusuario="";
    $this->usnombre="";
    $this->usapellido="";
    $this->uslogin="";
    $this->usclave="";
    $this->usactivo=1;
    $this->mensajeoperacion ="";
}
public function setear($idusuario, $usnombre, $usapellido, $uslogin, $usclave, $usactivo) {
    $this->setidusuario($idusuario);
    $this->setusnombre($usnombre);
    $this->setusapellido($usapellido);
    $this->setuslogin($uslogin);
    $this->setusclave($usclave);
    $this->setusactivo($usactivo);
}

public function cargar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="SELECT * FROM usuario WHERE idusuario = ".$this->getidusuario();
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $base->Registro();
                $this->setear($row['idusuario'], $row['usnombre'], $row['usapellido'],
                    $row['uslogin'], $row['usclave'], $row['usactivo']);
            }
        }
    } else {
        $this->setMensajeoperacion("usuario->listar: ".$base->getError());
    }
    return $resp;
}

public function insertar(){
    $resp = false;
    $base=new BaseDatos();
    // Si lleva ID Autoincrement, la consulta SQL no lleva dicho ID
    $sql="INSERT INTO usuario(usnombre, usapellido, uslogin, usclave, usactivo) 
        VALUES('"
        .$this->getusnombre()."', '"
        .$this->getusapellido()."', '"
        .$this->getuslogin()."', '"
        .$this->getusclave()."', '"
        .$this->getusactivo()."'
    );";
    if ($base->Iniciar()) {
        if ($esteid = $base->Ejecutar($sql)) {
            // Si se usa ID autoincrement, descomentar lo siguiente:
            $this->setidusuario($esteid);
            $resp = true;
        } else {
            $this->setMensajeoperacion("usuario->insertar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("usuario->insertar: ".$base->getError());
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="UPDATE usuario 
    SET usnombre='".$this->getusnombre()
    ."', usapellido='".$this->getusapellido()
    ."', uslogin='".$this->getuslogin()
    ."', usclave='".$this->getusclave()
    ."', usactivo='".$this->getusactivo()
    ."' WHERE idusuario=".$this->getidusuario();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setMensajeoperacion("usuario->modificar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("usuario->modificar: ".$base->getError());
    }
    return $resp;
}

public function eliminar(){
    $resp = false;
    $base=new BaseDatos();
    $sql="DELETE FROM usuario WHERE idusuario=".$this->getidusuario();
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            return true;
        } else {
            $this->setMensajeoperacion("usuario->eliminar: ".$base->getError());
        }
    } else {
        $this->setMensajeoperacion("usuario->eliminar: ".$base->getError());
    }
    return $resp;
}

public static function listar($parametro=""){
    $arreglo = array();
    $base=new BaseDatos();
    $sql="SELECT * FROM usuario ";
    if ($parametro!="") {
        $sql.='WHERE '.$parametro;
    }
    $res = $base->Ejecutar($sql);
    if($res>-1){
        if($res>0){
            while ($row = $base->Registro()){
                $obj= new usuario();
                $obj->setear($row['idusuario'], $row['usnombre'], 
                    $row['usapellido'], $row['uslogin'], 
                    $row['usclave'], $row['usactivo']);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeoperacion("usuario->listar: ".$base->getError());
    }

    return $arreglo;
}
    
// -- Métodos get y set --

public function getidusuario() {
    return $this->idusuario;
}
public function setidusuario($idusuario) {
    $this->idusuario = $idusuario;
    return $this;
}

public function getusnombre() {
    return $this->usnombre;
}
public function setusnombre($usnombre) {
    $this->usnombre = $usnombre;
    return $this;
}

public function getusapellido() {
    return $this->usapellido;
}
public function setusapellido($usapellido) {
    $this->usapellido = $usapellido;
    return $this;
}

public function getuslogin() {
    return $this->uslogin;
}
public function setuslogin($uslogin) {
    $this->uslogin = $uslogin;
    return $this;
}

public function getusclave() {
    return $this->usclave;
}
public function setusclave($usclave) {
    $this->usclave = $usclave;
    return $this;
}

public function getusactivo() {
    return $this->usactivo;
}
public function setusactivo($usactivo) {
    $this->usactivo = $usactivo;
    return $this;
}

public function getMensajeoperacion() {
    return $this->mensajeoperacion;
}
public function setMensajeoperacion($mensajeoperacion) {
    $this->mensajeoperacion = $mensajeoperacion;
    return $this;
}
} // Fin clase usuario


?>