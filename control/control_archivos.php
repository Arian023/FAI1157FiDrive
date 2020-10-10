<?php
class control_archivos {
    // Nota: Este control trabaja con archivos ubicados en una subcarpeta de donde se encuentra la página web invocada
    // Ejemplo: Sitio en ../vista/index.php, archivo en ../vista/archivos/ejemplo.txt 

public $dir = "../archivos/"; // Carpeta por defecto
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

// --- Funciones de errores ---

public function errorCarga($archivo) {
    /* Manejo de errores durante la carga, mostrando texto con el nombre del archivo
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return String $mensaje El mensaje de error generado
     */
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
        default: $mensaje = "Motivo desconocido durante la carga";
            break;
    }
    return $mensaje;
}

// --- Funciones de escritura (guardado y borrado) ---

// Nota 06/10: Los métodos crearDescripcion() y guardarComo() no se usan por malinterpretación de consigna. Más adelante se agregarán las funcionalidades para almacenar el título, usuario, descripción e icono en la base de datos
public function crearDescripcion($ruta, $nom, $desc) {
    /* Crea un archivo de texto asociado a un archivo subido. Contiene texto enriquecido para ser mostrado en la página.
     * @param String $ruta La ubicación de la carpeta donde se crea
     * @param String $nom El nombre del archivo al cual se le asocia descripción
     * @var String $nomDescripcion Nombre del archivo de texto (ej: documento_DESC.txt)
     * @return int los bytes escritos, false si da error
     */

    // @see https://www.php.net/manual/es/function.basename.php para obtener nombre del archivo sin extension
    $nomDescripcion=basename($nom)."_DESC.txt";

    /* Es mucho más fácil usar file_put_contents que fopen / fwrite / fclose.
     * Si existe el archivo, lo sobreescribe. Sino, lo crea.
     * @see https://www.php.net/manual/en/function.file-put-contents.php
     */
    return file_put_contents($ruta.$nomDescripcion, $desc);;
}

public function guardarComo($archivo, $ruta, $nom, $desc, $icono) {
    /* Procedimiento completo de guardado - SIN USO EN SEGUNDA ENTREGA
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return String $mensaje El resultado del copiado
     */

    $errorCopia = copy($archivo['tmp_name'], $ruta.$nom);
    if (!$errorCopia) {
        $mensaje = "Error al copiar";
    } else {
        $mensaje = "Copiado con éxito";
        // $errorDescripcion = crearDescripcion($ruta, $nom, $desc);
    }
    // Guardar icono (y otro metadato como fecha de subida, fecha de modificación) en otro archivo oculto de texto (empieza con punto)

    return $mensaje;
}

public function guardar($archivo) {
    /* Copia desde la carpeta temporal de PHP hasta la subcarpeta ../archivos/
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @return método de copiado que en sí, retorna boolean si tuvo éxito
     */
    return copy($archivo['tmp_name'], $this->dir.$archivo['name']);
}

public function guardarDoc($archivo) {
    /* Solo para documentos (.doc, .docx, .pdf, .txt)
     * Copia desde la carpeta temporal de PHP hasta la subcarpeta ../archivos/
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

public function crearCarpeta($ruta, $nombre) {
    /* Crea una subcarpeta en la ruta donde contenido.php está mostrando actualmente
     * @param String $ruta La ubicación actual a donde crear una subcarpeta
     * @param String $nombre El nombre de la nueva carpeta
     * @see https://www.w3schools.com/php/func_filesystem_mkdir.asp
     * @return boolean true/false si logró crear
     */
    // Se codifica para usarse como link y se concatena con la ruta elegida
    $rutaEntera = $ruta.$nombre;
    // Se verifica si existe la carpeta
    if ( !file_exists($rutaEntera) ) {
        // Realiza la operación de crear la carpeta
        $creado = mkdir($rutaEntera);
    } else {
        $creado = false;
    }
    return $creado;
}

