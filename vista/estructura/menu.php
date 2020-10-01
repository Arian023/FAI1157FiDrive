<!-- Comienzo menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border rounded shadow-lg">
    <a class="navbar-brand" href="../vista/index.php" title="Arian Acevedo - FAI1157">
        <img src="../vista/img/logo.png" max-width="100" height="40" alt="FiDrive">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button> <!-- Fin botón desplegable en pantallas chicas-->

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Archivo
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="../vista/amarchivo.php">Alta o modificación</a>
            <a class="dropdown-item" href="../vista/compartirarchivo.php">Compartir archivo</a>
            <a class="dropdown-item" href="../vista/eliminararchivocompartido.php">Dejar de compartir archivo</a>
            <a class="dropdown-item" href="../vista/eliminararchivo.php">Eliminar archivo</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item disabled" href="../vista/contenido.php" aria-disabled="true">Ver contenido</a>
            <a class="dropdown-item disabled" href="../vista/compartidos.php" aria-disabled="true">Mostrar compartidos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../vista/explorar.php" id="navbarDropdown" role="button" title="Ver otros archivos">
            Explorar proyecto
            </a>
        </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" name="buscador" id="TextoABuscar" type="search" placeholder="Buscar en esta página" aria-label="Search" onkeydown="leerEnterB(event)"title="Seleccionar la coincidencia">
            <button class="btn btn-outline-light my-2 my-sm-0" onclick="buscarEnPagina( document.getElementById('TextoABuscar').value )" type="button" id=Buscar title="Seleccionar la coincidencia">Buscar</button>
        </div>
    </div> <!-- Fin contenido desplegable en pantallas chicas-->
</nav> <!-- Fin menú de navegación -->