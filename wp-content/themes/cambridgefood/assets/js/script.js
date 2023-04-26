/*-------------------------------

	STICKY_MENU.JS

    -------------------------------*/
    $(window).on('scroll', function () {
        var wSize = $(window).width();
        if ($(this).scrollTop() > 100) {
            $('.main-nav').addClass("sticky_animate");
        }
        else {
            $('.main-nav').removeClass("sticky_animate");
        }
    });


    $( document ).ready(function() {
        $('.desclaimer_box_show').click(function(){
            $('.desclaimer_content').hide();
            $('.desclaimer_content').removeClass('show');
            $(this).closest('.competition-list').find('.desclaimer_content').show();
            $(this).closest('.competition-list').find('.desclaimer_content').addClass('show');
            
        });
        $('.desclaimer_box_hide').click(function(){

            $(this).closest('.competition-list').find('.desclaimer_content').hide();
            $(this).closest('.competition-list').find('.desclaimer_content').removeClass('show');

        //$('.desclaimer_content').hide();
        // $('.desclaimer_content').removeClass('show');
    });

    });


/*-------------------------------

	SLIDER.JS

    -------------------------------*/
    $( document ).ready(function() {

    // NAVIGATION_MENU_.JS

    $('.stellarnav').stellarNav({
        theme: 'dark',
        breakpoint: 1024,
        position: 'right',
        closingDelay: 50,
        menuLabel: '', 
        phoneBtn: '',
        locationBtn: '',
        closeLabel: '',
    });

    $(".hero-slider").each(function(){
        $(this).owlCarousel({
            loop:true,
            margin:0,
            nav:false,
            autoplay:true,
            dots:false,
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
            }
        });
    });

    $(".box-slider").each(function(){
        $(this).owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            autoplay:true,
            autoplayTimeout:3000,
            responsive:{
                0:{
                    items:2
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });
    });

    $(".mc_box_slider").each(function(){
        $(this).owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            autoplay:true,
            autoplayTimeout:3000,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:3
                }
            }
        });
    });
    
    $(".contact-slider").each(function(){
        $(this).owlCarousel({
            loop:true,
            margin:0,
            nav:false,
            dots:true,
            items:5,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                768:{
                    items:3
                },
                992:{
                    items:4
                },
                1024:{
                    items:5
                }
            }
        });
    });

    $(".tips-slider").each(function(){
        $(this).owlCarousel({
            loop:true,
            margin:0,
            nav:true,
            dots:false,
            items:4,
            autoplay:false,
            autoplayTimeout:3000,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                768:{
                    items:3
                },
                1024:{
                    items:3
                },
                1366:{
                    items:4
                }
            }
        });
    });

    // Tabs JS

    // $(".cf_vtabs").champ({
    //     plugin_type: "tab",
    //     side: "left",
    //     active_tab: "2",
    //     controllers: "false"
    // });

    // Seclect JS
    // $('.selectpicker').selectpicker();
    // $('#wpsl-category-list').selectpicker();
    // $('#wpsl-category-list').selectpicker();
    


});


/*-------------------------------

        SCROLLBAR.JS

        -------------------------------*/

        $( document ).ready(function() {

            (function($){
                $(window).on("load",function(){
                    $('.scrollcontent').mCustomScrollbar({
                // autoHideScrollbar:true,
                theme:"rounded"
            });
                });
            })(jQuery);

            $('#area').val($('.form-check-input:checked').val());
            $('.form-check-input').click(function(){
                $('#area').val($(this).val());
            });
            
            $('#enqFormType').val($('.form-type-input:checked').val());
            $('.form-type-input').click(function(){
                $('#enqFormType').val($(this).val());
            });

        });

/*-------------------------------

        SLICK SLIDER.JS

        -------------------------------*/
        $( document ).ready(function() {
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });
            $('.slider-nav').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                dots: false,
                arrows: true,
                autoplay: true,
                focusOnSelect: true,
                responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
                ]
            });
        });
        $( document ).ready(function() {
            $('.community-slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.community-slider-nav',
                adaptiveHeight: true
            });
            $('.community-slider-nav').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                asNavFor: '.community-slider-for',
                dots: false,
                arrows: true,
                autoplay: true,
                focusOnSelect: true,
                responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                }
                ]
            });
        });



