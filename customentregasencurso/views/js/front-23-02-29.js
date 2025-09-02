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
    if (!(document.getElementById('mycarouselProductoCesta ' + idElemento).classList.contains('active')))
        document.getElementById('mycarouselProductoCesta ' + idElemento).classList.add('active');
    else
        document.getElementById('mycarouselProductoCesta ' + idElemento).classList.remove('active');

}

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
// Comprueba en cada inicio de página si tiene que mostrar un mensaje temporal
window.onload = activaMensajeTemporal();





function selectItemCustomMyAccount(posicion, idCambio, general, contadorLinea, padre, linea) {
    alert('selectItemCustomMyAccount');
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
        //comprobarTotal('contentcesta ' + padre + '-' + general, window["cambiosCesta" + general + linea]);
        desplegarcarrouselProductoCesta(idElemento);
        //15-06-2022 cambiarId(linea,idCambio,general,nodoCesta[posicion].id,padre);
        cambiarId(contadorLinea, idCambio, general, nodoCesta[posicion].id, padre);
    }

}

function deshacerItemEC(idDesh, idCambio, posicion, general, idElemento, padre, contadorLinea) {
    alert('deshacerItemEC');
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
            //comprobarTotal('contentcesta ' + padre + '-' + general, window["cambiosCesta" + general + posicion]);
            cambiarId(contadorLinea, idCambio, general, idCambio, padre);

        },
        error: function (error) {

        }
    });
}

