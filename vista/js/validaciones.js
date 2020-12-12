/* --- Validaciones usando ../js/bootstrap/bootstrapValidator.js ---
 * Arian Acevedo - Leg. FAI 1157
 * Programación Web Dinámica 2020 - UNCo Neuquén
 */

// Función para usar Bootstrap 4 el pulsar submit
(function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

// Llamar al editor de texto en los textarea - Fuente: https://summernote.org/
$(document).ready(function() {
    $('#descripcion').summernote({
        lang: 'es-ES',
        tabsize: 2,
        height: 100
    });
  });

// --- Alta o modificación: ---
$('#amarchivo').bootstrapValidator({
    feedbackIcons: {
        valid: 'fas fa-check',
        invalid: 'fas fa-times',
        validating: 'fas fa-refresh'
    },
    fields: {
        titulo: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar un título descriptivo del archivo. '
            },
            stringLength: {
                min: 3,
                max: 150,
                message: 'El título debe ser mayor a 3 caracteres. '
            }
        }
        },
        archivoIng: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un archivo antes de enviar. '
            },
            file: {
                maxSize: 2000000,
                message: 'El archivo debe ser de tipo documento y tamaño menor a 2MB. '
            }
        }
        },
        descripcion: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar una descripción. '
            }
        }
        }, /* Campo oculto, se selecciona automáticamente:
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        }, */
        icono: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un icono. '
            }
        }
        }
    }
});
$(document).ready(function () {
    $('#amarchivo').confirmarSalir('');
});

function elegirIcono() {
    // Lee el nombre del archivo elegido (antes de ser enviado) y marca automáticamente el ícono sugerido
    var archivo = document.getElementById("archivoIng").value;
    var imagen = /(.*?)\.(jpg|png|gif|bmp|tiff|jpeg|webp)$/;
    var comprimido = /(.*?)\.(zip|rar|7z|tar|gz|bin)$/;
    var documento = /(.*?)\.(docx|doc|odt|rtf|txt|docm|dot|dotx|dotm)$/;
    var pdf = /(.*?)\.(pdf)$/;
    var planilla = /(.*?)\.(xls|xlsx|xlsm|xltx|xlt|ods)$/;
    // Método match(regex) devuelve arreglo, pero se compara con nulo para ver si hay coincidencia
    if(archivo.match(imagen) != null){
        // alert("Imagen seleccionada");
        document.getElementById("img").checked = true;
    } else if(archivo.match(comprimido) != null) {
        // alert("comprimido seleccionado");
        document.getElementById("zip").checked = true;
    } else if(archivo.match(documento) != null) {
        // alert("documento seleccionado");
        document.getElementById("doc").checked = true;
    } else if(archivo.match(pdf) != null) {
        // alert("pdf seleccionado");
        document.getElementById("pdf").checked = true;
    } else if(archivo.match(planilla) != null) {
        // alert("planilla seleccionada");
        document.getElementById("xls").checked = true;
    } else {
        // alert("No se eligió archivo");
    }
  }

// --- Compartir archivo: ---
$('#compartir').bootstrapValidator({
    feedbackIcons: {
        valid: 'fas fa-check',
        invalid: 'fas fa-times',
        validating: 'fas fa-refresh'
    },
    fields: {
        titulo: {
        validators: {
            notEmpty: {
                message: 'El archivo debe estar seleccionado desde la página Contenido. '
            }
        }
        },
        clave: {
        validators: {
            notEmpty: {
                message: 'Si elige proteger, debe ingresar una contraseña. '
            }/* Reemplazado por plugin validarClave.js ,
            stringLength: {
                min: 6,
                max: 30,
                message: 'La contraseña debe tener entre 6 y 30 caracteres. '
            }*/
        }
        } /* Campo oculto, se selecciona automáticamente:
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        } */
    }
});
$(document).ready(function () {
    $('#compartir').confirmarSalir('');
});

function generarLink() {
    /* @see Utiliza método encontrado en: https://debugpointer.com/create-md5-hash-in-javascript/
     * Toma los datos del formulario y genera un enlace con un hash md5 mostrado en el último campo del formulario
     */
    // Ya no es necesario al tomar nombre desde ruta: var nombre = document.getElementById("nombre").value;
    var ruta = document.getElementById("ruta").value;
    var cantDias = document.getElementById("cantDias").value;
    var cantDescargas = document.getElementById("cantDescargas").value;
    var fechaHoraActual = new Date();

    // Recorto los puntos y barras ( ../../ ) de ruta relativa, para obtener una ruta absoluta correcta
    ruta = ruta.substring(6);

    // Si la cantidad de días compartidos o la de descarga son nulas, el hash debe ser un número fijo
    // Nota: Buscar mejor forma de obtener ruta actual del proyecto, se asume carpeta mencionada a continuación
    if ( cantDias == 0 || cantDescargas == 0) {
        document.getElementById("enlace").value = "http://localhost/FAI1157FiDrive/"+ruta+"?compartido="+9007199254740991;
    } else {
        // Se genera hash usando fecha y hora actual, asumiendo que no se generará el mismo hash en otro día con los mismos cantDias y cantDescargas
        var hash = md5(fechaHoraActual+cantDias+cantDescargas);
        document.getElementById("enlace").value = "http://localhost/FAI1157FiDrive/"+ruta+"?compartido="+hash;
    }
}

