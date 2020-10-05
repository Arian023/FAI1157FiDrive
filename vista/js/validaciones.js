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
        nombre: {
        validators: {
            notEmpty: {
                message: 'Debe ingresar el nombre del archivo. '
            },
            stringLength: {
                min: 3,
                message: 'El nombre debe ser mayor a 3 caracteres. '
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
        },
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        },
        icono: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un icono. '
            }
        }
        }
    }
});

function elegirIcono() {
    // Lee el nombre del archivo elegido (antes de ser enviado) y marca automáticamente el ícono sugerido
    var archivo = document.getElementById("archivoIng").value;
    var imagen = /(.*?)\.(jpg|png|gif|bmp|tiff|jpeg|webp)$/;
    var comprimido = /(.*?)\.(zip|rar|7z||tiff|jpeg)$/;
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
        nombre: {
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
        },
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        }
    }
});

// Habilitar campo clave - Fuente: https://stackoverflow.com/a/15140254
document.getElementById('proteger').onchange = function() {
    document.getElementById('clave').disabled = !this.checked;
    // Si está desmarcado, se oculta campo y no se valida
    if (document.getElementById('clave').disabled) {
        document.getElementById('validarClave').style.display = "none";
    } else {
        document.getElementById('validarClave').style.display = "block";
    }
};

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
        },
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        }
    }
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
        },
        usuario: {
        validators: {
            notEmpty: {
                message: 'Debe seleccionar un usuario. '
            }
        }
        }
    }
});
