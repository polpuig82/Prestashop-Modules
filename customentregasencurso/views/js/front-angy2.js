/**
 * 2007-2018 PrestaShop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2018 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 *
 * Don't forget to prefix your containers with your own identifier
 * to avoid any conflicts with others containers.
 */




function desplegarContenidoCesta(idElemento) {
    if (!(document.getElementById('contentcesta ' + idElemento).classList.contains('active')))
        document.getElementById('contentcesta ' + idElemento).classList.add('active');
    else
        document.getElementById('contentcesta ' + idElemento).classList.remove('active');
}




function desplegarcarrouselProductoCesta(idElemento) {
    //FIX error JS
    if ($('div[id="mycarouselProductoCesta ' + idElemento + '"]').length > 0) {

        var mycarouselProductoCesta = $('div[id="mycarouselProductoCesta ' + idElemento + '"]');

        //FIX elementos con IDs repetidos
        if ($('div[id="mycarouselProductoCesta ' + idElemento + '"]').length > 1) {
            mycarouselProductoCesta = $(event.target).parents(".listado").find('div[id="mycarouselProductoCesta ' + idElemento + '"]');
        }

        if (!($(mycarouselProductoCesta).hasClass('active')))
            $(mycarouselProductoCesta).addClass('active');
        else
            $(mycarouselProductoCesta).removeClass('active');

    } else {
        //FIX error construcción sliders, cerramos los sliders
        $('div[id^="mycarouselProductoCesta"]').removeClass('active');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los divs cuyo id empieza por "infoCambios_"
    let divsInfo = document.querySelectorAll("[id^='infoCambios_']");
    divsInfo.forEach((div) => {
        // Extraer el obId del id del div (se asume que el id tiene el formato "infoCambios_{obId}")
        let parts = div.id.split("_");
        let obId = parts[1]; // O ajustar según tu formato
        // Obtener el valor de 'num' desde el atributo data-num
        let num = div.getAttribute("data-num") || "";
        // Llamar a la función para actualizar la info de cambios para este pedido
        actualizarInfoCambios(obId, limiteCambios, num);
    });
});
function preloaderCarousel() {
    // Captamos los carouseles
    const collection = document.querySelectorAll('[id^=mycarousel]');

    for (product of collection) {
        product.style.display = "block";

    }

    // Captamos los carouseles
    const collection2 = document.querySelectorAll('[id^=mycarouselProductoCesta]');

    for (product of collection2) {
        product.style.display = "none";

    }

}

window.onload = preloaderCarousel;
window.onload = actualizarInfoCambios;
// Comprueba en cada inicio de página si tiene que mostrar un mensaje temporal
// window.onload = activaMensajeTemporal();





function selectItemCustomMyAccount(posicion, idCambio, general, contadorLinea, padre, linea) {
    var nodoCesta = window["arrayAlternativo" + general + linea];
    var espacio = "&nbsp";
    idElemento = idCambio + "-" + general + "-" + contadorLinea;
    idDesh = 'precognis' + general + '-' + contadorLinea + '-' + linea;
    funcion = 'deshacerItemEC("' + idDesh + '","' + idCambio + '","' + linea + '","' + general + '","' + idElemento + '","' + padre + '","' + contadorLinea + '")';
    totalPedidosEnCurso = window["cambiosCesta" + general + linea];
    if (totalPedidosEnCurso != 6) {
        capaaCambiar = document.getElementById(idDesh);
        capaaCambiar.innerHTML = '' +
            '<div className="image imgCesta"><img src="' + nodoCesta[posicion].image + '"></div>' +
            '<div><p class="titulCesta">' + nodoCesta[posicion].name + '</p>' +
            '<a class="btn btn-terciary" onclick=' + funcion + ' style="color: #9f3c30!important;"><img src="/img/cms/deshacer.png" style="width:20px; padding: 0.5rem 0.7rem;">' + espacio + 'DESHACER</a>' +
            '            <input type="hidden" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + nodoCesta[posicion].id + '">' +
            '        </a></div>';
        window["cambiosCesta" + general + linea] = parseFloat(totalPedidosEnCurso) + parseFloat(1);
        comprobarTotal('contentcesta ' + padre + '-' + general, window["cambiosCesta" + general + linea]);
        desplegarcarrouselProductoCesta(idElemento);
        //15-06-2022 cambiarId(linea,idCambio,general,nodoCesta[posicion].id,padre);
        cambiarId(contadorLinea, idCambio, general, nodoCesta[posicion].id, padre, general);
    }

}

