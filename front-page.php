<?php

/**
 * The front page template file
 */
?>

<?php get_header(); ?>

<?php $intro_bg_image = get_field('intro_bg_image'); ?>

<section class="section full-page site-intro" id="section_0">
	<div class="container-fluid container-heading">
		<div class="heading">
			<span class="cc1">My name is </span>
			<span class="cc2">Christopher Cosner. </span>
			<span class="cc3">I’m a creative person working in information technology.</span>
			<span class="cta-buttons"><a href="#section_1" class="btn btn-cta">Read my stories</a><a href="/live-work" class="btn btn-cta">See my live work</a></span>
		</div>

	</div>
	<div class="container-fluid container-bottom">
		<div class="bottom">
			<span class="me1">Email</span> <span class="me2"><a href="mailto:me@christophercosner.com">me@christophercosner.com</a></span>
		</div>
	</div>

	<?php if ($intro_bg_image) { ?>
		<div class="p-bg-image-container" <?php echo 'style="background-image:url(' . $intro_bg_image['url'] . ');"' ?: ''; ?>></div>
		<cite class="sr-only"><?php echo $intro_bg_image['alt']; ?></cite>
	<?php } ?>
</section>

<?php if (have_rows('projects')) : while (have_rows('projects')) : the_row();

		$post_id = get_sub_field('project');

		$proj_intro = get_field('project_intro', $post_id);
		$proj_scope = get_field('project_scope', $post_id);
		$post_title = get_post_field('post_title', $post_id);
		$post_slug = get_post_field('post_name', $post_id);
		$p_bg_image = get_field('p_background_image', $post_id);
		$p_bg_video = get_field('p_background_video', $post_id);

		$i = 1;

?>

		<section class="section full-page project-<?php echo $post_slug; ?>" id="<?php echo 'section_' . $i; ?>">
			<div class="container-fluid">
				<div class="row">
					<div class="col project-content-container">
						<div class="project-content fadeIn cssAnimate">
							<h2 class="project-title"><?php echo $post_title; ?></h2>
							<div class="project-scope"><?php echo $proj_scope; ?></div>
							<div class="project-intro"><?php echo $proj_intro ?: ''; ?></div>
							<a href="<?php echo get_permalink($post_id); ?>" class="read-more">Read More</a>
						</div>
					</div>
				</div>
			</div>

			<?php if ($p_bg_video) { ?>
				<div class="bg-video-container">
					<video autoplay muted loop <?php echo 'poster="' . $p_bg_image['url'] . '"' ?: ''; ?>>
						<source src="<?php echo $p_bg_video; ?>" type="video/mp4">
						<?php if ($p_bg_image) { ?>
							<img src="<?php echo $p_bg_image['url']; ?>">
						<?php } ?>
					</video>
				</div>
			<?php } elseif ($p_bg_image) { ?>
				<div class="p-bg-image-container" <?php echo 'style="background-image:url(' . $p_bg_image['url'] . ');"' ?: ''; ?>></div>
				<cite class="sr-only"><?php echo $p_bg_image['alt']; ?></cite>
			<?php } ?>
		</section>

<?php $i++;
	endwhile;
endif; ?>

<?php get_footer(); ?>