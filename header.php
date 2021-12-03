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

		<button class="navbar-toggle" type="button" aria-label="Toggle navigation" title="Menu">
			<div class='bar1'></div>
	        <div class='bar2'></div>
	        <div class='bar3'></div>
		</button>

    	<nav class="site-nav">
    		<div class="site-nav-container">
	    		<div class="container-fluid">
	    			<div class="row">
	    				<div class="col col-md-4">
	    					<?php 
								wp_nav_menu( array(
									'theme_location' 	=> 'main-menu',
									'container'			=> false,
									'depth'				=> 1
								));
							?>
	    				</div>
	    				<div class="col col-md-4">
	    					<?php 
								wp_nav_menu( array(
									'theme_location' 	=> 'work-menu',
									'container'			=> false,
									'depth'				=> 1
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
