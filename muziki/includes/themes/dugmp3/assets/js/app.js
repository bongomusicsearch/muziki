   jQuery("document").ready(function($){
             
             var nav = $('.navZ');
             
             $(window).scroll(function () {
                 if ($(this).scrollTop() > 136) {
                     nav.addClass("f-nav");
                 } else {
                     nav.removeClass("f-nav");
                 }
             });
          
         });