(function ($) {

    "use strict";





    $('.alert').alert();



        $(window).scroll(function(){

        if ($(this).scrollTop() > 150) {

           $('#fix_top').addClass('fixed-top');

           $('body').addClass('ptt');

        } else {

           $('#fix_top').removeClass('fixed-top');

           $('body').removeClass('ptt');

        }

    });

    

    // Dropdown on mouse hover

    // $(document).ready(function () {

    //     function toggleNavbarMethod() {

    //         if ($(window).width() > 992) {

    //             $('.navbar .dropdown').on('mouseover', function () {

    //                 $('.dropdown-toggle', this).trigger('click');

    //             }).on('mouseout', function () {

    //                 $('.dropdown-toggle', this).trigger('click').blur();

    //             });

    //         } else {

    //             $('.navbar .dropdown').off('mouseover').off('mouseout');

    //         }

    //     }

    //     toggleNavbarMethod();

    //     $(window).resize(toggleNavbarMethod);

    // });
    
    //navbar dropdown
    $(document).ready(function() {
      $('#fix_top .dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(150).slideDown(150);
      }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(150).slideUp(150);
      });
    });

    

    

    // Back to top button

    $(window).scroll(function () {

        if ($(this).scrollTop() > 100) {

            $('.back-to-top').fadeIn('slow');

        } else {

            $('.back-to-top').fadeOut('slow');

        }

    });

    $('.back-to-top').click(function () {

        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');

        return false;

    });





    // Vendor carousel

    $('.vendor-carousel-LtoR').owlCarousel({

        loop: true,

        // margin: 29,

        rtl:true,

        nav: false,

        autoplay: true,

        smartSpeed: 1000,

        responsive: {

            0:{

                items:2

            },

            576:{

                items:3

            },

            768:{

                items:4

            },

            992:{

                items:5

            },

            1200:{

                items:5

            }

        }

    });


    $('.vendor-carousel').owlCarousel({

        loop: true,

        // margin: 29,

        nav: false,

        autoplay: true,

        smartSpeed: 1000,

        responsive: {

            0:{

                items:2

            },

            576:{

                items:3

            },

            768:{

                items:4

            },

            992:{

                items:5

            },

            1200:{

                items:5

            }

        }

    });





    // Related carousel

    $('.related-carousel-LtoR').owlCarousel({

        loop: true,

         rtl:true,

        margin: 29,

        nav: false,

        autoplay: true,

        smartSpeed: 1000,

        responsive: {

            0:{

                items:2,

                margin: 5,

                nav: true,

            },

            576:{

                items:2,

                margin: 5,

                nav: true,

            },

            768:{

                items:3

            },

            992:{

                items:5

            }

        }

    });

    $('.related-carousel').owlCarousel({

        loop: true,

        margin: 29,

        nav: false,

        autoplay: true,

        smartSpeed: 1000,

        responsive: {

            0:{

                items:2,

                margin: 5,

                nav: true,

            },

            576:{

                items:2,

                margin: 5,

                nav: true,

            },

            768:{

                items:3

            },

            992:{

                items:5

            }

        }

    });


    $('.home_prd_carousel_LtoR').owlCarousel({

        // loop: true,

        rtl:true,

        margin: 29,

        nav: true,

        autoplay: true,

        smartSpeed: 1000,

        autoplayTimeout:2000,

        autoplayHoverPause:true,

        responsive: {

            0:{

                items:2,

                margin: 5,

                nav: true,

            },

            576:{

                items:2,

                margin: 5,

                nav: true,

            },

            768:{

                items:3

            },

            992:{

                items:5

            }

        }

    });

    // home_prd_carousel

    $('.home_prd_carousel').owlCarousel({

        // loop: true,

        margin: 29,

        nav: true,

        autoplay: true,

        smartSpeed: 1000,

        autoplayTimeout:2000,

        autoplayHoverPause:true,

        responsive: {

            0:{

                items:2,

                margin: 5,

                nav: true,

            },

            576:{

                items:2,

                margin: 5,

                nav: true,

            },

            768:{

                items:3

            },

            992:{

                items:5

            }

        }

    });



    // Related carousel

    $('#newArrivels').owlCarousel({

        loop: true,

        margin: 29,

        nav: true,

        autoplay: true,

        smartSpeed: 1000,

        autoplayTimeout:2000,

        autoplayHoverPause:true,

        items:1,

        // responsive: {

        //     0:{

        //         items:1

        //     },

        //     576:{

        //         items:2

        //     },

        //     768:{

        //         items:3

        //     },

        //     992:{

        //         items:4

        //     }

        // }

    });





    // Product Quantity

    $('.quantity button').on('click', function () {

        var button = $(this);

        var oldValue = button.parent().parent().find('input').val();

        if (button.hasClass('btn-plus')) {

            var newVal = parseFloat(oldValue) + 1;

        } else {

            if (oldValue > 0) {

                var newVal = parseFloat(oldValue) - 1;

            } else {

                newVal = 0;

            }

        }

        button.parent().parent().find('input').val(newVal);

    });







  // hide show shopping cart

  $('#track_return').click(function() {

    $('body').addClass('hideScroll')

    $('.right_side_cart').css({

      right: '0',

      // property2: 'value2'

    });

  });

  $('#track_return').click(function() {

    $('.menuFullBG2').slideToggle();

    // $('.menuFullBG2').css({

    //   width: '100%',

    // });

  });

  $('#TrackReturnClose').click(function() {

    $('body').removeClass('hideScroll')

    $('.right_side_cart').css('right', '-100%');

    $('.menuFullBG2').hide();

  });







  $('#rewardspoints').click(function() {

      $('#rewardspoints_div').slideToggle('');

  });



  $('#rewardspoints_close').click(function() {

      $('#rewardspoints_div').slideUp('');

  });







    

})(jQuery);



