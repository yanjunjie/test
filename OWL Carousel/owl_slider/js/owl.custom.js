
//home top slider
jQuery(function () {
    $(".owl-carousel-certificate").owlCarousel({
        loop:true,

        animateOut: 'slideOutUp', /* animateOut: 'slideOutUp', animateIn: 'slideInUp' for vertical slider*/
        animateIn: 'slideInUp',
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        },
        autoplay:true,
        autoplayTimeout:4000,
        autoplayHoverPause:false,
        dots:false,

    });

});

//Award
jQuery(function () {
    $(".owl-carousel-award").owlCarousel({
        loop:true,

        animateOut: 'slideOutUp', /* animateOut: 'slideOutUp', animateIn: 'slideInUp' for vertical slider*/
        animateIn: 'slideInUp',
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        },
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:false,
        dots:false,

    });

});
