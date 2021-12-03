<?php
/*
Metadata referenced in functions.php
*/
global $wp;
global $post;
setup_postdata($post);

// Decide which image to use for og:image
if ( has_post_thumbnail() ) {

	// use featured image
	$og_image = get_the_post_thumbnail_url();

} elseif ( get_theme_mod('og_image_setting') ) {

	// use og:image in customizer
	$og_image = get_theme_mod('og_image_setting');

} else {

	// use the generic state template image
	$og_image = get_parent_theme_file_uri('images/og-image.jpg');

}
?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Generated at https://realfavicongenerator.net/ -->
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_theme_file_uri('/favicon/apple-touch-icon.png'); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_theme_file_uri('/favicon/favicon-32x32.png'); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_theme_file_uri('/favicon/favicon-16x16.png'); ?>">
<link rel="manifest" href="<?php echo get_theme_file_uri('/favicon/site.webmanifest'); ?>">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<!-- Security -->
<meta http-equiv="Content­-Security-­Policy" content="script­src 'self';">

<?php if ( is_front_page() ) : ?>

	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">

	<!-- Begin Open Graph data -->
	<meta property="og:title" content="<?php echo get_bloginfo('name') ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo esc_url(home_url()); ?>" />
	<meta property="og:image" content="<?php echo esc_url($og_image); ?>" />
	<meta property="og:description" content="<?php echo get_bloginfo('description'); ?>" />
	<!-- End Open Graph data -->

<?php elseif ( is_singular() ) : ?>
	
	<meta name="description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />

	<!-- Twitter Card data -->
	<meta name="twitter:card" content="summary">

	<!-- Begin Open Graph data -->
	<meta property="og:title" content="<?php echo get_the_title(); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
	<meta property="og:image" content="<?php echo esc_url($og_image); ?>" />
	<meta property="og:description" content="<?php echo strip_tags(get_the_excerpt()); ?>" />
	<!-- End Open Graph data -->

<?php elseif ( is_archive() ) :
	// Get the archive url with trailing slash
	$current_url = home_url( add_query_arg( array(), $wp->request ) ) . '/'; ?>

	<meta name="description" content="<?php echo strip_tags(category_description()); ?>" />

	<!-- Twitter Card data -->
	<meta name="twitter:card" value="summary">

	<!-- Begin Open Graph data -->
	<meta property="og:title" content="<?php echo single_cat_title(); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:url" content="<?php echo esc_url($current_url); ?>" />
	<meta property="og:image" content="<?php echo esc_url($og_image); ?>" />
	<meta property="og:description" content="<?php echo strip_tags(category_description()); ?>" />
	<!-- End Open Graph data -->

<?php endif; ?>