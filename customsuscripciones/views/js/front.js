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

var control=6;
var totalPedidosEnCurso=0;






function desplegarAnnadirPedido(idElemento)
{


    if(!(document.getElementById('carrouseladdPedido'+idElemento).classList.contains('active')))
        document.getElementById('carrouseladdPedido'+idElemento).classList.add('active');
    else
        document.getElementById('carrouseladdPedido'+idElemento).classList.remove('active');

}

function preloaderCarousel() {

    // Captamos los carouseles
    const collection = document.querySelectorAll('[id^=mycarousel]');

    for (product of collection){
        product.style.display = "block";

    }

    // Captamos los carouseles
    const collection2 = document.querySelectorAll('[id^=mycarouselProductoCesta]');

    for (product of collection2){
        product.style.display = "none";

    }

}

window.onload  = preloaderCarousel;
 

// Comprueba en cada inicio de página si tiene que mostrar un mensaje temporal
window.onload  = activaMensajeTemporal();



















function comprobarTotal(id)
{
    //p=numElementos(cestaDefinida);
    if(totalPedidosEnCurso==control)
    {
        const collection = document.getElementById(id).getElementsByClassName("definido");
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "none";
        }
    }
    else
    {

        const collection = document.getElementById(id).getElementsByClassName("definido");
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "unset";
        }
    }


}