function cambiarId(posicion, idCambio, general, idNuevo, padre) {
    posicion = posicion - 1;
    var arrayPedido = window["arrayPedido" + general];
    for (let value of arrayPedido) {
        if (value.id == padre) {
            value.lista[posicion].id = idNuevo;
            value.lista[posicion].image = '';
            value.lista[posicion].name = '';
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


function enviarCambios(num, obId, linea) {
    // alert("Entrando en enviarCambios, con la variable "+ obId);
    var arrayPedido = window["arrayPedido" + num + linea];
    // let confirmAction = confirm("¿Estás seguro?");
    // if (confirmAction) {
    $.ajax({
        url: urlUpdate,
        data: { datosPedido: arrayPedido, numPedido: num, obId: obId, linea: linea },
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
function actualizaImpactoPrecioCesta(arrayPedido, padre, impactoPrecio)
{
    if($.isArray(arrayPedido)) {

        var precio_cesta_old = $(".orderEntregaenCurso").find(".lineaproduct").find(".precio-lineaproduct.cesta[data-id-product=" + padre + "]").html();
        var precio_cesta_new = 0;

        $(arrayPedido).each(function(index, element) {
        
            if( parseInt(element.id) == parseInt(padre) ) {

                precio_cesta_new = (parseFloat(precio_cesta_old) + parseFloat(impactoPrecio)).toFixed(2);
                $(".orderEntregaenCurso").find(".lineaproduct").find(".precio-lineaproduct.cesta[data-id-product=" + padre + "]").html(precio_cesta_new);
                arrayPedido[index]["grossUnitPrice"] = precio_cesta_new;

            }

        });

    }
}

function addItem(idProduct, qty, numPedido, country) {
    cantidad = document.getElementById(qty).value;
    $.ajax({
        url: urlDatoProducto,
        data: { idProduct: idProduct, country: country },
        method: 'post', //en este caso
        dataType: 'json',
        success: function (response) {
            //codigo de exito
            var arrayPedido = window["arrayPedido" + numPedido];
            annadirTramo(response, cantidad, numPedido, arrayPedido.length);
            nid = idProduct;
            nqty = cantidad;
            var nodo = {
                "id": nid,    //your artist variable
                "quantity": nqty,    //your artist variable
                "image": response.image,
                "name": response.name,
                "active": response.active,
                "grossUnitPrice": response.grossUnitPrice
            };
            arrayPedido.push(nodo);
            totalPedido = document.getElementById("total" + numPedido).innerText;
            totalPedido = totalPedido.slice(7, -2);
            totalPedido = parseFloat(totalPedido) + parseFloat((parseFloat(response.grossUnitPrice) * parseFloat(nqty)).toFixed(2));
            totalPedido = totalPedido.toFixed(2);
            document.getElementById("total" + numPedido).innerText = "TOTAL: " + totalPedido + " €";
        },
        error: function (error) {
            //codigo error
        }
    });


}

/**
 * Función evento añadir a la cesta
 * @param {integer} productId 
 * @param {integer} qty 
 * @param {string} obId 
 */
function addItemToOrder(productId, qty, num, obId) {
    cantidad = document.getElementById(qty).value;
    var arrayPedido = window["arrayPedido" + num];
    $.ajax({
        type: 'POST',
        url: urlAjaxControllerDeliveriesinprogress,
        data: {
            ajax: true,
            action: 'addItem',
            productId: productId,
            obId: obId,
            qty: cantidad,
            datosPedido: arrayPedido
        },
        success: function (data) {
            //codigo de exito
            $('.spinner-container').hide(); // lo primero, escondemos el spinner
            activaMensajeTemporal(); // Activamos el mensaje temporal
            // Utilizamos local storage para almacenar el flag de activación del mensaje
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
            location.reload();
        },
        error: function (error) {
            $('.spinner-container').hide(); // lo primero, escondemos el spinner
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
            //codigo error
            // alert("Error en enviarCambios");
        }
    })
}

function removeItemFromOrder(idProduct, obId, numPedido) {
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
            location.reload();
        },
        error: function (error) {
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
        }
    })
}

function changeItemFromBasket(posicion, idCambio, num, contadorLinea, padre, linea, obId, impactoPrecio) {
    var nodoCesta = window["arrayAlternativo" + num + linea];   
    var espacio = "&nbsp";
alert('Padre ' + padre);
alert('linea ' + linea);
alert('idCambio + num ' +idCambio + ' --- ' + num);
    idElemento = idCambio + "-" + num + "-" + linea;
    idDesh = 'precognis' + num + '-' + contadorLinea + '-' + linea;
    alert('idDesh ' + idDesh);
    alert('idElemento ' + idElemento);
    funcion = 'undoChangeItemFromBasket("' + idDesh + '","' + idCambio + '","' + linea + '","' + num + '","' + idElemento + '","' + padre + '","' + contadorLinea + '","' + obId + '","' + impactoPrecio + '")';
    totalPedidosEnCurso = window["cambiosCesta" + num + linea];
    if (totalPedidosEnCurso != 6) {
        capaaCambiar = document.getElementById(idDesh);
        capaaCambiar.innerHTML = '' +
            '<div className="image imgCesta"><img src="' + nodoCesta[posicion].image + '"></div>' +
            '<div style="padding-left: 5px;"><p class="titulCesta" style="color: #290000; font-size: 1.2rem;"><b>' + nodoCesta[posicion].name + '</b></p>' +
            '<a class="btn btn-terciary" onclick=' + funcion + ' style="color: #9f3c30!important;padding: 0;"><img src="/img/cms/deshacer.png" style="width:20px; ">' + espacio + 'DESHACER</a>' +
            '            <input type="text" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + nodoCesta[posicion].id + '">' +
            '        </a></div>';
        window["cambiosCesta" + num + linea] = parseFloat(totalPedidosEnCurso) + parseFloat(1);
        //alert('contentcesta ' + padre + '-' + num + '-' + posicion, window["cambiosCesta" + num + contadorLinea]);
        //comprobarTotal('contentcesta ' + padre + '-' + num, window["cambiosCesta" + num + linea]);
        desplegarcarrouselProductoCesta(idElemento);
        //15-06-2022 cambiarId(linea,idCambio,num,nodoCesta[posicion].id,padre);
        alert(contadorLinea, idCambio, num, nodoCesta[posicion].id, padre);
        cambiarId(contadorLinea, idCambio, num, nodoCesta[posicion].id, padre, linea);
        var arrayPedido = window["arrayPedido" + num];

        // Se actualiza el precio de la cesta
        try {
            actualizaImpactoPrecioCesta(arrayPedido, padre, impactoPrecio);
        }
        catch(err) {
            console.log(err.message);
        }
    
        $.ajax({
            type: 'POST',
            url: urlAjaxControllerDeliveriesinprogress,
            data: {
                ajax: true,
                action: 'UpdateOrder',
                obId: obId,
                linea: linea,
                datosPedido: arrayPedido
            },
            success: function (data) {
                // Utilizamos local storage para almacenar el flag de activación del mensaje
                console.log(data);
                localStorage.setItem("mensaje_temporal", 1);
                localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
                activaMensajeTemporal(); // Activamos el mensaje temporal
            },
            error: function (error) {
                localStorage.setItem("mensaje_temporal", 1);
                localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
                activaMensajeTemporal(); // Activamos el mensaje temporal
            }
        })
    }
    
    
}

function undoChangeItemFromBasket(idDesh, idCambio, posicion, general, idElemento, padre, contadorLinea, obId, impactoPrecio) {
    alert(idDesh);
    posicion = posicion - 1;
    funcion = desplegarcarrouselProductoCesta(idElemento);
    capaaCambiar = document.getElementById(idDesh);




    
    
    //traer Datos

    posicion = posicion + 1;
    window["cambiosCesta" + general + posicion] = parseFloat(window["cambiosCesta" + general + posicion]) - parseFloat(1);
    //comprobarTotal('contentcesta ' + padre + '-' + general, window["cambiosCesta" + general + posicion]);
    cambiarId(contadorLinea, idCambio, general, idCambio, padre);
    var arrayPedido = window["arrayPedido" + general];
    // Se actualiza el precio de la cesta
    try {
        actualizaImpactoPrecioCesta(arrayPedido, padre, -impactoPrecio);
    }
    catch(err) {
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
            capaaCambiar.innerHTML = '' +
                '<div className="image imgCesta"><img src="' + response.infoProduct.image + '"></div>' +
                '<div style="padding-left: 5px;"><p class="titulCesta" style="color: #290000; font-size: 1.2rem;"><b>' + response.infoProduct.name + '</b></p>' + 
                '<a class="btn btn-terciary definido" onClick=' + funcion + ' style="display: flex; color: #46735C!important; font-weight:400;padding: 0;">' +
                '<img src="/img/cms/cambiar.png" style="width:20px;">&nbsp;CAMBIAR&nbsp;' +
                '</a></div>';
                console.log(response.infoProduct);
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
        },
        error: function (error) {
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
        }
    })
}

function annadirTramo(json, qty, numPedido, numLineas) {

    capa = document.getElementById("extra" + numPedido);
    linea = numLineas + 1;
    tramo = '<div class="orderEntregaenCurso" id="lineaPedido' + numPedido + linea + '"> <div class="boxItemEditor1 simple" style="padding: 10px;"> <div class="editableItemFrame" id="precognis"><div class="editableItemFrame">' +
        '<div class="imageprin image imgCesta"><img src="' + json.image + '"></div> <div class="lineasimple" style="display:inline-block; margin-left: 80px;"> <p class="lineaproduct">' + json.name + '</p><p class="lineaproduct">Cantidad: ' + qty + '</p><a class="btn btn-terciary" onclick="eliminar(' + json.productId + ',' + qty + ',' + numPedido + ',' + linea + ')">' +
        '<i class="material-icons shopping-cart"><i class="fa fa-trash" aria-hidden="true"style="color: #177343; font-weight: 300;"><p style="display: inline;font-family: Lora; color: #177343; font-size: 12px; font-weight: 300;">&nbsp&nbsp&nbspEliminar</p></i></a> </div></div> </div> </div> </div></div>';
    ca = document.createElement("div");
    ca.innerHTML = tramo;
    document.querySelector("#extra" + numPedido).insertAdjacentElement("beforeend", ca);




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