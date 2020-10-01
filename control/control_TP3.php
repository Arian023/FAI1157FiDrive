<?php
class control_TP3 {
    // Nota: Este control trabaja con archivos ubicados en una subcarpeta de donde se encuentra la página web invocada
    // Ejemplo: Sitio en ../vista/index.php, archivo en ../vista/archivos/ejemplo.txt 

public $dir = 'archivos/'; // Carpeta por defecto
private $phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
); // Fuente: https://www.php.net/manual/en/features.file-upload.errors.php

public function mensajeError($archivo) {
    /* Manejo de errores mostrando texto con el nombre del archivo
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return String $mensaje El mensaje de error generado
     */
    $mensaje = "";
    switch ($archivo['error']) {
        case 0: $mensaje = "Archivo ".$archivo['name']." cargado con éxito";
            break;
        case 1: $mensaje = "El archivo ".$archivo['name']." supera el límite establecido por el servidor (upload_max_filesize en php.ini)";
            break;
        case 2: $mensaje = "El archivo ".$archivo['name']." supera el límite establecido por el formulario (MAX_FILE_SIZE)";
            break;
        case 3: $mensaje = "El archivo ".$archivo['name']." fue subido parcialmente";
            break;
        case 4: $mensaje = "No se cargó el archivo ".$archivo['name'];
            break;
        case 6: $mensaje = "Falta una carpeta temporal";
            break;
        case 7: $mensaje = "Falló al guardar el archivo ".$archivo['name']." en el disco";
            break;
        case 8: $mensaje = "Una extensión de PHP detuvo la carga";
            break;
        default: $mensaje = "Error desconocido en la carga";
            break;
    }
    return $mensaje;
}

public function guardar($archivo) {
    /* Copia desde la carpeta temporal de PHP hasta la subcarpeta ../archivo
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return método de copiado que en sí, retorna boolean si tuvo éxito
     */
    return copy($archivo['tmp_name'], $this->dir.$archivo['name']);
}

public function guardarDoc($archivo) {
    /* Solo para documentos (.doc, .docx, .pdf, .txt)
     * Copia desde la carpeta temporal de PHP hasta la subcarpeta ../archivo
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return boolean $copiado Resultado de la copia
     */

    // Comprueba que el tipo de archivo sea documento:
    if (in_array($archivo['type'], 
        array("application/pdf", 
        "application/msword", 
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
        "text/plain") ) ) {
        $copiado = copy($archivo['tmp_name'], $this->dir.$archivo['name']);
    } else {
        $copiado = false;
    }
    return $copiado;
}

public function guardarEn($archivo, $ruta) {
    /* Copia desde la carpeta temporal de PHP hasta la carpeta elegida
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @param String $ruta otra dirección señalada
     * @return método de copiado que en sí, retorna boolean si tuvo éxito
     */
    return copy($archivo['tmp_name'], $ruta.$archivo['name']);
}

public function datosArchivo($archivo) {
    /* Muestra los detalles de un archivo, para ser mostrado en la página web
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return String $mensaje El mensaje generado con los datos
     */
    $mensaje =  "Nombre: " . $archivo['name'] . "<br>";

    switch ($archivo['type']) {
        case "application/pdf": 
            $mensaje .=  "Tipo: Documento PDF<br>";
            break;
        case "application/msword": 
            $mensaje .=  "Tipo: Documento Word 97-03 (.doc)<br>";
            break;
        case "application/vnd.openxmlformats-officedocument.wordprocessingml.document": 
            $mensaje .=  "Tipo: Documento Word (.docx)<br>";
            break;
        case "application/vnd.ms-excel": 
            $mensaje .=  "Tipo: Documento Excel (.xls)<br>";
            break;
        case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet": 
            $mensaje .=  "Tipo: Documento Excel (.xlsx)<br>";
            break;
        default: $mensaje .=  "Tipo: " . $archivo['type'] . "<br>";
            break;
    }

    
    if ($archivo["size"] > 1024000) {
        $mensaje .=  "Tamaño: " . ($archivo["size"] / 1024) . " KB";
    } else {
        $mensaje .=  "Tamaño: " . $archivo["size"] . " bytes";
    }
    
    return $mensaje;
}

public function mostrarTexto($archivo) {
    /* Lee un archivo txt y lo retorna como texto
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return String $texto El mensaje generado con el contenido, boolean false si hay error
     */
    $texto = file_get_contents( $this->dir.$archivo['name'] );
    
    return $texto;
}

} // -- Fin clase control_TP3 --
?>