<?php
/**
 * The portfolio page template file
 */
?>

<?php get_header();

if ( have_rows('projects') ): while ( have_rows('projects') ) : the_row(); 

	$post_id = get_sub_field('project');

	$proj_intro = get_field('project_intro', $post_id);
	$proj_scope = get_field('project_scope', $post_id);
	$proj_logo = get_field('project_logo', $post_id);

	$post_title = get_post_field('post_title', $post_id);
	$post_slug = get_post_field('post_name', $post_id);

	$proj_bg_image = get_field('background_image', $post_id);
	$proj_bg_video = get_field('background_video', $post_id);

	?>

	<div class="section" id="project-<?php echo $post_slug; ?>" <?php if ( $proj_bg_image ) { ?>style="background-image:url('<?php echo $proj_bg_image; ?>');"<?php } ?>>
		<div class="project-logo-container">
			<?php if ( $proj_logo ) : ?><img src="<?php echo $proj_logo; ?>" class="project-logo"><?php endif; ?>
		</div>
		<div class="project-intro-container">
			<div class="row">
				
				<?php if ( $proj_intro ) : ?>
				<div class="project-intro">
					<h1><?php echo $post_title; ?></h1>
					<h2><?php echo $proj_scope; ?></h2>
					<?php echo $proj_intro; ?>
					<a href="<?php echo get_permalink($post_id); ?>" class="read-more">Read More</a>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( $proj_bg_video ) { ?>
		<div class="video-container">
			<video autoplay muted loop poster="">
				<source src="<?php echo $proj_bg_video; ?>" type="video/mp4">
			</video>
		</div>
		<?php } ?>
	</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
