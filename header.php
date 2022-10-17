<?php

/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php wp_head(); ?>

    <script src="https://kit.fontawesome.com/06416d0fe7.js" crossorigin="anonymous"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7ENT1JTXWM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-7ENT1JTXWM');
    </script>

    <!-- Hotjar Tracking Code for https://christophercosner.com/ -->
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 2758827,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>

</head>

<body <?php body_class(); ?>>

    <button class="navbar-toggle" type="button" aria-label="Toggle navigation" title="Menu">
        <div class="icon-bar"></div>
        <div class="icon-bar"></div>
        <div class="icon-bar"></div>
    </button>

    <nav class="site-nav">
        <div class="site-nav-container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col col-md-4 col-sm-6">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'     => 'main-menu',
                            'container'            => false,
                            'depth'                => 1
                        ));
                        ?>
                    </div>
                    <div class="col col-md-4 col-sm-6">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'     => 'work-menu',
                            'container'            => false,
                            'depth'                => 1
                        ));
                        ?>
                    </div>
                </div>



            </div>
            <div class="container-fluid container-bottom">
                <div class="bottom">
                    <span class="me1">Email</span> <span class="me2"><a href="mailto:me@christophercosner.com">me@christophercosner.com</a></span>
                </div>
            </div>
        </div>
    </nav>

    <main id="main" tabindex="-1">