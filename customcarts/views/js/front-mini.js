
var total=0;


    function selectItem(idElemento,idCambio)
    {
        if(total!=6) {
        capaaCambiar= document.getElementById('precognis'+idCambio);
        capaaCambiar.innerHTML='' +
            '<div class="image">' +
            '<img src="'+productosCestaAlternativa[idElemento].image+'"></div>' +
            '<a class="btn btn-primary" onclick="deshacerItem('+idCambio+')"><i class="material-icons shopping-cart">rotate_left</i></a>' +productosCestaAlternativa[idElemento].name+
            '            <input type="hidden" id="ElementoCestaInp'+idCambio+'" name="ElementoCestaInp'+idCambio+'" value="'+productosCestaAlternativa[idElemento].componente+'">'+
            '        </a>';

        total=total+1;
        comprobarTotal();

        desplegar(idCambio);

        }

    }



function deshacerItem(idElemento)
{

        idCambio = idElemento;
        capaaCambiar = document.getElementById('precognis' + idCambio);
        capaaCambiar.innerHTML = '' +
            '<div class="image">' +
            '<img src="' + productosCestaDefinida[idElemento - 1].image + '"></div>' +
            ' <a class="btn btn-primary definido" onclick="desplegar(' + idCambio + ')">' +
            '                <i class="material-icons shopping-cart">edit</i></a>' + productosCestaDefinida[idElemento - 1].name +
            '            <input type="hidden" id="ElementoCestaInp' + idCambio + '" name="ElementoCestaInp' + idCambio + '" value="' + productosCestaDefinida[idElemento - 1].componente + '">' +
            '        </a>';

        total = total - 1;
        comprobarTotal();


}

function desplegar(idElemento)
{


    if(!(document.getElementById('mycarousel'+idElemento).classList.contains('active')))
        document.getElementById('mycarousel'+idElemento).classList.add('active');
    else
        document.getElementById('mycarousel'+idElemento).classList.remove('active');

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

 


function preloaderCarousel() {
     
    // Captamos los carouseles
    const collection = document.querySelectorAll('[id^=mycarousel]');
 
    for (product of collection){
        product.style.display = "none";
        // alert("holaaa");
    }
 
  }
  
  window.onload  = preloaderCarousel;



//TOCADO EL 2/5/22 para ver como checkear el iban 



//SCRIPT 1
/*
function comprobarIBAN(){
    iban = document.getElementById("IBAN-input").value;

    console.log("El IBAN introducido es: " + iban);

    subm = document.getElementById("submit-btn");
    subm.addEventListener("click", function(){
         checkIBAN(iban.value);
    });
    return iban;
 }

 function checkIBAN()
    {
        iban = document.getElementById("IBAN-input");
        if(iban.length==24)
        {
            var digitoControl=getCodigoControl_IBAN(iban.substr(0,2).toUpperCase(), iban.substr(4));
            if(digitoControl==iban.substr(2,2))
                return true;
                console.log("true");
        }
        else{

            console.log("false");
            return false;
        
        }
    }

    function getCodigoControl_IBAN(codigoPais,cc)
    {
        // cada letra de pais tiene un valor
        valoresPaises = {
            'A':'10',
            'B':'11',
            'C':'12',
            'D':'13',
            'E':'14',
            'F':'15',
            'G':'16',
            'H':'17',
            'I':'18',
            'J':'19',
            'K':'20',
            'L':'21',
            'M':'22',
            'N':'23',
            'O':'24',
            'P':'25',
            'Q':'26',
            'R':'27',
            'S':'28',
            'T':'29',
            'U':'30',
            'V':'31',
            'W':'32',
            'X':'33',
            'Y':'34',
            'Z':'35'
        };
     
        // reemplazamos cada letra por su valor numerico y ponemos los valores mas dos ceros al final de la cuenta
        var dividendo = cc+valoresPaises[codigoPais.substr(0,1)]+valoresPaises[codigoPais.substr(1,1)]+'00';
     
        // Calculamos el modulo 97 sobre el valor numerico y lo restamos al valor 98
        var digitoControl = 98-modulo(dividendo, 97);
     
        // Si el digito de control es un solo numero, añadimos un cero al delante
        if(digitoControl.length==1)
        {
            digitoControl='0'+digitoControl;
        }
        return digitoControl;
    }

    function modulo(valor, divisor) {
        var resto=0;
        var dividendo=0;
        for (var i=0;i<valor.length;i+=10) {
            dividendo = resto + "" + valor.substr(i, 10);
            resto = dividendo % divisor;
        }
        return resto;
    }*/





//SCRIPT2
// const IBAN=(document.getElementById("IBAN-input").value);

function fn_ValidateIBAN(IBAN) {
    
    console.log(IBAN);
    //Se pasa a Mayusculas
    IBAN = IBAN.toUpperCase();
    //Se quita los blancos de principio y final.
    IBAN = IBAN.trim();
    IBAN = IBAN.replace(/\s/g, ""); //Y se quita los espacios en blanco dentro de la cadena

    var letra1,letra2,num1,num2;
    var isbanaux;
    //var numeroSustitucion;

        letra1 = IBAN.substring(0, 1);
        console.log(letra1);
        letra2 = IBAN.substring(1, 2);
        console.log(letra2);

    //La longitud debe ser siempre de 24 caracteres
    if (IBAN.length != 24) {
        // console.log("false");
        // console.log(IBAN.value);
        // typeof(IBAN);
        // console.log(IBAN.length);

        event.preventDefault();
        alert("El IBAN se compone de 24 caracteres, por favor introdúzcalo adecuadamente");
        return false;
        
    }else if(letra1 != 'A' || letra2 != 'D'){
        event.preventDefault();
        console.log("no estan bine las letra");
        alert("El código IBAN de Andorra comienza por 'AD', asegúrese de introducirlo correctamente");
        return false;
    }

    // Se coge las primeras dos letras y se pasan a números
        console.log(IBAN);
    
        
  
    num1 = getnumIBAN(letra1);
    num2 = getnumIBAN(letra2);
    //Se sustituye las letras por números.
    isbanaux = String(num1) + String(num2) + IBAN.substring(2);
    // Se mueve los 6 primeros caracteres al final de la cadena.
    isbanaux = isbanaux.substring(6) + isbanaux.substring(0,6);
    
    //Se calcula el resto, llamando a la función modulo97, definida más abajo
    resto = modulo97(isbanaux);
    if (resto == 1){
        return true;
    }else{
        event.preventDefault();
        alert("El IBAN introducido no és correcto, por favor introdúzcalo correctamente");
        
        return false;
    }

}
// function insertarIBAN(IBAN){
//     //IBAN=fn_ValidateIBAN(IBAN);
//     var mysql = require('mysql');  
//     var con = mysql.createConnection({  
//         host: "127.0.0.1",  
//         user: "prestashop",  
//         password: "3jIE6PgBr2npcxsw",  
//         database: "prestashop"  
//     });  
//     con.connect(function(err) {  
//         if (err) throw err;  
//         console.log("Connected!");  

//         var sql = "INSERT INTO ps_order_payment (card_number) VALUES (`${IBAN}`)";  

//         con.query(sql, function (err, result) {  
//             if (err) throw err;  
//             console.log("1 record inserted");  
//         });
//     });
// }


function modulo97(iban) {
    var parts = Math.ceil(iban.length/7);
    var remainer = "";

    for (var i = 1; i <= parts; i++) {
        remainer = String(parseFloat(remainer+iban.substr((i-1)*7, 7))%97);
    }

    return remainer;
}

function getnumIBAN(letra) {
    ls_letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return ls_letras.search(letra) + 10;
}







