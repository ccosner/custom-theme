<?php
/**
 * The single project template file
 */
?>

<?php get_header();?>

<div class="post">
	<div class="container-fluid">
		<div class="heading">
			<h1 class="project-title"><?php the_title(); ?></h1>
		</div>
		<div class="content">
			<?php the_content(); ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