function deshacerItemEC(idDesh, idCambio, posicion, general, idElemento, padre, contadorLinea) {
    posicion = posicion - 1;
    funcion = 'desplegarcarrouselProductoCesta("' + idElemento + '")';
    capaaCambiar = document.getElementById(idDesh);
    //traer Datos

    $.ajax({
        url: urlDatoProducto,
        data: { idProduct: idCambio },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (response) {

            capaaCambiar.innerHTML = '' +
                '<div className="image imgCesta"><img src="' + response.image + '"></div>' +
                '<div><p class="titulCesta">' + response.name + '</p>' +
                '<a class="btn btn-terciary definido" onClick=' + funcion + ' style="display: flex; color: #46735C!important; padding: 0.5rem 0.7rem;">' +
                '<img src="/img/cms/cambiar.png" style="width:20px;">&nbspCAMBIAR' +
                '</a></div>';
            posicion = posicion + 1;
            window["cambiosCesta" + general + posicion] = parseFloat(window["cambiosCesta" + general + posicion]) - parseFloat(1);
            comprobarTotal('contentcesta ' + padre + '-' + general, window["cambiosCesta" + general + posicion]);
            cambiarId(contadorLinea, idCambio, general, idCambio, padre, general);

        },
        error: function (error) {

        }
    });
}

function cambiarId(posicion, idCambio, general, idNuevo, padre, linea = 0) {
    posicion = posicion - 1;
    var arrayPedido = window["arrayPedido" + general];
    for (let value of arrayPedido) {
        if (value.id == padre) {
            if (arrayPedido.length > 1) {
                arrayPedido[linea - 1].lista[posicion].id = idNuevo;
                arrayPedido[linea - 1].lista[posicion].image = '';
                arrayPedido[linea - 1].lista[posicion].name = '';
            } else {
                value.lista[posicion].id = idNuevo;
                value.lista[posicion].image = '';
                value.lista[posicion].name = '';
            }
        }
    }
    //let director = arrayPedido.find(member => member.id === idnativo);
    //console.log(director);
}

function comprobarTotal(id, totalPedidosEnCurso) {
    //p=numElementos(cestaDefinida);
    if (totalPedidosEnCurso == control) {
        const collection = document.getElementById(id).getElementsByClassName("definido");
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "none";
        }
    }
    else {

        const collection = document.getElementById(id).getElementsByClassName("definido");
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "flex";
        }
    }


}


function enviarCambios(num, obId, lineId) {
    // alert("Entrando en enviarCambios, con la variable "+ obId);
    var arrayPedido = window["arrayPedido" + num];
    // let confirmAction = confirm("¿Estás seguro?");
    // if (confirmAction) {
    $.ajax({
        url: urlUpdate,
        data: { datosPedido: arrayPedido, numPedido: num, obId: obId, lineId: lineId },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (response) {
            //codigo de exito
            $('.spinner-container').hide(); // lo primero, escondemos el spinner
            activaMensajeTemporal(); // Activamos el mensaje temporal
            // Utilizamos local storage para almacenar el flag de activación del mensaje
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
            //location.reload();
        },
        error: function (error) {
            $('.spinner-container').hide(); // lo primero, escondemos el spinner
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
            //codigo error
            // alert("Error en enviarCambios");
        }
    });
    // } else {

    // }
}

// Método para activar el mensaje temporal
function activaMensajeTemporal(mensaje = 'Los cambios se han aplicado correctamente') {

    // validamos si existe en el localstorage la llave mensaje_temporal
    if (localStorage.getItem("mensaje_temporal") === "1") {

        // si existe, mostramos el mensaje de confirmación
        $("#hideDiv").css("height", "150px ");
        $(".mensaje-retorno").html(localStorage.getItem("mensaje_temporal_contenido"));
        $("#hideDiv").show();
        setTimeout(function () { $("#hideDiv").fadeOut(1500); }, 5000);

        // deshabilitamos el flag
        localStorage.setItem("mensaje_temporal", 0);
        localStorage.setItem("mensaje_temporal_contenido", "");
    }

}

