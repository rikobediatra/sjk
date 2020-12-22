jQuery(function ($) {

    // Add support for keyboard accessibility.
    $(document).on('mousemove', 'body', function (e) {
        $(this).removeClass('keyboard-nav-on');
    });
    $(document).on('keydown', 'body', function (e) {
        if (e.which == 9) {
            $(this).addClass('keyboard-nav-on');
        }
    });

    /**
     * Captilize the input[value] text.
     */
    var str = $(document).find('#wp-travel-enquiry-submit').val();
    if ('undefined' !== typeof str) {
        str = str.toLowerCase().replace(/\b[a-z]/g, function (letter) {
            return letter.toUpperCase();
        });
        $(document).find('#wp-travel-enquiry-submit').val(str);
    }

    /**
     * Focus fix in mobile navigation.
     */
    // $(document).on('focus', '#close-navigation-bar', function () {
    //     console.log('test');
    // });

    //scroll down
    $(".scroll").on('click', function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {
                window.location.hash = hash;
            });
        }
    });
    //   End of scroll down

    /**
     * Custom configuration for slick slider.
     */
    function travelJoySlickSliderConfig() {
        // slick slider
        $(".vertical-center-4").slick({
            dots: true,
            vertical: true,
            centerMode: true,
            slidesToShow: 4,
            slidesToScroll: 2
        });
        $(".vertical-center-3").slick({
            dots: true,
            vertical: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".vertical-center-2").slick({
            dots: true,
            vertical: true,
            centerMode: true,
            slidesToShow: 2,
            slidesToScroll: 2
        });
        $(".vertical-center").slick({
            dots: true,
            vertical: true,
            centerMode: true,
        });
        $(".vertical").slick({
            dots: true,
            vertical: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        // $(".center").slick({
        //     dots: true,
        //     infinite: true,
        //     centerMode: true,
        //     slidesToShow: 5,
        //     slidesToScroll: 3
        // });
        $(".variable").slick({
            dots: true,
            infinite: true,
            variableWidth: true
        });
        $(".lazy").slick({
            lazyLoad: 'ondemand', // ondemand progressive anticipated
            infinite: true
        });
        //   End of slick slider
    }
    travelJoySlickSliderConfig();

    function travelJoyToggleMblNavMenu(widthSize) {
        var el = document.getElementById("mySidenav");
        el.style.width = widthSize;
    }

    $(document).on('focus', '#mySidenav', function() {
        travelJoyToggleMblNavMenu('100%');
    });

    $(document).on('blur', '#mySidenav', function() {
        travelJoyToggleMblNavMenu('0');
    });

    //Start of mobile navigation bar
    $(document).on('click', '.toggle#open-navigation-bar', function () {
        travelJoyToggleMblNavMenu('100%');
    });

    $(document).on('click', 'a#close-navigation-bar', function () {
        travelJoyToggleMblNavMenu('0');
    });
    //End of mobile navigation bar

});