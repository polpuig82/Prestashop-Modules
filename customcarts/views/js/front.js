//Cosas del modal
$(document).ready(function(){
    $(".wish-icon i").click(function(){
        $(this).toggleClass("fa-heart fa-heart-o");
    });
});
var total=0;
//llevar id seleccion
    //triggered when modal is about to be shown
    $('#modalCarrousel').on('show.bs.modal', function(e) {

    //get data-id attribute of the clicked element
    var elemento = $(e.relatedTarget).data('elemento-id');

    //populate the textbox
    $(e.currentTarget).find('input[name="idCambio"]').val(elemento);
});

    function selectItem(idElemento)
    {
        if(total!=6) {
        idCambio=document.getElementById('idCambio').value;
        capaaCambiar= document.getElementById('precognis'+idCambio);
        capaaCambiar.innerHTML='' +
            '<div class="editableItemFrame"><div class="image">' +
            '<img src="'+productosCestaAlternativa[idElemento].image+'"></div>' +
            '<a class="btn btn-primary" onclick="deshacerItem('+idCambio+')"><i class="material-icons shopping-cart">rotate_left</i></a>' +productosCestaAlternativa[idElemento].name+
            '            <input type="hidden" id="ElementoCestaInp'+idCambio+'" name="ElementoCestaInp'+idCambio+'" value="'+productosCestaAlternativa[idElemento].componente+'">'+
            '        </a></div>';

        total=total+1;
        comprobarTotal();

        $('#modalCarrousel').modal('hide');

        }

    }

function selectItemMyAccount(idElemento)
{
    if(total!=6) {
        idCambio=document.getElementById('idCambio').value;
        capaaCambiar= document.getElementById('precognis'+idCambio);
        capaaCambiar.innerHTML='' +
            '<div class="editableItemFrame"><div class="image">' +
            '<img src="'+productosCestaAlternativa[idElemento].image+'"></div>' +
            '<a class="btn btn-primary" onclick="volverCompradoMyAccount('+idCambio+')"><i class="material-icons shopping-cart">rotate_left</i></a>' +productosCestaAlternativa[idElemento].name+
            '<a class="btn btn-primary" onclick="volverDefinidoMyAccount('+idCambio+')"><i class="material-icons shopping-cart">crop_rotate</i></a>'+
            '            <input type="hidden" id="ElementoCestaInp'+idCambio+'" name="ElementoCestaInp'+idCambio+'" value="'+productosCestaAlternativa[idElemento].componente+'">'+
            '        </a></div>';

        total=total+1;
        comprobarTotal();

        $('#modalCarrousel').modal('hide');

    }

}

function deshacerItem(idElemento)
{

        idCambio = idElemento;
        capaaCambiar = document.getElementById('precognis' + idCambio);
        capaaCambiar.innerHTML = '' +
            '<div class="editableItemFrame"><div class="image">' +
            '<img src="' + productosCestaDefinida[idElemento - 1].image + '"></div>' +
            ' <a class="btn btn-primary definido" data-toggle="modal" data-target="#modalCarrousel" data-elemento-id="' + idCambio + '">' +
            '                <i class="material-icons shopping-cart">edit</i></a>' + productosCestaDefinida[idElemento - 1].name +
            '            <input type="hidden" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + productosCestaDefinida[idElemento - 1].componente + '">' +
            '        </a></div>';

        total = total - 1;
        comprobarTotal();


}


function volverDefinidoMyAccount(idElemento)
{

    idCambio = idElemento;
    capaaCambiar = document.getElementById('precognis' + idCambio);
    capaaCambiar.innerHTML = '' +
        '<div class="editableItemFrame"><div class="image">' +
        '<img src="' + productosCestaDefinida[idElemento - 1].image + '"></div>' +
        ' <a class="btn btn-primary definido" data-toggle="modal" data-target="#modalCarrousel" data-elemento-id="' + idCambio + '">' +
        '                <i class="material-icons shopping-cart">edit</i></a>' + productosCestaDefinida[idElemento - 1].name +
        '            <input type="hidden" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + productosCestaDefinida[idElemento - 1].componente + '">' +
        '        </a></div>';

    total = total - 1;
    comprobarTotal();


}

function comprobarTotal()
{
    //p=numElementos(cestaDefinida);
    if(total==control)
    {
        const collection = document.getElementsByClassName("definido");
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "none";
        }
    }
    else
    {

        const collection = document.getElementsByClassName("definido");
        for (let i = 0; i < collection.length; i++) {
            collection[i].style.display = "unset";
        }
    }


}

function volverCompradoMyAccount(idElemento) {

    idCambio = idElemento;
    capaaCambiar = document.getElementById('precognis' + idCambio);
    capaaCambiar.innerHTML = '' +
        '<div class="editableItemFrame"><div class="image">' +
        '<img src="' + productosCestaOrder[idElemento - 1].image + '"></div>' +
        ' <a class="btn btn-primary definido" data-toggle="modal" data-target="#modalCarrousel" data-elemento-id="' + idCambio + '">' +
        '                <i class="material-icons shopping-cart">edit</i></a>' + productosCestaOrder[idElemento - 1].name +
        '            <input type="hidden" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + productosCestaOrder[idElemento - 1].componente + '">' +
        '        </a></div>';

    total = total - 1;
    comprobarTotal();


}

function guardarCambiosMyAccount(formulario)
{

    var data = JSON.stringify( $(formulario).serializeArray() );
    console.log( data );

      /*  var months = document.getElementById("month_FinanZAS").value;
        var monthlyFee = document.getElementById("monthlyFee_FinanZAS").value;
        var totalToPay = document.getElementById("totalToPay_FinanZAS").value;
        var select = document.getElementById("state_FinanZAS");
        var state = select.options[select.selectedIndex].value;
        $.ajax({
            type: "POST",
            url: '{$urlUpdate|escape:'htmlall':'UTF-8'}',
            data: { months:months, monthlyFee: monthlyFee, totalToPay : totalToPay, state : state,id_order : id_order,empleado:empleado },
            dataType: 'json',
            success: function (json){
                if(json.mensaje=='ok'){
                    document.getElementById("mensaje").style.display='inline';
                    $('#mensaje').html('<div class="alert alert-success">{l s='Update Ok'  mod='finanzaspay'}</div>');
                    if((state=="confirm")||(state=="cancel")){
                        $('#mensaje').html('<div class="alert alert-success">{l s='Update Ok'  mod='finanzaspay'} <img src="{$urlReloj|escape:'htmlall':'UTF-8'}" style="width:48px;height: auto;padding-left:7px"></div>');
                        document.getElementById('id_order_state').value = json.estado;
                        $('#submit_state').click();
                    }
                }
                else{
                    $('#mensaje').html('<div class="alert alert-danger">{l s='Update Error'  mod='finanzaspay'}</div>');
                }
            },
            error : function(){
                //aquí lo que se ejecuta en caso de que falle
                $('#mensaje').html('<div class="alert alert-danger">{l s='Update Error'  mod='finanzaspay'}</div>');
            }
        })*/


}






