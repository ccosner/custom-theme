<?php

/**
 * The single project template file
 */
?>

<?php get_header();

// get background image url
$proj_intro = get_field('project_intro');
$proj_scope = get_field('project_scope');
$proj_link = get_field('project_link');
$bg_image = get_field('background_image');
$bg_video = get_field('background_video');
?>
<div class="content" id="content">
	<div class="container-fluid">
		<div class="heading">
			<div class="row">
				<div class="col col-md-6 offset-md-3">
					<h1 class="project-title"><?php the_title(); ?></h1>
					<div class="project-scope"><?php echo $proj_scope ?: ''; ?></div>
					<div class="project-intro"><?php echo $proj_intro ?: ''; ?></div>
				</div>
			</div>
		</div>
		<?php the_content(); ?>
	</div>
</div>

<?php if ($bg_video) { ?>
	<div class="bg-video-container">
		<video autoplay muted loop poster="">
			<source src="<?php echo $bg_video; ?>" type="video/mp4">
		</video>
	</div>
<?php } elseif ($bg_image) { ?>
	<div class="bg-image-container" <?php echo 'style="background-image:url(' . $bg_image . ');"' ?: ''; ?>></div>
<?php } ?>


<?php get_footer(); ?>