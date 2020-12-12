<!-- Comienzo menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border rounded shadow-lg">
    <a class="navbar-brand" href="../index/index.php" title="Arian Acevedo - FAI1157">
        <img src="../../vista/img/logo.png" max-width="100" height="40" alt="FiDrive">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContenido" 
        aria-controls="navbarContenido" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button> <!-- Fin botón desplegable en pantallas chicas-->

    <div class="collapse navbar-collapse" id="navbarContenido">
        <ul class="navbar-nav mr-auto">
        <?php // Menú para usuarios registrados
            if ( null != $sesion->getuslogin() ) {
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Menú
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="../index/amarchivo.php">
                    <i class="fas fa-upload mr-2"></i>Nuevo archivo</a>
                <a class="dropdown-item" href="../index/contenido.php">
                    <i class='fas fa-folder mr-2'></i>Mostrar listado</a>
                <a class="dropdown-item" href="../index/compartidos.php">
                    <i class='fas fa-share-alt-square mr-2'></i>Mostrar compartidos</a>
            </div>
            <!-- <div class="dropdown-divider"></div> -->
        </li>
        <?php } // Fin menú de opciones para registrados

            // Opción para administrador:
            if ( null != $sesion->getuslogin() && $sesion->esadmin() ) {
        ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Admin
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="../index/registro.php">
                    <i class="fas fa-user-plus mr-2"></i>Nuevo usuario</a>
                <a class="dropdown-item" href="../index/listausuarios.php">
                    <i class="fas fa-users mr-2"></i>Mostrar usuarios</a>
                <a class="dropdown-item" href="../../explorar.php">
                    <i class="fas fa-project-diagram mr-2"></i>Explorar proyecto</a>
            </div>
        </li>
        <?php
            } // Fin opción para administrador
        ?>
        </ul>
        <?php
        // Salen botones login si no hay usuario activo:
            if ( null == $sesion->getuslogin() ) { 
        ?>
        <a class="btn btn-outline-info col-md-2 mx-2" href="../index/registro.php">
            <i class="fas fa-user-plus mx-1"></i>Registrarse
        </a>
        <!-- Botón para activar modal login -->
        <button type="button" class="btn btn-info col-md-2 mr-4" data-toggle="modal" data-target="#mostrarLogin">
            <i class="fas fa-sign-in-alt mx-1"></i>Iniciar sesión
        </button>
        <!-- Comienzo div modal login -->
        <div class="modal fade" id="mostrarLogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Iniciar sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name=login id=login method=post action="../action/verificarLogin.php" novalidate> <!-- onsubmit="claveSegura()" -->
                        <!--- Incompatible en diseño con validator, parcheado con input de ancho fijo: -->
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input type=text name="uslogin" id="uslogin" placeholder="Usuario" class="form-control" style="width: 300px">
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input type=password name="usclave" id="usclave" placeholder="Contraseña" class="form-control" style="width: 300px">
                        </div>
                        <!-- Manda link de página actual para regresar luego de ingresar credenciales -->
                        <input type=hidden name="enlaceVolver" value=<?=$_SERVER['REQUEST_URI']?>>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type=submit class="btn btn-info" name=ingresar value="Ingresar" form=login>
                </div>
                </div>
            </div>
        </div> <!-- Fin div modal login -->
            <?php } // Fin botones login

            // Sale nombre del usuario y botón cerrar sesión si hay una activa:
            if ( null != $sesion->getusnombre() ) { 
            echo "<h5 class='btn btn-outline-light font-weight-bold col-md-2 m-1 disabled'>¡Hola, ".$sesion->getusnombre()."!</h5>"; ?>
        <a class="btn btn-outline-danger col-md-2 mx-2" href="../action/salir.php">
            <i class="fas fa-sign-out-alt mx-1"></i>Salir
        </a>
        <?php
            } // Fin botón cerrar sesión
        ?>

        <div class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" name="buscador" id="TextoABuscar" type="search" placeholder="Buscar en esta página" 
                aria-label="Search" onkeydown="leerEnterB(event)"title="Seleccionar la coincidencia">
            <button class="btn btn-outline-light my-2 my-sm-0" onclick="buscarEnPagina( document.getElementById('TextoABuscar').value )" 
                type="button" id=Buscar title="Seleccionar la coincidencia">Buscar</button>
        </div>
    </div> <!-- Fin contenido desplegable en pantallas chicas-->
</nav> <!-- Fin menú de navegación -->

<!-- Se muestra aviso de usuario o clave incorrecto si corresponde -->
<?php if(isset($_GET['login'])) {
    switch ($_GET['login']) {
        case 0: echo "<div class='alert alert-success alert-dismissible fade show' role=alert>
        <i class='fas fa-sign-in-alt mx-2'></i>
        Ya iniciaste sesión, ¡bienvenido de nuevo!
        <button type=button class=close data-dismiss=alert aria-label=Close>
        <span aria-hidden=true>&times;</span></button>
        </div>";
            break;
        case 1: echo "<div class='alert alert-danger alert-dismissible fade show' role=alert>
        El usuario o contraseña no son correctos. Intente nuevamente.
        <button type=button class=close data-dismiss=alert aria-label=Close>
        <span aria-hidden=true>&times;</span></button>
        </div>";
            break;
        case 2: echo "<div class='alert alert-success alert-dismissible fade show' role=alert>
        <i class='fas fa-sign-out-alt mx-2'></i>
        Ya cerraste la sesión, ¡hasta pronto!
        <button type=button class=close data-dismiss=alert aria-label=Close>
        <span aria-hidden=true>&times;</span></button>
        </div>";
            break;
        case 3: echo "<div class='alert alert-danger alert-dismissible fade show' role=alert>
        Usuario no autorizado. Por favor ingresa con el botón mostrado arriba.
        <button type=button class=close data-dismiss=alert aria-label=Close>
        <span aria-hidden=true>&times;</span></button>
        </div>";
            break;
        default: echo "<div class='alert alert-info alert-dismissible fade show' role=alert>
        <i class='fas fa-question-circle mx-2'></i>
        Resultado desconocido de login. <i>¿Intentaste cambiar el parámetro en el URL?</i>
        <button type=button class=close data-dismiss=alert aria-label=Close>
        <span aria-hidden=true>&times;</span></button>
        </div>";
            break;
    }
    
}
?>