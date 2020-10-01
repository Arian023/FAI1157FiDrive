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
// @param {String} color
$('#descripcion').summernote('backColor', 'red');

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
            },
            stringLength: {
                min: 6,
                max: 30,
                message: 'La contraseña debe tener entre 6 y 30 caracteres. '
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

// Habilitar campo clave - Fuente: https://stackoverflow.com/a/15140254
document.getElementById('proteger').onchange = function() {
    document.getElementById('clave').disabled = !this.checked;
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