// Método para actualizar el precio de la cesta
function actualizaImpactoPrecioCesta(arrayPedido, padre, impactoPrecio, num = 0, linea = 0) {
    if ($.isArray(arrayPedido)) {
        var precio_cesta_old = $("#lineaPedido" + num + parseInt(linea)).find(".lineaproduct").find(".precio-lineaproduct.cesta[data-id-product=" + padre + "]").html();
        var precio_cesta_new = 0;

        $(arrayPedido).each(function (index, element) {

           if (parseInt(element.id) == parseInt(padre)) {

                let precioAntiguo = precio_cesta_old.replace(',', '.');
                let impacto = impactoPrecio.toString().replace(',', '.');

                precio_cesta_new = (parseFloat(precioAntiguo) + parseFloat(impacto)).toFixed(2);
                                let precio_mostrar = precio_cesta_new.replace('.', ',');

                $("#lineaPedido" + num + parseInt(linea)).find(".lineaproduct").find(".precio-lineaproduct.cesta[data-id-product=" + padre + "]").html(precio_mostrar);
                arrayPedido[linea - 1]["grossUnitPrice"] = precio_cesta_new;

            }

        });

    }
}

function addItem(idProduct, qty, numPedido, country) {
    var cantidad = document.getElementById(qty).value;
    $.ajax({
        url: urlDatoProducto,
        data: { idProduct: idProduct, country: country },
        method: 'post', // En este caso
        dataType: 'json',
        success: function (response) {
            // Código de éxito
            var arrayPedido = window["arrayPedido" + numPedido] || []; // Inicializa arrayPedido si no existe
            annadirTramo(response, cantidad, numPedido, arrayPedido.length);

            var nodo = {
                id: idProduct,
                quantity: cantidad,
                image: response.image,
                name: response.name,
                active: response.active,
                grossUnitPrice: response.grossUnitPrice
            };
            arrayPedido.push(nodo);
            window["arrayPedido" + numPedido] = arrayPedido; // Guarda el arrayPedido actualizado

            var totalPedido = parseFloat(document.getElementById("total" + numPedido).innerText.slice(7, -2));
            totalPedido = (totalPedido + parseFloat(response.grossUnitPrice) * parseFloat(cantidad)).toFixed(2);
            document.getElementById("total" + numPedido).innerText = "TOTAL: " + totalPedido + " €";
        },
        error: function (error) {
            // Código de error
        }
    });
}

/**
 * Función evento añadir a la cesta
 * @param {integer} productId 
 * @param {integer} qty 
 * @param {string} obId 
 */
function addItemToOrder(productId, qty, num, obId, grossUnitPrice) {
    $('.spinner-container').show();
    var hideButton_Cashback = document.getElementById('hideButton_Cashback');
    if (hideButton_Cashback) {
        hideButton_Cashback.onclick = function () {
            return false;
        };
    }
    var cantidad = document.getElementById(qty).value;
    var arrayPedido = window["arrayPedido" + num] || []; // Inicializa arrayPedido si no existe

    var pedidoConId2010 = arrayPedido.find(function (pedido) {
        return pedido.id === '2010' || pedido.id === 2010; // Cambiar a pedido.productid si es necesario , se compara con "" y sin porque array pedido con ajax lo pone con ""
    });
    // console.log(arrayPedido);

    if (pedidoConId2010) {
        $('#modalAnadirProductCashback').modal('show');
        console.log("Hay un pedido con productid igual a 2010. No se puede continuar.");
        $('.spinner-container').hide();
        return; // No ejecutar la función si se encuentra el pedido
    }

    $.ajax({
        type: 'POST',
        url: urlAjaxControllerDeliveriesinprogress,
        data: {
            ajax: true,
            action: 'addItem',
            productId: productId,
            obId: obId,
            qty: cantidad,
            grossUnitPrice: grossUnitPrice,
            datosPedido: arrayPedido
        },
        success: function (data) {
            // Código de éxito
            activaMensajeTemporal(); // Activamos el mensaje temporal
            // Utilizamos local storage para almacenar el flag de activación del mensaje
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');

            // Actualiza el arrayPedido en el cliente
            arrayPedido.push({
                id: productId,
                quantity: cantidad,
                grossUnitPrice: grossUnitPrice
            });
            // console.log("data",data);
            window["arrayPedido" + num] = arrayPedido; // Guarda el arrayPedido actualizado
            $('.balanceCashback').load(window.location.href + ' .balanceCashback');
            // Actualiza el DOM
            recargarContenidoPedidoSinCesta(obId);
            preloaderCarousel();
            // $('.spinner-container').hide();
        },
        error: function (error) {
            $('.spinner-container').hide(); // Lo primero, escondemos el spinner
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
            // Código de error
            // alert("Error en enviarCambios");
        }

    });
}

