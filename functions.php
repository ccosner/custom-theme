<?php

// Setup some things
function cc_setup() {
    // Add default posts and comments RSS feed links to head.
    //add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Set custom image size
    //add_image_size( 'card-image', 696, 464, array( 'center', 'top' ) );
    //add_image_size( 'publication', 150, 150 );
    //add_image_size( 'content-image', 730 );

    // This theme uses wp_nav_menu().
    register_nav_menus(array(
        'main-menu'        => __('Main Menu'),
        'work-menu'        => __('Work Menu')
    ));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    // Add excerpt support
    add_post_type_support('page', 'excerpt');

    // Register Custom Navigation Walker
    if (!file_exists(get_template_directory() . '/wp-bootstrap-navwalker.php')) {
        // file does not exist... return an error.
        return new WP_Error('wp-bootstrap-navwalker-missing', __('It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker'));
    } else {
        // file exists... require it.
        require_once get_template_directory() . '/wp-bootstrap-navwalker.php';
    }
}
add_action('after_setup_theme', 'cc_setup');

// Enqueue Styles and Scripts
function cc_styles_and_scripts() {

    // Main stylesheet
    wp_enqueue_style('style', get_stylesheet_uri(), array(), '1.0');

    // Google fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet');

    // jQuery packaged with WordPress
    wp_enqueue_script('jquery');

    // Custom Scripts
    wp_enqueue_script('scripts', get_theme_file_uri('scripts.js'), array('jquery'));

}
add_action('wp_enqueue_scripts', 'cc_styles_and_scripts');

// Enqueue Admin Styles and Scripts
function cc_admin_styles_and_scripts() {
    wp_enqueue_script('admin-scripts', get_theme_file_uri('/admin/admin-scripts.js'), array('jquery'), null, true);
    wp_enqueue_style('admin-styles', get_theme_file_uri('/admin/admin-styles.css'));
}
add_action('admin_enqueue_scripts', 'cc_admin_styles_and_scripts');

// Adds classes body element to page/blog specific css
function cc_body_class($classes) {
    if (is_singular('page')) {
        global $post;
        $classes[] = 'page-' . $post->post_name;
    }
    if (is_singular('project')) {
        global $post;
        $classes[] = 'project-' . $post->post_name;
    }
    if (is_multisite()) {
        $classes[] = 'blog-' . get_current_blog_id();
    }
    return $classes;
}
add_filter('body_class', 'cc_body_class');

// Register dynamic sidebars (widget areas)
function cc_widgets_init() {
    register_sidebar(array(
        'name'          => 'Footer',
        'id'            => 'footer',
        'description'   => 'This is the widget area in the footer.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title visually-hidden">',
        'after_title'   => '</h3>',
    ));
    register_sidebar(array(
        'name'          => 'Sidebar',
        'id'            => 'sidebar',
        'description'   => 'This is the sidebar.',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="menu-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'cc_widgets_init');

// Breadcrumbs
if (function_exists('bcn_display')) :
    define('BCN_SETTINGS_USE_NETWORK', true);
endif;

// Add Metadata to header
function cc_metadata() {
    require get_parent_theme_file_path('metadata.php');
}
add_action('wp_head', 'cc_metadata', 1, 1);

// Remove archives: Author, Date
function cc_remove_wp_archives() {
    if (is_author() || is_date()) {
        global $wp_query;
        $wp_query->set_404();
    }
}
add_action('template_redirect', 'cc_remove_wp_archives');

/*
// Allow SVG upload in media library
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
*/

// Modifies the_excerpt()
//
// Replaces the excerpt "Read More" text by a link
function cc_excerpt_more($more) {
    global $post;
    return '...<br><a class="moretag" href="' . get_permalink($post->ID) . '">Read more... <span class="visually-hidden">' . get_the_title($post->ID) . '</span></a>';
}
add_filter('excerpt_more', 'cc_excerpt_more');
//
// Edit excerpt word length
function cc_excerpt_length($length) {
    return 70;
}
add_filter('excerpt_length', 'cc_excerpt_length', 999);

// Replace wp_trim_excerpt with a custom filter to allow for more modification
function cc_excerpt_trim($text) {
    $raw_excerpt = $text;
    if ('' == $text) {
        //Retrieve the post content. 
        $text = get_the_content('');

        //Delete all shortcode tags from the content. 
        $text = strip_shortcodes($text);

        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]&gt;', $text);

        $allowed_tags = '<a><p>'; // modify to allow HTML tags
        $text = strip_tags($text, $allowed_tags);

        $excerpt_end = '[...]'; // default value
        $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

        $excerpt_word_count = 55; // default value
        $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);

        $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if (count($words) > $excerpt_length) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
        } else {
            $text = implode(' ', $words);
        }
    }
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'cc_excerpt_trim');

// Disable comments - https://gist.github.com/mattclements/eab5ef656b2f946c4bfb
//
// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'df_disable_comments_post_types_support');

// Close comments on the front-end
function df_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);

// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
    $comments = array();
    return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);

// Remove comments page in menu
function df_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');

// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');

// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');

// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'df_disable_comments_admin_bar');

// Remove comments from toolbar
function df_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action('wp_before_admin_bar_render', 'df_admin_bar_render');

