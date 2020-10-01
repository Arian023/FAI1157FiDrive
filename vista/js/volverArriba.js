/* Todo lo siguiente hace funcionar el botón para volver al principio 
Fuente: https://bootsnipp.com/snippets/ZXdy2
*/

/*
var boton = $('#volverArriba');

$(window).scroll(function() {
  if ($(window).scrollTop() > 300) {
    boton.addClass('mostrar');
  } else {
    boton.removeClass('mostrar');
  }
});

boton.on('click', function(e) {
  e.preventDefault();
  $('html, body').animate({scrollTop:0}, '300');
});
*/

/* 
$(document).ready(function(){
  $('body').append('<div id="volverArriba" class="btn btn-info"><span class="fas fa-chevron-up"></span> Volver arriba</div>');
  $(window).scroll(function () {
  if ($(this).scrollTop() != 0) {
    $('#toTop').fadeIn();
  } else {
    $('#toTop').fadeOut();
  }
}); 
$('#toTop').click(function(){
    $("html, body").animate({ scrollTop: 0 }, 600);
    return false;
});
});
*/

// Se activa el botón al desplazarse 100px de la página, se oculta al regresar:
window.onscroll = function() {aparecerBoton()};

function aparecerBoton() {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        document.getElementById("volverArriba").style.display = "block";
    } else {
        document.getElementById("volverArriba").style.display = "none";
    }
}

// Se activa al cliquear botón para ir al principio de la página:
function irArriba() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

/*
Este tutorial no me funcionó pero es útil: https://www.templatemonster.com/blog/back-to-top-button-css-jquery/
Fuente: https://codepen.io/matthewcain/pen/ZepbeR

Otra opción: https://bootsnipp.com/snippets/QbNWX
*/