function removeItemFromOrder(idProduct, obId, numPedido, linea) {
    $('.spinner-container').show();
    var arrayPedido = window["arrayPedido" + numPedido];
    posicion = 0;
    var nodo;
    for (let value of arrayPedido) {
        if (value.id == idProduct) {
            nodo = value;
            break;
        }
        posicion++;
    }

    //FIX eliminar una cesta de un pedido con N cestas iguales
    if (linea) {
        posicion = parseInt(linea) - 1;
    }

    arrayPedido.splice(posicion, 1);
    $.ajax({
        type: 'POST',
        url: urlAjaxControllerDeliveriesinprogress,
        data: {
            ajax: true,
            action: 'removeItem',
            obId: obId,
            datosPedido: arrayPedido
        },
        success: function (data) {
            
            // Utilizamos local storage para almacenar el flag de activación del mensaje
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
            // location.reload();
            $('.balanceCashback').load(window.location.href + ' .balanceCashback');
            recargarContenidoPedidoSinCesta(obId);
            // $(".totalEntregaenCurso" + obId).load(window.location.href + " .totalEntregaenCurso" + obId); 
            // $('.spinner-container').hide();

        },
        error: function (error) {
            $('.spinner-container').hide();
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
        }
    })
}

function recargarContenidoPedidoSinCesta(obId, idElemento, num, lineId) {
    // Ejecuta el preloader para mostrar el cargador antes de la carga
    preloaderCarousel();

    // Recargar el contenedor padre (excepto los divs con clase 'contenido-pedido-ajax-cesta')
    $("#contenido-pedido-encurso-" + obId)
      .load(window.location.href + " #contenido-pedido-encurso-" + obId + " > *", function () {
          // Guardar el contenido interno de los divs con la clase 'contenido-pedido-ajax-cesta'
          var contentCesta = $(".contenido-pedido-ajax-cesta" + obId).html();
          // Restaurar el contenido interno en cada div de 'contenido-pedido-ajax-cesta'
          $(".contenido-pedido-ajax-cesta" + obId).each(function () {
              var id = $(this).attr('id');
              $("#" + id).html(contentCesta);
          });

          // Destruir y volver a inicializar todos los carruseles para evitar duplicación
          $(".owl-carousel").each(function () {
              $(this).owlCarousel('destroy');
              $(this).owlCarousel({
                  items: 1,
                  loop: false,
                  margin: 10,
                  nav: true,
                  dots: true,
                  responsive: {
                      1100: { items: 6 },
                      400: { items: 3 },
                      0: { items: 3 }
                  }
              });
          });

          // Reiniciar los carruseles para volver al primer elemento
          $(".owl-carousel").each(function () {
              var owlInstance = $(this).data('owl.carousel');
              if (owlInstance) {
                  owlInstance.trigger('to.owl.carousel', [0]);
              }
          });

          // Ejecutar el preloader nuevamente
          preloaderCarousel();

          // Actualizar los divs de info de cambios (ya existentes en el tpl)
          document.querySelectorAll("[id^='infoCambios_']").forEach(function(div) {
              // Se espera el formato: "infoCambios_{obId}_{lineId}"
              let parts = div.id.split("_");
              let obIdDiv = parts[1];
              let lineIdDiv = parts[2];
              let numDiv = div.getAttribute("data-num") || "";
              actualizarInfoCambios(obIdDiv, limiteCambios, numDiv, lineIdDiv);
          });
      });

    // Ejecutar la función que despliega el carrusel del producto (según tu lógica)
    desplegarcarrouselProductoCesta(idElemento);

    // Recargar el saldo del cliente y, al finalizar, actualizar info de cambios
    $("#saldo_customer_ajax").load(window.location.href + " #saldo_customer_ajax", function(){
        document.querySelectorAll("[id^='infoCambios_']").forEach(function(div) {
            let parts = div.id.split("_");
            let obIdDiv = parts[1];
            let lineIdDiv = parts[2];
            let numDiv = div.getAttribute("data-num") || "";
            actualizarInfoCambios(obIdDiv, limiteCambios, numDiv, lineIdDiv);
        });
    });

    // Recargar el total de entrega en curso y, al finalizar, actualizar info de cambios
    $(".totalEntregaenCurso" + obId).load(window.location.href + " .totalEntregaenCurso" + obId, function(){
        document.querySelectorAll("[id^='infoCambios_']").forEach(function(div) {
            let parts = div.id.split("_");
            let obIdDiv = parts[1];
            let lineIdDiv = parts[2];
            let numDiv = div.getAttribute("data-num") || "";
            actualizarInfoCambios(obIdDiv, limiteCambios, numDiv, lineIdDiv);
        });
    });

    // Ocultar el spinner después de 2 segundos
    $('.spinner-container').delay(2000).fadeOut();
}



