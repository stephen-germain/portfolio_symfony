// $(function()
// {
//      $(".test, footer a").on("click", function(event)
//      {
//             event.preventDefault();
//             var hash = this.hash;
//             $('body,html').animate({scrollTop: $(hash).offset().top} , 900 , function(){window.location.hash = hash;})
//      });
// })

// $(function(){

// 	$(window).scroll(function(){
// 		if($(window).scrollTop() > 580 && window.matchMedia('(min-width: 1200px)').matches){
// 			$('.animate').css('visibility', 'visible');
//                $('.animate').addClass('animate__animated animate__fadeInUp');
//           }
//           // else if($(window).scrollTop() < 580 && window.matchMedia('(min-width: 1200px)').matches){
//           //      $('.animate').css('visibility', 'hidden');
//           //      $('.animate').addClass('animate__animated animate__fadeOutUp');
//           // }
          
//      })
// })

AOS.init({
     duration: 1200,
   })