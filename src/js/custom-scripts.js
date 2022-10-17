(function ($) {
    // Automatically add external link icon and screen reader text
    $(function () {
        $('a')
            .not('a.no-external')
            .filter(function () {
                return this.hostname && this.hostname !== location.hostname;
            })
            .addClass('external')
            .append(
                " <span class='visually-hidden'>external link</span> <i class='fas fa-external-link-alt fa-xs' title='external link'></i>"
            );
    });

    // Main nav button
    $(function () {
        var previousScroll = 0;
        $(window).on('scroll', function () {
            var currentScroll = $(this).scrollTop();
            if (
                currentScroll < 200 ||
                window.innerHeight + window.scrollY >=
                    document.body.scrollHeight
            ) {
                showNav();
            } else if (
                currentScroll > 0 &&
                currentScroll < $(document).height() - $(window).height()
            ) {
                if (currentScroll > previousScroll) {
                    hideNav();
                } else {
                    showNav();
                }
                previousScroll = currentScroll;
            }
            if ( currentScroll > 50 ) {
                $('.look').addClass('is-hidden');
            }
        });

        function hideNav() {
            $('html:not(.navbar-on) .navbar-toggle').removeClass('is-visible').addClass('is-hidden');
        }

        function showNav() {
            $('.navbar-toggle')
                .removeClass('is-hidden')
                .addClass('is-visible')
                .addClass('scrolling');
        }

        $('.navbar-toggle').on('click', function () {
            $('html').toggleClass('navbar-on');
            $('nav').toggleClass('nav-show');
        });

    });

    // Waypoint scroll
    $(function () {
        let waypoint = $('main section').waypoint({
            element: this,
            handler: function (direction) {
                let section = this.element;
                let next = this.element.nextElementSibling;
                if (direction == 'up') {
                    $('#scroll').attr('href', '#' + section.id);
                } else if (next) {
                    $('#scroll').attr('href', '#' + next.id);
                } else {
                    $('#scroll').attr('href', '#footer');
                }
            },
            offset: '50%',
        });
    });

    // uses HTML5 history API to manipulate the location bar - prevents #hash from showing when you click the scroll button
    $(function () {
        function removeHash() {
            history.replaceState(
                '',
                document.title,
                window.location.origin +
                    window.location.pathname +
                    window.location.search
            );
        }
        const menuBtn = $('#scroll');
        menuBtn.on('click', () => {
            setTimeout(() => {
                removeHash();
            }, 5);
        });
    });

   
})(jQuery);
