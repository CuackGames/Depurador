function myFunction() {
    // document.getElementById('boton_crear').disabled = false;
    var contenedor = document.getElementById('contenedor_carga');
    contenedor.style.visibility = 'visible ';
    contenedor.style.opacity = '1';

}

window.onload = function() {
    var contenedor = document.getElementById('contenedor_carga');
    contenedor.style.visibility = 'hidden';
    contenedor.style.opacity = '0';
}