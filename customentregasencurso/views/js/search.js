$(document).ready(function () {
    //
    function delay(callback, ms) {
        var timer = 0
        return function() {
          var context = this, args = arguments
          clearTimeout(timer)
          timer = setTimeout(function () {
            callback.apply(context, args)
          }, ms || 0)
        }
      }
    $('#searchbar').on("keyup", delay(function (e) {
        e.preventDefault()
        // var url = "ajax-tab.php"
        var searchValue = $(this).val()
        var contadorGeneral = $(this).data('contador')
        $.ajax({
            type: 'POST',
            url: urlAjaxControllerDeliveriesinprogress,
            data: {
                ajax: true,
                action: 'searchProduct',
                searchValue: searchValue,
                contadorGeneral: $(this).data('contador'),
            },
            success: function (data) {
                var dataArray = JSON.parse(data)
                // $('#resultados').empty()
                $('#resultados').html(dataArray)
                $('#searchcarrousel .basic').owlCarousel({ 
                    responsiveRefreshRate: 1,  
                    loop:false,
                    margin:10,
                    nav:true,
                    responsiveClass:true,
                    responsive:{
                        1100:{
                            items:6
                        },
                        400:{
                            items:3
                        },
                        0:{
                            items:2
                        }
                    },
                    animateOut: 'slideOutDown',
                    animateIn: 'flipInX',
                    smartSpeed:450
                })

                inputNumber($('.input-number'));
            }
        })
    }, 500))
})