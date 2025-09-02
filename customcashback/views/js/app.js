
$('.basic').owlCarousel({ 



    
    responsiveRefreshRate: 1,  


  loop:false,
  margin:10,
  nav:true,
  responsiveClass:true,
  responsive:{
    //   1800:{
    //     items:6
    //   },
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