// --- Dejar de compartir archivo: ---
$('#nocompartir').bootstrapValidator({
    feedbackIcons: {
        valid: 'fas fa-check',
        invalid: 'fas fa-times',
        validating: 'fas fa-refresh'
    },
    fields: {
        nombre: {
        validators: {
            notEmpty: {
                message: 'El archivo debe estar seleccionado desde la página Contenido. '
            }
        }
        },
        descripcion: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar el motivo. '
            }
        }
        } /* Campo oculto, se selecciona automáticamente:
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        } */
    }
});
$(document).ready(function () {
    $('#nocompartir').confirmarSalir('');
});

// --- Eliminar archivo: ---
$('#eliminar').bootstrapValidator({
    feedbackIcons: {
        valid: 'fas fa-check',
        invalid: 'fas fa-times',
        validating: 'fas fa-refresh'
    },
    fields: {
        nombre: {
        validators: {
            notEmpty: {
                message: 'El archivo debe estar seleccionado desde la página Contenido. '
            }
        }
        },
        descripcion: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar el motivo. '
            }
        }
        } /* Campo oculto, se selecciona automáticamente:
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        } */
    }
});
$(document).ready(function () {
    $('#eliminar').confirmarSalir('');
});

// --- Iniciar sesión: ---
/*
$('#login').bootstrapValidator({
    feedbackIcons: {
        valid: 'fas fa-check',
        invalid: 'fas fa-times',
        validating: 'fas fa-refresh'
    },
    fields: {
        uslogin: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar su nombre de usuario. '
            },
            stringLength: {
                min: 2,
                max: 150,
                message: 'El usuario debe ser mayor a 2 caracteres. '
            }
        }
        },
        usclave: {
        validators: {
            notEmpty: {
                message: 'Introduzca una contraseña. '
            },
            stringLength: {
                min: 2,
                max: 150,
                message: 'La contraseña debe tener al menos 2 caracteres. '
            },
            different: {
                field: 'uslogin',
                message: 'La contraseña no puede ser igual al nombre de usuario. '
            }
        }
        }
    }
}); */

// --- Registrar usuario nuevo o iniciar sesión: ---
$('#registro, #login').bootstrapValidator({
    feedbackIcons: {
        valid: 'fas fa-check',
        invalid: 'fas fa-times',
        validating: 'fas fa-refresh'
    },
    fields: {
        usnombre: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar su nombre. '
            },
            stringLength: {
                min: 2,
                max: 150,
                message: 'El nombre debe ser mayor a 2 caracteres. '
            }
        }
        },
        usapellido: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar su apellido. '
            },
            stringLength: {
                min: 2,
                max: 150,
                message: 'El apellido debe ser mayor a 2 caracteres. '
            }
        }
        },
        uslogin: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar su nombre de usuario. '
            },
            stringLength: {
                min: 2,
                max: 150,
                message: 'El usuario debe ser mayor a 2 caracteres. '
            }
        }
        },
        usclave: {
        validators: {
            notEmpty: {
                message: 'Introduzca una contraseña. '
            },
            identical: {
                field: 'confirmarclave',
                message: 'La contraseña y su confirmación no son idénticas. '
            },
            different: {
                field: 'uslogin',
                message: 'La contraseña no puede ser igual al nombre de usuario. '
            }/* Reemplazado por plugin validarClave.js ,
            stringLength: {
                min: 6,
                max: 30,
                message: 'La contraseña debe tener entre 6 y 30 caracteres. '
            }*/
        }
        },
        confirmarclave: {
        validators: {
            notEmpty: {
                message: 'Debe confirmar la contraseña. '
            },
            identical: {
                field: 'usclave',
                message: 'La contraseña y su confirmación no son idénticas. '
            }
        }
        }
    }
});
$(document).ready(function () {
    $('#registro').confirmarSalir('');
});

function claveSegura() {
    // Toma la clave ingresada por usuario y la modifica en md5
    var usclave = document.getElementById("usclave").value;
    usclave = md5(usclave);
    document.getElementById("usclave").value = usclave;
    alert('Se cifró clave con md5: '+usclave);
}

/*
    var confirmarclave = document.getElementById("confirmarclave").value;
    if(null != confirmarclave) {
        confirmarclave = md5(confirmarclave);
    }

Opción alternativa mediante Jquery:

$('#login').submit(function() { 
    var claveIng = $('#usclave').val();
    $('#usclave').val(md5(claveIng));
    $('#confirmarclave').val(md5(claveIng));
    alert('Se cifró clave con md5');
    return false; // return false cancela formulario
});

$('#registro').submit(function() { 
    var claveIng = $('#usclave').val();
    $('#usclave').val(md5(claveIng));
    $('#confirmarclave').val(md5(claveIng));
    alert('Se cifró clave con md5');
    return false; // return false cancela formulario
});
*/