public function modificar($ruta, $nom, $titulo, $desc, $icono) {
    /* Procedimiento de modificación - SIN USO EN SEGUNDA ENTREGA
     * @param String $ruta Indica la ruta del archivo a modificar (ej: '../archivos/')
     * @param String $nom Nombre del archivo (ej: 'imagen.jpg')
     * @param String $titulo Título descriptivo
     * @param String $desc Descripción en editor de texto enriquecido
     * @param String $icono Nombre abreviado elegido en amarchivo.php (ej: 'zip')
     * @return boolean Resultado de la operación
     */
    return true;
}

public function noCompartir($ruta, $nom, $motivo) {
    /* Procedimiento para dejar de compartir - SIN USO EN SEGUNDA ENTREGA
     * @param String $ruta Indica la ruta del archivo (ej: '../archivos/')
     * @param String $nom Nombre del archivo (ej: 'imagen.jpg')
     * @param String $motivo Motivo por el cual se deja de compartir
     * @return boolean Resultado de la operación
     */
    return true;
}

public function borrar($ruta, $nom) {
    /* Procedimiento de borrado - NO BORRA ENTRADA EN BASE DE DATOS AÚN (titulo, icono, descripción)
     * @param String $ruta Indica la ruta del archivo a borrar (ej: '../archivos/')
     * @param String $nom Nombre del archivo (ej: 'imagen.jpg')
     * @return int $codError Un número según el error presentado
     */
    $codError = 0;
    // Si el archivo no existe, devuelve error 1
    if (!file_exists($ruta.$nom)) $codError = 1;
    // Si la ruta es una carpeta, devuelve error 2
    // Nota: Evito borrar carpetas, sino debería haber función separada y permisos para eso, tema para largo...
    if ($codError==0 && !is_file($ruta.$nom)) $codError = 2;
    // Si el servidor no tiene permiso para borrar archivo, devuelve error 3
    if ($codError==0 && !is_writable($ruta.$nom)) $codError = 3;
    // Hace operación de borrado, pero si el mismo retorna falso, devuelve error 4
    if ($codError==0 && !unlink($ruta.$nom) ) $codError = 4;

    return $codError;
}

public function errorBorrado($codError, $nom) {
    /* Manejo de errores durante el borrado, mostrando texto con el nombre del archivo
     * Funciona similar a errorCarga(), pero este no trae el arreglo de $_FILES sino los items sueltos:
     * @param int $codError El código numérico del error a transcribir
     * @param String $nom Trae el nombre de un archivo
     * @return String $mensaje El mensaje de error generado
     */
    switch ($codError) {
        case 0: $mensaje = "Archivo ".$nom." borrado con éxito";
            break;
        case 1: $mensaje = "El archivo ".$nom." no existe";
            break;
        case 2: $mensaje = "El elemento ".$nom." es una carpeta";
            break;
        case 3: $mensaje = "El servidor ".$nom." no tiene permiso para borrar el archivo";
            break;
        case 4: $mensaje = "Hubo un problema al intentar borrar ".$nom;
            break;
        default: $mensaje = "Motivo desconocido durante el borrado";
            break;
    }
    return $mensaje;
}

// --- Funciones de lectura ---

