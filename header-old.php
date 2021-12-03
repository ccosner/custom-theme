<?php
/**
 * Header
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<nav class="navbar">
			<a href="#main" class="sr-only" role="navigation" aria-label="Skip navigation">Skip to the main content</a>
			<div class="container-fluid">

				<a class="mr-auto branding" href="<?php echo home_url(); ?>"></a>

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="sr-only">Menu toggle</span><i class="fas fa-bars" title="Menu toggle"></i>
				</button>
				
				<div class="collapse navbar-collapse" id="main-menu" aria-label="Main menu">
					<?php 
						wp_nav_menu( array(
							'theme_location' 	=> 'main-menu',
							'container' 		=> false,
							'menu_class'      	=> 'navbar-nav',
							'depth'				=> 2,
							'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback',
            				'walker'            => new WP_Bootstrap_Navwalker()
						) );
					?>
				</div>

			</div>
		</nav>
	
	<main id="main" tabindex="-1">
