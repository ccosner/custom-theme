(function ($) {

    // Automatically add external link icon and screen reader text
    $('a').not('a.no-external').filter(function () {
        return this.hostname && this.hostname !== location.hostname;
    }).addClass('external').append(" <span class='sr-only'>external link</span> <i class='fas fa-external-link-alt fa-xs' title='external link'></i>");

    // Smooth scroll
    var scroll = new SmoothScroll('a[href*="#"]', {

        // Selectors
        ignore: '[data-scroll-ignore]', // Selector for links to ignore (must be a valid CSS selector)
        header: null, // Selector for fixed headers (must be a valid CSS selector)
        topOnEmptyHash: false, // Scroll to the top of the page for links with href="#"

        // Speed & Easing
        speed: 500, // Integer. How fast to complete the scroll in milliseconds
        clip: true, // If true, adjust scroll distance to prevent abrupt stops near the bottom of the page
        easing: 'easeInOutCubic', // Easing pattern to use

        // History
        updateURL: false, // Update the URL on scroll
        popstate: true, // Animate scrolling with the forward/backward browser buttons (requires updateURL to be true)

        // Custom Events
        emitEvents: true // Emit custom events
    });

    // Main nav
    $(function () {
        $('.navbar-toggle').on('click', function () {
            $('html').toggleClass('navbar-on');
            $('nav').toggleClass('nav-show');
        });
    });

    $(function () {
        var previousScroll = 0;
        $(window).on('scroll', function () {
            var currentScroll = $(this).scrollTop();
            if ((currentScroll < 200) || ((window.innerHeight + window.scrollY) >= document.body.scrollHeight)) {
                showNav();
            } else if (currentScroll > 0 && currentScroll < $(document).height() - $(window).height()) {
                if (currentScroll > previousScroll) {
                    hideNav();
                } else {
                    showNav();
                }
                previousScroll = currentScroll;
            }
        });

        function hideNav() {
            $('.navbar-toggle').removeClass("is-visible").addClass("is-hidden");
        }

        function showNav() {
            $('.navbar-toggle').removeClass("is-hidden").addClass("is-visible").addClass("scrolling");
        }
    });

    $(function() {
        // Optimalisation: Store the references outside the event handler:
        var $window = $(window);

        function checkWidth() {
            var windowsize = $window.width();
            if (windowsize < 992) {

                // Mobile

            } else {

                // Desktop

                var waypoint = $('#section_1').waypoint({
                    handler: function(direction) {
                        if (direction == 'up') {
                            $('body').removeClass('section_1').addClass('section_0');
                            $('#scroll').attr('href', '#section_1');
                        } else {
                            $('body').removeClass('section_0').addClass('section_1');
                            $('#scroll').attr('href', '#section_2');
                        }
                    },
                    offset: '50%'
                });

                var waypoint = $('#section_2').waypoint({
                    handler: function(direction) {
                        if (direction == 'up') {
                            $('body').removeClass('section_2').addClass('section_1');
                            $('#scroll').attr('href', '#section_2');
                        } else {
                            $('body').removeClass('section_1').addClass('section_2');
                            $('#scroll').attr('href', '#section_3');
                        }
                    },
                    offset: '50%'
                });

            }
        }

        // Execute on load
        checkWidth();

        // Bind event listener
        $(window).on('resize', checkWidth);

    });

})(jQuery);