public function datosArchivo($archivo) {
    /* Muestra los detalles de un archivo cargado, para ser mostrado en la página web
     * @param Array $archivo Trae información de UN archivo (ej: $_FILES['archivoIng'])
     * @var String $nombre El nombre del archivo
     * @return String $mensaje El mensaje generado con los datos
     */
    $nombre = $archivo['name'];
    $mensaje =  "Nombre: " . $nombre . "<br>";

    // Se usa regex para buscar el tipo según extensión, y concatenar a la info de detalles
    switch ($nombre) {
        case preg_match('/(.*?)\.(pdf)$/i', $nombre) ? true : false:
            $mensaje .=  "Tipo: Documento PDF<br>";
            break;
        case preg_match('/(.*?)\.(docx|doc|odt|rtf|docm|dot|dotx|dotm)$/i', $nombre) ? true: false:
            $mensaje .=  "Tipo: Documento de texto<br>";
            break;
        case preg_match('/(.*?)\.(xls|xlsx|xlsm|xltx|xlt|ods)$/i', $nombre) ? true: false:
            $mensaje .=  "Tipo: Planilla de cálculo<br>";
            break;
        case preg_match('/(.*?)\.(txt|css|js|ini)$/i', $nombre) ? true : false:
            $mensaje .=  "Tipo: Archivo de texto plano<br>";
            break;
        case preg_match('/(.*?)\.(jpg|png|gif|bmp|tiff|jpeg|webp)$/i', $nombre) ? true: false:
            $mensaje .=  "Tipo: Imagen<br>";
            break;
        case preg_match('/(.*?)\.(zip|rar|7z|tar|gz|bin)$/', $nombre) ? true: false:
            $mensaje .=  "Tipo: Comprimido<br>";
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

public function mostrarIcono($nombre) {
    /* Según un nombre de archivo, elige un ícono acorde a la extensión
     * @param String $nombre 
     * @return String $icono El código de icono correspondiente a Font Awesome
     */
    switch ($nombre) {
        case preg_match('/(.*?)\.(jpg|png|gif|bmp|tiff|jpeg|webp)$/i', $nombre) ? true: false:
            $icono = "fas fa-file-image"; // #icono en amarchivo.php = img
            break;
        case preg_match('/(.*?)\.(zip|rar|7z|tar|gz|bin)$/i', $nombre) ? true: false:
            $icono = "fas fa-file-archive"; // #icono en amarchivo.php = zip
            break;
        case preg_match('/(.*?)\.(docx|doc|odt|rtf|txt|docm|dot|dotx|dotm)$/i', $nombre) ? true: false:
            $icono = "fas fa-file-word"; // #icono en amarchivo.php = doc
            break;
        case preg_match('/(.*?)\.(pdf)$/i', $nombre) ? true : false:
            $icono = "fas fa-file-pdf"; // #icono en amarchivo.php = pdf
            break;
        case preg_match('/(.*?)\.(xls|xlsx|xlsm|xltx|xlt|ods)$/i', $nombre) ? true: false:
            $icono = "fas fas fa-file-excel"; // #icono en amarchivo.php = xls
            break;
        default: $icono = "fas fa-file";
            break;
        }
    return $icono;
}

public function listarCarpetas($ruta) {
    /* Utiliza función scandir de PHP para mostrar las carpetas almacenadas
     * @see https://www.php.net/manual/es/function.scandir.php
     * @param String $ruta La carpeta seleccionada donde listar
     * @return Array $soloCarpetas La lista de carpetas entera en orden ascendente
     */
    $soloCarpetas = array();
    
    

    // Le saco los puntos molestos que no uso:
    $todosArchivos = array_diff(scandir($ruta), array('..', '.'));

    // Si scandir() retorna falso, quiere decir que la ruta señalada no es una carpeta
    if ($todosArchivos != false) {
        // Recupero solo carpetas:
        foreach($todosArchivos as $esteArchivo){
            if( is_dir($ruta.$esteArchivo) ) {
                $soloCarpetas[] = $esteArchivo;
            }
        }
    } else {
        $soloCarpetas = false;
    }
    
    return $soloCarpetas;
}

public function listarArchivos($ruta) {
    /* Utiliza función scandir de PHP para mostrar los archivos almacenados
     * @see https://www.php.net/manual/es/function.scandir.php
     * @param String $ruta La carpeta seleccionada donde listar
     * @var Array $todosArchivos El arreglo sin filtrar
     * @return Array $soloArchivos La lista de archivos entera en orden ascendente
     */
    $soloArchivos = array();
    
    // Le saco los puntos molestos que no uso
    $todosArchivos = array_diff(scandir($ruta), array('..', '.'));

    // Recupero solo archivos
    foreach($todosArchivos as $esteArchivo){
        if( is_file($ruta.$esteArchivo) ) {
            $soloArchivos[] = $esteArchivo;
        }
    }
    
    return $soloArchivos;
}

} // -- Fin clase control_archivos --
?>