// Usa tu variable "control" para el límite de cambios
// Usa tu variable "control" para definir el límite de cambios
const limiteCambios = control;

// Función auxiliar: genera la clave compuesta para localStorage (obId y lineId)
function getStorageKey(obId, lineId) {
    return obId + "_" + lineId;
}

// Función auxiliar: obtiene el contador de cambios para obId y lineId
function getContadorCambios(obId, lineId) {
    let cambiosPorPedido = JSON.parse(localStorage.getItem("cambiosPorPedido")) || {};
    const key = getStorageKey(obId, lineId);
    if (cambiosPorPedido[key] === undefined) {
        cambiosPorPedido[key] = 0;
    }
    return cambiosPorPedido[key];
}

// Función auxiliar: guarda el contador de cambios para obId y lineId
function setContadorCambios(obId, lineId, value) {
    let cambiosPorPedido = JSON.parse(localStorage.getItem("cambiosPorPedido")) || {};
    const key = getStorageKey(obId, lineId);
    cambiosPorPedido[key] = value;
    localStorage.setItem("cambiosPorPedido", JSON.stringify(cambiosPorPedido));
}

// Función para actualizar el mensaje de cambios restantes en la cesta
// Parámetros:
//   obId    = id del pedido
//   limite  = límite de cambios (limiteCambios)
//   num     = valor para formar la clase (.maxchanges{num}_{lineId})
//   lineId  = id de la cesta
function actualizarInfoCambios(obId, limite, num, lineId) {
    let contador = getContadorCambios(obId, lineId);
    const cambiosRestantes = limite - contador;

    // El div debe tener id "infoCambios_{obId}_{lineId}" (ya definido en tpl)
    const divId = "infoCambios_" + obId + "_" + lineId;
    let divInfo = document.getElementById(divId);
    if (!divInfo) {
        // Si no existe, lo creamos (pero lo ideal es que ya esté en el tpl)
        divInfo = document.createElement("div");
        divInfo.id = divId;
        divInfo.style.color = "#9F3C30";
        divInfo.style.paddingTop = "5px";
        divInfo.style.fontWeight = "700";
        divInfo.style.display = "none";
        document.body.appendChild(divInfo);
    }
    
    if (cambiosRestantes <= 0) {
        divInfo.innerHTML = "No te quedan cambios";
        document.querySelectorAll('.maxchanges' + num + '_' + lineId).forEach((element) => {
            element.style.display = 'none';
        });
    } else if (cambiosRestantes > 20) {
        divInfo.innerHTML = "";
        document.querySelectorAll('.maxchanges' + num + '_' + lineId).forEach((element) => {
            element.style.display = 'none';
        });
    } else {
        divInfo.innerHTML = "Te queda(n) " + cambiosRestantes + " cambio(s)";
        document.querySelectorAll('.maxchanges' + num + '_' + lineId).forEach((element) => {
            element.style.display = '';
        });
    }
    
    divInfo.style.display = "block";
}