/*
// Post type admin page customizations
//
	// Add publications column header in admin
	function publication_table_head( $columns ) {
		unset($columns);
		$columns['cb'] = '<input type="checkbox" />';
	    $columns['title']  = 'Title';
	    $columns['publication_category']  = 'Category';
	    $columns['publication_year']  = 'Publication Year';
	    //$columns['publication_filter']  = 'publication Filter';
	    return $columns;
	}
	add_filter('manage_publication_posts_columns', 'publication_table_head');

	// Organize the publications in admin
	function publication_table_content( $column, $post_id ) {
	    if ($column == 'publication_year') {
	        $year = get_field('publication_year');
	        echo $year;
	    }
	    if ($column == 'publication_category') {
			$terms = wp_get_post_terms($post_id, 'publication_tax');
			$term = $terms[0];
			echo $term->name;
	    }
	}
	add_action( 'manage_publication_posts_custom_column', 'publication_table_content', 10, 2 );

	// Make publications sortable in admin
	function publication_sortable_columns( $columns ) {
		$columns['publication_year'] = 'publication year';
		return $columns;
	}
	add_filter( 'manage_edit-publication_sortable_columns', 'publication_sortable_columns' );

	// Order publications by date when sorting
	function publication_posts_orderby( $query ) {
		if ( ! is_admin() || ! $query->is_main_query() ) {
	    	return;
		}
		if ( 'publication_year' === $query->get( 'orderby') ) {
	    	$query->set( 'orderby', 'meta_value' );
	    	$query->set( 'meta_key', 'publication_year' );
	    	$query->set( 'meta_type', 'DATETIME' );
		}
	}
	add_action( 'pre_get_posts', 'publication_posts_orderby' );

	// Order publication by publication date by default
	function publication_posts_default_order( $query ){
	    if ( $query->get( 'post_type' ) == 'publication' ) {
	        if ( $query->get( 'orderby' ) == '' ) {
	            $query->set( 'orderby', 'meta_value' );
	        }
	        if ( $query->get( 'meta_key') == '' ) {
	        	$query->set( 'meta_key', 'publication_year' );
	        }
	        if ( $query->get( 'order' ) == '' ) {
	        	$query->set( 'order','desc' );
	        }
	    }
	}
	add_action('pre_get_posts','publication_posts_default_order');

	// Adds filter dropdown to publication list
	function filter_posts_by_taxonomies( $post_type, $which ) {

		// Apply this only on a specific post type
		if ( 'publication' !== $post_type )
			return;

		// A list of taxonomy slugs to filter by
		$taxonomies = array( 'publication_tax' );

		foreach ( $taxonomies as $taxonomy_slug ) {

			// Retrieve taxonomy data
			$taxonomy_obj = get_taxonomy( $taxonomy_slug );
			$taxonomy_name = $taxonomy_obj->labels->name;

			// Retrieve taxonomy terms
			$terms = get_terms( $taxonomy_slug );

			// Display filter HTML
			echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
			echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
			foreach ( $terms as $term ) {
				printf(
					'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
					$term->slug,
					( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
					$term->name,
					$term->count
				);
			}
			echo '</select>';
		}

	}
	add_action( 'restrict_manage_posts', 'filter_posts_by_taxonomies' , 10, 2);

	// remove date filter
	add_filter('months_dropdown_results', '__return_empty_array');

	// Change placeholder text in title field for iClips
	function change_default_title( $title ){
	    $screen = get_current_screen();

	    // For CPT 1
	    if  ( 'iclips' == $screen->post_type ) {
	        $title = 'Enter date in format: MONTH DD, YYYY';
	    }

	    return $title;
	}
	add_filter( 'enter_title_here', 'change_default_title' );
*/

function cc_related_posts() {

    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category($post_id);

    if ($categories && !is_wp_error($categories)) {

        foreach ($categories as $category) {

            array_push($cat_ids, $category->term_id);
        }
    }

    $current_post_type = get_post_type($post_id);

    $args = array(
        'category__and' => $cat_ids,
        'post_type' => $current_post_type,
        'posts_per_page' => '-1',
        'post__not_in' => array($post_id)
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {

?>
        <div class="container-fluid related-posts">
            <div class="row">
                <div class="col col-md-3">
                    <h3>Related Work</h3>
                </div>

                <?php

                while ($query->have_posts()) {

                    $query->the_post();

                    $project_card = get_field('project_card');

                ?>
                    <div class="col col-md-3">
                        <a href="<?php the_permalink(); ?>" class="project-card">
                            <?php the_title(); ?>
                        </a>
                    </div>
                <?php

                }
                ?>
            </div>
        </div>
<?php

    }

    wp_reset_postdata();
}
/*
function cc_not_related_posts() {

    $post_id = get_the_ID();
    $cat_ids = array();
    $categories = get_the_category( $post_id );
 
    if ( $categories && !is_wp_error( $categories ) ) {
 
        foreach ( $categories as $category ) {
 
            array_push( $cat_ids, $category->term_id );
 
        }
 
    }

    $current_post_type = get_post_type( $post_id );

    $not_cat = $cat_ids[0];
     
	$args = array(
	    'cat' => -$not_cat,
	    'post_type' => $current_post_type,
	    'posts_per_page' => '-1',
	    'post__not_in' => array( $post_id )
	);

	$query = new WP_Query( $args );
 
	if ( $query->have_posts() ) {
	 
	    ?>
	    <div class="container-fluid related-posts">
	        <div class="row">
	        	<div class="col">
	        		<h3>Other Work</h3>
	        	</div>
	          
    			 <?php

	                while ( $query->have_posts() ) {
	 
	                    $query->the_post();

	                    $project_card = get_field('project_card');
	 
	                    ?>
	                    <div class="col">
	                        <a href="<?php the_permalink(); ?>" class="project-card">
	                        	<img width="800px" height="450px" src="<?php echo $project_card['url']; ?>" alt="<?php echo $project_card['alt']; ?>">
	                        </a>
	                    </div>
	                    <?php
	 
	                }
	 
	            ?>
    		</div>
	    </div>
	    <?php
	 
	}
	 
	wp_reset_postdata();
 
}
*/
