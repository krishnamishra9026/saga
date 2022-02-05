$(window).scroll(function(){
    if ($(this).scrollTop() > 50) {
       $('#headerMenu .menuBG').addClass('asas');
       // $('#headerMenu').addClass('fixed-top');
    } else {
       $('#headerMenu .menuBG').removeClass('asas');
       // $('#headerMenu').removeClass('fixed-top');
    }
});

// $(window).scroll(function(){
//     if ($(this).scrollTop() > 50) {
//        $('#headerMenu .topStrip').slideUp('hide');
//     } else {
//        $('#headerMenu .topStrip').slideDown('hide');
//     }
// });

// search  bar hide show
$(document).ready(function() {
	$('#show-searchBar').click(function() {
		$('#showSearchDiv').addClass('show');
	});

	$('#hide-searchBar').click(function() {
		$('#showSearchDiv').removeClass('show');
	});
});


// home page slider function
$(document).ready(function() {
	$('#home-slider').owlCarousel({
		items:1,
		// merge:true,
		// nav:true,
		loop:true,
		margin: 0,
		Autoplay: true,
		// rtl:true,
		autoplay:true,
		autoplayTimeout:5000,
		// autoplayHoverPause:false,
		autoplayHoverPause:true,
		// animateOut: 'slideOutDown',
	    // animateIn: 'flipInX',
		// margin:10,
		// video:true,
		// center:true,
		// responsive:{
		// 	0:{
		// 		items:1,
		// 	},
		// 	600:{
		// 		items:1,
		// 	},
		// 	1000:{
		// 		items:1,
		// 	}
		// }
	});
});


$(document).ready(function() {
	$('#customers-testimonials').owlCarousel({
        loop: true,
        center: true,
        items: 3,
        margin: 0,
        autoplay: true,
        dots:true,
        autoplayTimeout: 8500,
        smartSpeed: 450,
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 2
          },
          1170: {
            items: 3
          }
        }
    });
});


$(document).ready(function() {
	$('#team').owlCarousel({
		items:1,
		// merge:true,
		nav:true,
		loop:true,
		Autoplay: true,
		autoplay:true,
		dots: false,
		margin:18,
		autoplayTimeout:10000,
		autoplayHoverPause:true,
		responsive:{
			0:{
				items:2,
			},
			480:{
				items:2,
			},
			768:{
				items:2,
			},
			1000:{
				items:3,
			}
		}
	});
});

$(document).ready(function() {
	$('#testimonial').owlCarousel({
		items:1,
		// merge:true,
		nav:true,
		loop:true,
		Autoplay: true,
		autoplay:true,
		dots: false,
		// margin:18,
		autoplayTimeout:2000,
		autoplayHoverPause:true,
		responsive:{
			0:{
				items:1,
			},
			600:{
				items:1,
			},
			1000:{
				items:1,
			}
		}
	});
});

$(document).ready(function() {
	$('#blog').owlCarousel({
		items:1,
		// merge:true,
		nav:false,
		loop:true,
		Autoplay: true,
		autoplay:true,
		dots: true,
		margin:10,
		autoplayTimeout:10000,
		autoplayHoverPause:true,
		responsive:{
			0:{
				items:1,
			},
			600:{
				items:3,
			},
			1000:{
				items:3,
			}
		}
	});
});


// header hover drop down menu
$(document).ready(function() {
	$('.dropdown').hover(function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(150).fadeIn(150);
	}, function() {
	  $(this).find('.dropdown-menu').stop(true, true).delay(150).fadeOut(150);
	});
});