// Al cargar la página, se actualizan todos los divs de info de cambios
document.addEventListener('DOMContentLoaded', function() {
    // Se espera que el tpl genere divs con id "infoCambios_{obId}_{lineId}" y data-num
    let divsInfo = document.querySelectorAll("[id^='infoCambios_']");
    divsInfo.forEach((div) => {
        let parts = div.id.split("_"); // Ejemplo: ["infoCambios", obId, lineId]
        let obId = parts[1];
        let lineId = parts[2];
        let num = div.getAttribute("data-num") || "";
        actualizarInfoCambios(obId, limiteCambios, num, lineId);
    });
});

// Función para realizar un cambio en una cesta
function changeItemFromBasket(posicion, idCambio, num, contadorLinea, padre, linea, lineId, obId, impactoPrecio, qty) {
    // Actualizar la info de cambios para esta cesta
    actualizarInfoCambios(obId, limiteCambios, num, lineId);

    var nodoCesta = window["arrayAlternativo" + num + linea];
    var espacio = "&nbsp;";
    var idElemento = idCambio + "-" + num + "-" + linea;
    // Se genera un id único para el contenedor "DESHACER" que incluya obId, contadorLinea, linea y lineId
    idDesh = 'precognis' + num + '-' + contadorLinea + '-' + linea;    
    var capaaCambiar = document.getElementById(idDesh);
    if (!capaaCambiar) {
        capaaCambiar = document.createElement("div");
        capaaCambiar.id = idDesh;
        document.body.appendChild(capaaCambiar);
    }

    // Función para deshacer (undo); se usa el idDesh único
    var funcion = 'undoChangeItemFromBasket("' + idDesh + '","' + idCambio + '","' + linea + '","' + num + '","' + idElemento + '","' + padre + '","' + contadorLinea + '","' + obId + '","' + lineId + '","' + impactoPrecio + '")';

    // Obtener el contador actual para esta cesta
    let contador = getContadorCambios(obId, lineId);
    
    // Si se alcanzó el límite, se ocultan los botones (con clase .maxchanges{num}_{lineId})
    if (contador >= limiteCambios) {
        document.querySelectorAll('.maxchanges' + num + '_' + lineId).forEach((element) => {
            setTimeout(() => {
                element.style.display = 'none';
            }, 1000);
        });
        console.log("Límite alcanzado en pedido " + obId + " (lineId " + lineId + "). No se permiten más cambios.");
        return;
    } else if (contador >= limiteCambios - 1) {
        document.querySelectorAll('.maxchanges' + num + '_' + lineId).forEach((element) => {
            element.style.display = 'none';
        });
    } else {
        document.querySelectorAll('.maxchanges' + num + '_' + lineId).forEach((element) => {
            element.style.display = '';
        });
    }

    // Incrementar el contador y guardarlo en localStorage para esta cesta
    contador++;
    setContadorCambios(obId, lineId, contador);

    // Actualizar el mensaje de cambios restantes
    actualizarInfoCambios(obId, limiteCambios, num, lineId);

    // Llamadas auxiliares (asegúrate de que estas funciones estén definidas)
    desplegarcarrouselProductoCesta(idElemento);
    cambiarId(contadorLinea, idCambio, num, nodoCesta[posicion].id, padre, linea);

    var arrayPedido = window["arrayPedido" + num];
    try {
        actualizaImpactoPrecioCesta(arrayPedido, padre, impactoPrecio, num, linea);
    } catch (err) {
        console.log(err.message);
    }

    $.ajax({
        type: 'POST',
        url: urlAjaxControllerDeliveriesinprogress,
        data: {
            ajax: true,
            action: 'UpdateOrder',
            obId: obId,
            datosPedido: arrayPedido
        },
        success: function (data) {
            const dataObj = JSON.parse(data);
            console.log(dataObj);

            var posicionCesta = 0;
            for (var i = 0; i < dataObj.order.length; i++) {
                if (dataObj.order[i].alternative.length > 0) {
                    posicionCesta = i;
                    console.log(dataObj.order[posicionCesta].alternative[posicion]);
                    break;
                }
            }

            $('.totalEntregaenCurso' + dataObj.obId).load(window.location.href + ' .totalEntregaenCurso' + dataObj.obId);

            // Actualiza el contenedor único de esta cesta con el botón DESHACER
            capaaCambiar.innerHTML = '' +
                '<div class="image imgCesta"><img src="' + nodoCesta[posicion].image + '"></div>' +
                '<div style="padding-left: 5px;">' +
                    '<p class="titulCesta" style="color: #290000; font-size: 1.2rem;"><b>' + nodoCesta[posicion].name + '</b> ' +
                        '<span style="color:#290000;font-weight:400;font-size:1rem"> (' + dataObj.order[posicionCesta].alternative[posicion].origin + ')</span>' +
                    '</p>' +
                    dataObj.order[posicionCesta].alternative[posicion].cantidad + espacio +
                    dataObj.order[posicionCesta].alternative[posicion].UM + espacio +
                    '(' + dataObj.order[posicionCesta].alternative[posicion].aproxUnits + ')' +
                '</br>' +
                '<a id="definido" class="btn btn-terciary definido" onclick=' + funcion + ' style="color: #9f3c30!important;padding: 0;">' +
                    '<img src="/img/cms/deshacer.png" style="width:20px;">' + espacio + 'DESHACER' +
                '</a>' +
                '<input type="hidden" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + nodoCesta[posicion].id + '">' +
                '</div>';

            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
            activaMensajeTemporal();
        },
        error: function (error) {
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal();
        }
    });
}