function enviarCambios(num,obId)
{
    var arrayPedido=window["arrayPedido"+num];
    // let confirmAction = confirm("¿Estás seguro?");
    // if (confirmAction) {

        // Activamos spinner
        $('.spinner-container').show();
        // Petición
        $.ajax({
            url: urlUpdate,
            data: {datosPedido: arrayPedido, obId: obId},
            method: 'post', //en este caso
            dataType: 'html',
            async: true,
            success: function (response) {
                $('.spinner-container').hide(); // lo primero, escondemos el spinner
                activaMensajeTemporal(); // Activamos el mensaje temporal
                

                // Utilizamos local storage para almacenar el flag de activación del mensaje
                localStorage.setItem("mensaje_temporal", 1);
                localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');

                // alert("Cambios Realizados con éxito");
                console.log("Cambios realizados con éxito");
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
        });
    // }

}


// Método para activar el mensaje temporal
function activaMensajeTemporal(mensaje='Los cambios se han aplicado correctamente') {
 
    // validamos si existe en el localstorage la llave mensaje_temporal
    if(localStorage.getItem("mensaje_temporal") ==="1"){ 
        
        // si existe, mostramos el mensaje de confirmación
        $("#hideDiv").css("height","150px ");
        $(".mensaje-retorno").html(localStorage.getItem("mensaje_temporal_contenido"));

        $("#hideDiv").show();
        setTimeout(function() { $("#hideDiv").fadeOut(1500); }, 5000);     
        
        // deshabilitamos el flag
        localStorage.setItem("mensaje_temporal", 0);
        localStorage.setItem("mensaje_temporal_contenido", "");
    }
     
}

function switchEstado(num,obId,estado)
{
    //Sacar estado nuevo
    var arrayLineas=window["arrayLineas"+num];
    if(estado.checked)
        active=true;
    else
    active=false;
    $.ajax({
        url : urlUpdateEstado,
        data : {obId:obId,active:active,lineas:arrayLineas},
        method : 'post', //en este caso
        dataType : 'json',
        success : function(response){
            

            // Utilizamos local storage para almacenar el flag de activación del mensaje
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Los cambios se han aplicado correctamente.');
            activaMensajeTemporal(); // Activamos el mensaje temporal

            // alert("Cambios Realizados con éxito");
            console.log("Cambios realizados con éxito");
            
        },
        error: function(error){
            $('.spinner-container').hide(); // lo primero, escondemos el spinner
            localStorage.setItem("mensaje_temporal", 1);
            localStorage.setItem("mensaje_temporal_contenido", 'Ha habido un error al intentar aplicar los cambios.');
            activaMensajeTemporal(); // Activamos el mensaje temporal
        }
    });


}

function addItem(idProduct,qty,numPedido,country)
{
    var arrayPedido=window["arrayPedido"+numPedido];
    numLineas=arrayPedido.length;

    cantidad= document.getElementById(qty).value;
    $.ajax({
        url : urlDatoProducto,
        data : {idProduct:idProduct,country:country},
        method : 'post', //en este caso
        dataType : 'json',
        success : function(response){
            //codigo de exito
            var arrayPedido=window["arrayPedido"+numPedido];
            annadirTramo(response,cantidad,numPedido,numLineas,idProduct);
            nid=idProduct;
            nqty=cantidad;
            var nodo = {
                "id" : nid,    //your artist variable
                "quantity" : nqty,    //your artist variable
                "image": response.image,
                "name": response.name,
                "active": response.active,
                "nuevo":"nuevo",
                "grossUnitPrice":response.grossUnitPrice,
            };
            arrayPedido.push(nodo);
            //mostrar aplicar cambios
            document.getElementById("appchanges"+numPedido).style.display="block";
        },
        error: function(error){
            //codigo error
        }
    });


}

function annadirTramo(json,qty,numPedido,numLineas,idProduct)
{

    capa= document.getElementById("extra"+numPedido);
    linea=numLineas+1;
    tramo='<div class="orderEntregaenCurso" id="lineaPedido'+numPedido+linea+'"> <div class="boxItemEditor1 simple" style="padding: 10px;"> <div class="editableItemFrame" id="precognis"><div class="editableItemFrame">'+
    '<div class="imageprin image imgCesta"><img src="'+json.image+'"></div> <div class="lineasimple" style="display:inline-block; margin-left: 35px;"> <p class="lineaproduct">'+json.name+'</p><br><p class="lineaproduct">Cantidad: '+qty+'</p><a class="btn btn-terciary" onclick="eliminar('+json.productId+','+qty+','+numPedido+','+linea+')">'+
    '<i class="material-icons shopping-cart"><i class="fa fa-trash" aria-hidden="true"style="color: #177343; font-weight: 300;"><p style="display: inline;font-family: Lora; color: #177343; font-size: 12px; font-weight: 300;">&nbsp&nbsp&nbspEliminar</p></i></a> </div></div> </div> </div> </div></div>';
    ca = document.createElement("div");
    ca.innerHTML = tramo;
    document.querySelector("#extra"+numPedido).insertAdjacentElement("beforeend", ca);




}


function eliminar(idProduct,qty,numPedido,linea)
{
    capa= document.getElementById("lineaPedido"+numPedido+linea);
    capa.remove();

    var arrayPedido=window["arrayPedido"+numPedido];
    posicion=0;
    esnuevo=0;
    for (let value of arrayPedido) {
        if(value.id==idProduct)
        {
            break;
        }
        posicion++;

    }
    arrayPedido.splice(posicion, 1);

    for (let value of arrayPedido) {
        if(value.nuevo)
        {
                esnuevo=1;
            break;
        }
        posicion++;
    }

    if(!esnuevo)
        document.getElementById("appchanges"+numPedido).style.display="none";



}





//   ------------------------------
// Método para el popup de confirmación de cambios
const ui = {
    confirm: async (message) => createConfirm(message)
  }
  
  const createConfirm = (message) => {
    return new Promise((complete, failed)=>{
      $('#confirmMessage').text(message)
  
      $('#confirmYes').off('click');
      $('#confirmNo').off('click');
      
      $('#confirmYes').on('click', ()=> { $('.confirm').hide(); complete(true); });
      $('#confirmNo').on('click', ()=> { $('.confirm').hide(); complete(false); });
      
      $('.confirm').show();
    });
  }
                       
  const aplicarCambios = async (num,obId) => {
    const confirm = await ui.confirm('¿Desea aplicar los cambios?');
    
    if(confirm){
      enviarCambios(num,obId);
    } else{
        //   
        // alert('Pos pa\'ti no');
    }
  }


//   ------------------------------
// Método para los Input con incrementos
(function() {
    window.inputNumber = function(el) {
      var min = el.attr('min') || false;
      var max = el.attr('max') || false;
  
      el.each(function() {
        init($(this));
      });
  
      function init(el) {
        el.prev().on('click', decrement);
        el.next().on('click', increment);
  
        function decrement() {
          var value = el[0].value;
          value--;
          (value < 1) ? value = 1: '';
          if (!min || value >= min) {
            el[0].value = value;
            // Actualizamos el atributo del elemento
            document.getElementById(el[0].id).setAttribute('value',value);
          }
        }
  
        function increment() {
          var value = el[0].value;
          value++;
          if (!max || value <= max) {
            el[0].value = value;
            // Actualizamos el atributo del elemento
            document.getElementById(el[0].id).setAttribute('value',value);
          }
        }
      }
    };
  })();
  
  inputNumber($('.input-number'));
