// Función para deshacer un cambio en una cesta
function undoChangeItemFromBasket(idDesh, idCambio, posicion, general, idElemento, padre, contadorLinea, obId, lineId, impactoPrecio) {
    var capaaCambiar = document.getElementById(idDesh);
    // Ahora usamos directamente lineId recibido como parámetro
    let contador = getContadorCambios(obId, lineId);
    console.log("Antes de restar - Cambios en pedido " + obId + " (lineId: " + lineId + "): " + contador);

    if (contador > 0) {
        contador--;
        console.log("Después de restar - Cambios en pedido " + obId + " (lineId: " + lineId + "): " + contador);
    } else {
        console.log("No se puede restar más cambios en pedido " + obId + ". La cantidad ya es 0.");
    }

    setContadorCambios(obId, lineId, contador);

    // Actualizar el mensaje de cambios restantes para esta cesta
    actualizarInfoCambios(obId, limiteCambios, general, lineId);

    if (contador < limiteCambios) {
        document.querySelectorAll('.maxchanges' + general + '_' + lineId).forEach((element) => {
            element.style.display = '';
        });
    }

    // comprobarTotal('contentcesta ' + padre + '-' + general, contador);
    cambiarId(contadorLinea, idCambio, general, idCambio, padre, posicion);

    var arrayPedido = window["arrayPedido" + general];
    try {
        actualizaImpactoPrecioCesta(arrayPedido, padre, -impactoPrecio, general, posicion);
    } catch (err) {
        console.log(err.message);
    }

    $.ajax({
        type: 'POST',
        url: urlAjaxControllerDeliveriesinprogress,
        data: {
            ajax: true,
            action: 'UndoChangeUpdateOrder',
            productId: idCambio,
            obId: obId,
            datosPedido: arrayPedido
        },
        dataType: 'json',
        success: function (response) {
            const dataObj2 = JSON.parse(response.result);
            var posicionCesta2 = 0;
            for (var i = 0; i < dataObj2.order.length; i++) {
                if (dataObj2.order[i].alternative.length > 0) {
                    posicionCesta2 = i;
                    console.log(dataObj2.order[posicionCesta2].alternative[posicion]);
                    break;
                }
            }

            $('.totalEntregaenCurso' + dataObj2.obId).load(window.location.href + ' .totalEntregaenCurso' + dataObj2.obId);

            capaaCambiar.innerHTML = '' +
                '<div class="image imgCesta"><img src="' + response.infoProduct.image + '"></div>' +
                '<div style="padding-left: 5px;">' +
                    '<p class="titulCesta" style="color: #290000; font-size: 1.2rem;"><b>' + response.infoProduct.name + '</b> ' +
                    '<span style="color:#290000;font-weight:400;font-size:1rem"> (' + dataObj2.order[posicionCesta2].content[posicion].origin + ') </span></p>' +
                    dataObj2.order[posicionCesta2].content[posicion].cantidad + '&nbsp;' +
                    dataObj2.order[posicionCesta2].content[posicion].UM + '&nbsp;(' +
                    dataObj2.order[posicionCesta2].content[posicion].aproxUnits + ')' + '</br>' +
                    '<a class="btn btn-terciary definido maxchanges' + general + '_' + lineId + '" onClick="desplegarcarrouselProductoCesta(\'' + idElemento + '\')" style="display: flex; color: #46735C!important; font-weight:400;padding: 0;">' +
                        '<img src="/img/cms/cambiar.png" style="width:20px;">&nbsp;CAMBIAR&nbsp;' +
                    '</a>' +
                '</div>';

            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han revertido correctamente.');
            activaMensajeTemporal();
        },
        error: function (error) {
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar deshacer el cambio.');
            activaMensajeTemporal();
        }
    });
}




function eliminar(idProduct, qty, numPedido, linea) {
    removeItemFromOrder(idProduct, qty, numPedido, linea)
    return
    capa = document.getElementById("lineaPedido" + numPedido + linea);
    capa.remove();

    var arrayPedido = window["arrayPedido" + numPedido];
    posicion = 0;
    var nodo;
    for (let value of arrayPedido) {
        if (value.id == idProduct) {
            nodo = value;
            break;
        }
        posicion++;

    }
    totalPedido = document.getElementById("total" + numPedido).innerText;
    totalPedido = totalPedido.slice(7, -2);
    totalPedido = parseFloat(totalPedido) - parseFloat((parseFloat(nodo.grossUnitPrice) * parseFloat(nodo.quantity)).toFixed(2));
    totalPedido = totalPedido.toFixed(2);
    document.getElementById("total" + numPedido).innerText = "TOTAL: " + totalPedido + " €";

    arrayPedido.splice(posicion, 1);

}









$('.example2').on('click', function () {
    $.confirm({
        title: 'Confirm!',
        content: 'Simple confirm!',
        buttons: {
            confirm: function () {
                $.alert('Confirmed!');
            },
            cancel: function () {
                $.alert('Canceled!');
            },
            somethingElse: {
                text: 'Something else',
                btnClass: 'btn-blue',
                keys: [
                    'enter',
                    'shift'
                ],
                action: function () {
                    this.$content // reference to the content
                    $.alert('Something else?');
                }
            }
        }
    });
});





//   ------------------------------
// Método para el popup de confirmación de cambios
const ui = {
    confirm: async (message) => createConfirm(message)
}

const createConfirm = (message) => {
    return new Promise((complete, failed) => {
        $('#confirmMessage').text(message)

        $('#confirmYes').off('click');
        $('#confirmNo').off('click');

        $('#confirmYes').on('click', () => { $('.confirm').hide(); complete(true); });
        $('#confirmNo').on('click', () => { $('.confirm').hide(); complete(false); });

        $('.confirm').show();
    });
}

const aplicarCambios = async (num, obId) => {
    const confirm = await ui.confirm('¿Desea aplicar los cambios?');

    if (confirm) {
        enviarCambios(num, obId);
    } else {
        //   
        // alert('Pos pa\'ti no');
    }
}



// -------------------------------
// Método para los Input con incrementos
(function () {
    window.inputNumber = function (el) {
        var min = el.attr('min') || false;
        var max = el.attr('max') || false;

        el.each(function () {
            init($(this));
        });

        function init(el) {
            el.prev().on('click', decrement);
            el.next().on('click', increment);

            function decrement() {
                var value = el[0].value;
                value--;
                (value < 1) ? value = 1 : '';
                if (!min || value >= min) {
                    el[0].value = value;
                    // Actualizamos el atributo del elemento
                    document.getElementById(el[0].id).setAttribute('value', value);
                }
            }

            function increment() {
                var value = el[0].value;
                value++;
                if (!max || value <= max) {
                    el[0].value = value;
                    // Actualizamos el atributo del elemento
                    document.getElementById(el[0].id).setAttribute('value', value);
                }
            }
        }
    };
})();

inputNumber($('.input-number'));